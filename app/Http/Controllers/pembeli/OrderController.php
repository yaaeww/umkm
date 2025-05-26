<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Produk;
use App\Models\Order;
use App\Models\Keranjang;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderSuccessMail;

class OrderController extends Controller
{
    protected function hitungHargaSetelahDiskon(Produk $produk)
    {
        if (
            $produk->diskon &&
            $produk->diskon->persen_diskon > 0 &&
            now()->between($produk->diskon->tanggal_mulai, $produk->diskon->tanggal_berakhir)
        ) {
            return $produk->harga - ($produk->harga * $produk->diskon->persen_diskon / 100);
        }

        return $produk->harga;
    }

    public function showForm($produkId)
    {
        $produk = Produk::with('diskon')->findOrFail($produkId);
        $userId = Auth::id();

        $keranjang = Keranjang::where('produk_id', $produkId)
            ->where('user_id', $userId)
            ->first();

        $quantity = $keranjang ? $keranjang->jumlah : 1;
        $harga_diskon = $this->hitungHargaSetelahDiskon($produk);
        $total_harga = $harga_diskon * $quantity;

        return view('pembeli.order', compact('produk', 'quantity', 'harga_diskon', 'total_harga'));
    }

    public function konfirmasiPembelian($produk_id, $quantity)
    {
        $produk = Produk::with('diskon')->findOrFail($produk_id);
        $harga_diskon = $this->hitungHargaSetelahDiskon($produk);
        $total_harga = $harga_diskon * $quantity;

        return view('pembeli.order', compact('produk', 'quantity', 'harga_diskon', 'total_harga'));
    }

    public function checkout(Request $request)
    {
        $produk = Produk::with('diskon')->findOrFail($request->produk_id);
        $quantity = intval($request->jumlah);

        if ($produk->stok < $quantity) {
            return back()->with('error', 'Stok produk tidak mencukupi.');
        }

        $harga_diskon = $this->hitungHargaSetelahDiskon($produk);
        $total_harga = $harga_diskon * $quantity;

        $order = Order::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'produk_id' => $produk->id,
                'status' => 'pending',
            ],
            [
                'jumlah' => $quantity,
                'total_harga' => $total_harga,
                'name' => $request->name,
                'phone' => $request->phone,
                'alamat' => $request->alamat,
                'stok_dikurangi' => false,
                'order_id_midtrans' => $request->order_id_midtrans ?? 'ORDER-' . uniqid(),
            ]
        );

        if (!$order->snap_token) {
            $this->setMidtransConfig();
            $order->snap_token = Snap::getSnapToken($this->buildMidtransParams($order));
            $order->save();
        }

        return view('pembeli.checkout', [
            'snapToken' => $order->snap_token,
            'order' => $order,
        ]);
    }

    public function retryPembayaran($order_id_midtrans)
    {
        $order = Order::where('order_id_midtrans', $order_id_midtrans)
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->firstOrFail();

        if (!$order->snap_token) {
            $this->setMidtransConfig();
            $order->snap_token = Snap::getSnapToken($this->buildMidtransParams($order));
            $order->save();
        }

        return view('pembeli.pending', [
            'order' => $order,
            'snapToken' => $order->snap_token,
        ]);
    }

    public function pending($order_id_midtrans)
{
    $order = Order::where('order_id_midtrans', $order_id_midtrans)->firstOrFail();

    // Cek hak akses user
    if ($order->user_id !== Auth::id()) {
        abort(403, 'Akses tidak diizinkan');
    }

    $this->setMidtransConfig();

    try {
        $status = \Midtrans\Transaction::status($order_id_midtrans);
        $transactionStatus = $order->status;

        // Proses hanya jika order status masih pending
        if ($order->status === 'pending') {
            if (in_array($transactionStatus, ['capture', 'settlement'])) {
                if (!$order->stok_dikurangi) {
                    $produk = Produk::find($order->produk_id);
                    if ($produk && $produk->stok >= $order->jumlah) {
                        $produk->stok -= $order->jumlah;
                        $produk->save();
                        $order->stok_dikurangi = true;
                    }
                }

                $order->status = 'complete';
                $order->save();

                return redirect()->route('pembeli.invoice', ['id' => $order->id])
                    ->with('success', 'Pembayaran berhasil. Ini adalah invoice Anda.');
            }

            if (in_array($transactionStatus, ['expire', 'cancel'])) {
                $order->status = 'cancel';
                $order->save();
            } elseif ($transactionStatus === 'deny') {
                $order->status = 'gagal';
                $order->save();
            }
        }
    } catch (\Exception $e) {
        Log::error('Gagal mengecek status transaksi Midtrans: ' . $e->getMessage());
    }

    // Buat snap_token baru jika kosong dan order masih pending
    if (!$order->snap_token && $order->status === 'pending') {
        try {
            $order->snap_token = Snap::getSnapToken($this->buildMidtransParams($order));
            $order->save();
        } catch (\Exception $e) {
            Log::error('Gagal membuat snap_token baru: ' . $e->getMessage());
            return redirect()->route('pembeli.status.belum-bayar')
                ->with('error', 'Gagal menyiapkan ulang pembayaran. Silakan coba lagi.');
        }
    }

    return view('pembeli.pending', [
        'order' => $order,
        'snapToken' => $order->snap_token,
    ]);
}



    public function callback(Request $request)
    {
        Log::info('Midtrans callback received', $request->all());

        $expectedSignature = hash(
            'sha512',
            $request->order_id . $request->status_code . $request->gross_amount . config('midtrans.server_key')
        );

        if ($expectedSignature !== $request->signature_key) {
            Log::warning('Invalid Midtrans signature', [
                'expected' => $expectedSignature,
                'received' => $request->signature_key,
            ]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $order = Order::where('order_id_midtrans', $request->order_id)->first();

        if ($order) {
            switch ($request->transaction_status) {
                case 'capture':
                case 'settlement':
                    if (!$order->stok_dikurangi) {
                        $produk = Produk::find($order->produk_id);
                        if ($produk && $produk->stok >= $order->jumlah) {
                            $produk->stok -= $order->jumlah;
                            $produk->save();
                            $order->stok_dikurangi = true;
                        }
                    }
                    $order->status = 'complete';
                    Mail::to($order->user->email)->send(new OrderSuccessMail($order));
                    break;
                case 'expire':
                case 'cancel':
                    $order->status = 'cancel';
                    break;
                case 'deny':
                    $order->status = 'gagal';
                    break;
            }

            $order->save();
        }

        return response()->json(['message' => 'Callback processed'], 200);
    }

    public function invoice($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('pembeli.invoice', compact('order'));
    }

    public function statusBelumBayar()
    {
        $orders = Order::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->whereNotNull('order_id_midtrans')
            ->orderBy('id')
            ->get();

        return view('pembeli.status_belum_bayar', compact('orders'));
    }

    public function batal($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($order->status === 'pending') {
            $order->status = 'cancel';
            $order->save();
            return back()->with('success', 'Pesanan berhasil dibatalkan.');
        }

        return back()->with('error', 'Pesanan tidak dapat dibatalkan.');
    }

    public function cancelExpiredOrder(Request $request, $order_id)
    {
        $order = Order::where('id', $order_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($order->status === 'pending') {
            $order->status = 'cancel';
            $order->save();

            if ($order->stok_dikurangi) {
                $produk = Produk::find($order->produk_id);
                if ($produk) {
                    $produk->stok += $order->jumlah;
                    $produk->save();
                }
            }

            return redirect()->route('pembeli.status.belum-bayar')
                ->with('success', 'Pesanan berhasil dibatalkan dan stok dikembalikan.');
        }

        return redirect()->route('pembeli.status.belum-bayar')
            ->with('error', 'Pesanan tidak bisa dibatalkan.');
    }

    // Helper functions
    protected function setMidtransConfig()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    protected function buildMidtransParams($order)
    {
        return [
            'transaction_details' => [
                'order_id' => $order->order_id_midtrans,
                'gross_amount' => $order->total_harga,
            ],
            'customer_details' => [
                'first_name' => $order->name,
                'phone' => $order->phone,
            ],
        ];
    }
}
