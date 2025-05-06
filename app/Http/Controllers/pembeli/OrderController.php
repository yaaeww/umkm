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
    // Tampilkan form pemesanan produk
    public function showForm($produkId)
    {
        $produk = Produk::find($produkId);
        if (!$produk) {
            return redirect()->route('produk.index')->with('error', 'Produk tidak ditemukan.');
        }

        $userId = Auth::id();
        $keranjang = Keranjang::where('produk_id', $produkId)
            ->where('user_id', $userId)
            ->first();

        $quantity = $keranjang ? $keranjang->jumlah : 1;
        $total_harga = $produk->harga * $quantity;

        return view('pembeli.order', compact('produk', 'quantity', 'total_harga'));
    }

    // Konfirmasi pembelian langsung
    public function konfirmasiPembelian($produk_id, $quantity)
    {
        $produk = Produk::findOrFail($produk_id);
        $total_harga = $produk->harga * $quantity;

        return view('pembeli.order', compact('produk', 'quantity', 'total_harga'));
    }

    // Proses checkout
    public function checkout(Request $request)
    {
        $produk_id = $request->input('produk_id');
        $produk = Produk::findOrFail($produk_id);
        $quantity = $request->input('jumlah');
        $total_harga = intval($quantity) * intval($produk->harga);

        // Cek order yang belum punya order_id_midtrans
        $order = Order::where('user_id', Auth::id())
            ->where('produk_id', $produk_id)
            ->whereNull('order_id_midtrans')
            ->first();

        if (!$order) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'produk_id' => $produk_id,
                'jumlah' => $quantity,
                'total_harga' => $total_harga,
                'status' => 'pending',
                'name' => $request->name,
                'phone' => $request->phone,
                'alamat' => $request->alamat,
                'order_id_midtrans' => 'ORDER-' . uniqid(),
            ]);
        }

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
                'first_name' => $request->name,
                'phone' => $request->phone,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);
        return view('pembeli.checkout', compact('snapToken', 'order'));
    }

    // Callback dari Midtrans
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash(
            "sha512",
            $request->order_id . $request->status_code . $request->gross_amount . $serverKey
        );

        if ($hashed === $request->signature_key) {
            $order = Order::where('order_id_midtrans', $request->order_id)->first();
            if ($order) {
                if (in_array($request->transaction_status, ['capture', 'settlement'])) {
                    $order->update(['status' => 'complete']);
                } elseif ($request->transaction_status === 'expire') {
                    $order->update(['status' => 'dibatalkan']);
                } elseif ($request->transaction_status === 'cancel') {
                    $order->update(['status' => 'cancel']);
                } elseif ($request->transaction_status === 'deny') {
                    $order->update(['status' => 'gagal']);
                }
            }
        }
    }

    // Tampilkan invoice
    public function invoice($id)
    {
        $order = Order::findOrFail($id);
        return view('pembeli.invoice', compact('order'));
    }

    // Status belum dibayar
    public function statusBelumBayar()
    {
        $userId = Auth::id();
        $orders = Order::where('user_id', $userId)
            ->where('status', 'pending')
            ->whereNotNull('order_id_midtrans')
            ->orderBy('id', 'asc')
            ->get();

        return view('pembeli.status_belum_bayar', compact('orders'));
    }

    // Bayar ulang untuk pending order
    public function pending($order_id_midtrans)
    {
        $order = Order::where('order_id_midtrans', $order_id_midtrans)->firstOrFail();

        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = false;

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
        return view('pembeli.pending', compact('order', 'snapToken'));
    }

    // Batalkan pesanan manual
    public function batal($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status === 'pending') {
            $order->status = 'cancel';
            $order->save();
            return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan.');
        }

        return redirect()->back()->with('error', 'Pesanan tidak dapat dibatalkan.');
    }

    // Dibatalkan otomatis jika token expired
    public function cancelExpiredOrder(Request $request, $order_id)
    {
        $order = Order::findOrFail($order_id);

        if ($order->status === 'pending') {
            $order->status = 'cancel';
            $order->save();

            // Tambahkan stok produk jika ada
            $produk = Produk::find($order->produk_id);
            if ($produk) {
                $produk->stok += $order->jumlah;
                $produk->save();
            }

            return redirect()->route('pembeli.status.belum-bayar')
                ->with('success', 'Pesanan berhasil dibatalkan dan stok dikembalikan.');
        }

        return redirect()->route('pembeli.status.belum-bayar')
            ->with('error', 'Pesanan tidak bisa dibatalkan.');
    }
}
