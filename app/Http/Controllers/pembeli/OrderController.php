<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Produk;
use App\Models\Order;
use App\Models\Keranjang;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    // Hitung harga produk setelah diskon berlaku
    protected function hitungHargaSetelahDiskon(Produk $produk)
    {
        if (
            $produk->diskon &&
            $produk->diskon->persen_diskon > 0 &&
            now()->between($produk->diskon->tanggal_mulai, $produk->diskon->tanggal_berakhir)
        ) {
            $diskon = $produk->diskon->persen_diskon;
            return $produk->harga - ($produk->harga * $diskon / 100);
        }

        return $produk->harga;
    }

    // Menampilkan form pemesanan produk
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

        return view('pembeli.order', compact('produk', 'quantity', 'total_harga', 'harga_diskon'));
    }

    // Konfirmasi pembelian produk
    public function konfirmasiPembelian($produk_id, $quantity)
    {
        $produk = Produk::with('diskon')->findOrFail($produk_id);
        $harga_diskon = $this->hitungHargaSetelahDiskon($produk);
        $total_harga = $harga_diskon * $quantity;

        return view('pembeli.order', compact('produk', 'quantity', 'total_harga', 'harga_diskon'));
    }

    // Proses checkout / pemesanan
    public function checkout(Request $request)
    {
        $produk_id = $request->input('produk_id');
        $produk = Produk::with('diskon')->findOrFail($produk_id);
        $quantity = intval($request->input('jumlah'));

        // Validasi stok
        if ($produk->stok < $quantity) {
            return redirect()->back()->with('error', 'Mohon Maaf, stok produk tidak mencukupi atau habis.');
        }

        // Hitung harga setelah diskon
        $harga_diskon = $this->hitungHargaSetelahDiskon($produk);
        $total_harga = $harga_diskon * $quantity;

        // Cari order pending user untuk produk yang sama
        $order = Order::where('user_id', Auth::id())
            ->where('produk_id', $produk_id)
            ->where('status', 'pending')
            ->first();

        if (!$order) {
            // Buat order baru
            $order = Order::create([
                'user_id' => Auth::id(),
                'produk_id' => $produk_id,
                'jumlah' => $quantity,
                'total_harga' => $total_harga,
                'status' => 'pending',
                'name' => $request->name,
                'phone' => $request->phone,
                'alamat' => $request->alamat,
                'stok_dikurangi' => false,
                'order_id_midtrans' => 'ORDER-' . uniqid(),
            ]);
        } else {
            // Update order lama
            $order->update([
                'jumlah' => $quantity,
                'total_harga' => $total_harga,
                'name' => $request->name,
                'phone' => $request->phone,
                'alamat' => $request->alamat,
            ]);
        }

        // Generate Snap token Midtrans jika belum ada
        if (!$order->snap_token) {
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id' => $order->order_id_midtrans,
                    'gross_amount' => $total_harga,
                ],
                'customer_details' => [
                    'first_name' => $order->name,
                    'phone' => $order->phone,
                ],
            ];

            $snapToken = Snap::getSnapToken($params);
            $order->snap_token = $snapToken;
            $order->save();
        }

        return view('pembeli.checkout', [
            'snapToken' => $order->snap_token,
            'order' => $order,
        ]);
    }

    // Retry pembayaran yang belum selesai
    public function retryPembayaran($order_id_midtrans)
    {
        $order = Order::where('order_id_midtrans', $order_id_midtrans)
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->firstOrFail();

        $snapToken = $order->snap_token;

        if (!$snapToken) {
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id' => $order->order_id_midtrans,
                    'gross_amount' => $order->total_harga,
                ],
                'customer_details' => [
                    'first_name' => $order->name,
                    'phone' => $order->phone,
                ],
            ];

            $snapToken = Snap::getSnapToken($params);
            $order->snap_token = $snapToken;
            $order->save();
        }

        return view('pembeli.pending', compact('order', 'snapToken'));
    }

    // Halaman pending pembayaran
    public function pending($order_id_midtrans)
    {
        $order = Order::where('order_id_midtrans', $order_id_midtrans)->firstOrFail();

        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if (!$order->snap_token) {
            try {
                Config::$serverKey = config('midtrans.server_key');
                Config::$isProduction = config('midtrans.is_production');
                Config::$isSanitized = true;
                Config::$is3ds = true;

                $params = [
                    'transaction_details' => [
                        'order_id' => $order->order_id_midtrans,
                        'gross_amount' => $order->total_harga,
                    ],
                    'customer_details' => [
                        'first_name' => $order->name,
                        'phone' => $order->phone,
                    ],
                ];

                $snapToken = Snap::getSnapToken($params);
                $order->snap_token = $snapToken;
                $order->save();

            } catch (\Exception $e) {
                // Jika order_id sudah pernah digunakan, buat order_id baru dan generate ulang token
                $order->order_id_midtrans = 'ORDER-' . uniqid();
                $order->snap_token = null;
                $order->save();

                $params['transaction_details']['order_id'] = $order->order_id_midtrans;
                $snapToken = Snap::getSnapToken($params);
                $order->snap_token = $snapToken;
                $order->save();
            }
        } else {
            $snapToken = $order->snap_token;
        }

        return view('pembeli.pending', compact('order', 'snapToken'));
    }

    // Callback Midtrans (update status dan stok)
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed === $request->signature_key) {
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
        }

        return response()->json(['message' => 'Callback processed'], 200);
    }

    public function invoice($id)
    {
        $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('pembeli.invoice', compact('order'));
    }

    public function statusBelumBayar()
    {
        $orders = Order::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->whereNotNull('order_id_midtrans')
            ->orderBy('id', 'asc')
            ->get();

        return view('pembeli.status_belum_bayar', compact('orders'));
    }

    public function batal($id)
    {
        $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($order->status === 'pending') {
            $order->status = 'cancel';
            $order->save();
            return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan.');
        }

        return redirect()->back()->with('error', 'Pesanan tidak dapat dibatalkan.');
    }

    public function cancelExpiredOrder(Request $request, $order_id)
    {
        $order = Order::where('id', $order_id)->where('user_id', Auth::id())->firstOrFail();

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

            return redirect()->route('pembeli.status.belum_bayar')
                ->with('success', 'Pesanan berhasil dibatalkan dan stok dikembalikan.');
        }

        return redirect()->route('pembeli.status.belum_bayar')
            ->with('error', 'Pesanan tidak bisa dibatalkan.');
    }
}
