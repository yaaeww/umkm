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
    // Menampilkan form pemesanan produk
    public function showForm($produkId)
    {
        $produk = Produk::find($produkId);

        if (!$produk) {
            return redirect()->route('produk.index')->with('error', 'Produk tidak ditemukan.');
        }

        // Ambil jumlah dari keranjang jika ada
        $userId = Auth::id();
        $keranjang = Keranjang::where('produk_id', $produkId)
                            ->where('user_id', $userId)
                            ->first();

        $quantity = $keranjang ? $keranjang->jumlah : 1;
        $total_harga = $produk->harga * $quantity;

        return view('pembeli.order', compact('produk', 'quantity', 'total_harga'));
    }

    // Tampilkan konfirmasi pembelian satu produk
    public function konfirmasiPembelian($produk_id, $quantity)
    {
        $produk = Produk::findOrFail($produk_id);
        $total_harga = $produk->harga * $quantity;

        return view('pembeli.order', compact('produk', 'quantity', 'total_harga'));
    }

    // Proses checkout keranjang atau langsung
    public function checkout(Request $request)
    {
        $produk_id = $request->input('produk_id');
        $produk = Produk::findOrFail($produk_id);
        $quantity = $request->input('jumlah');

        $total_harga = intval($quantity) * intval($produk->harga);

        $request->merge([
            'total_harga' => $total_harga,
            'status' => 'pending',
        ]);

        $order = Order::create($request->all());

        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $order->id,
                'gross_amount' => $total_harga,
            ],
            'customer_details' => [
                'first_name' => $request->name,
                'last_name'=>'',
                'phone' => $request->phone,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return view('pembeli.checkout', compact('snapToken', 'order'));
    }

    // Callback dari Midtrans untuk verifikasi pembayaran
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');

        $hashed = hash("sha512",
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        if ($hashed === $request->signature_key) {
            if (in_array($request->transaction_status, ['capture', 'settlement'])) {
                $order = Order::find($request->order_id);
                if ($order) {
                    $order->update(['status' => 'complete']);
                }
            }
        }
    }

    public function invoice($id){
        $order = Order::find($id);
        return view('pembeli.invoice',compact('order'));

    }
}
