<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\Order;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    // Tampilkan checkout dari semua produk dalam keranjang
    public function index()
    {
        $items = Keranjang::where('user_id', Auth::id())->with('produk')->get()
            ->filter(fn($item) => $item->produk !== null);

        if ($items->isEmpty()) {
            return redirect()->route('pembeli.keranjang.index')->with('error', 'Keranjang kosong atau produk tidak tersedia.');
        }

        $totalHarga = $items->sum(function ($item) {
            $item->subtotal = $item->produk->harga * $item->jumlah;
            return $item->subtotal;
        });

        return view('pembeli.checkout', compact('items', 'totalHarga'));
    }

    // Checkout per Produk
    public function checkoutProduk($produk_id, $quantity)
    {
        $produk = Produk::findOrFail($produk_id);

        if ($produk->stok < $quantity) {
            return redirect()->back()->with('error', 'Stok produk tidak mencukupi.');
        }

        $items = collect([
            (object)[
                'produk' => $produk,
                'jumlah' => $quantity,
                'subtotal' => $produk->harga * $quantity,
            ]
        ]);

        $totalHarga = $produk->harga * $quantity;

        return view('pembeli.checkout', compact('items', 'totalHarga'));
    }

    // Simpan pesanan dan proses Midtrans
    public function checkout(Request $request)
{
    // Ambil data produk
    $produk_id = $request->input('produk_id');
    $produk = Produk::findOrFail($produk_id);
    $quantity = $request->input('jumlah');
    $total_harga = intval($quantity) * intval($produk->harga);

    // Cek apakah order sudah ada atau belum
    $order = Order::where('user_id', Auth::id())
                ->where('produk_id', $produk_id)
                ->whereNull('order_id_midtrans')
                ->first();

    if (!$order) {
        // Jika tidak ada order, buat order baru
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

    // Konfigurasi Midtrans
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
            'last_name' => '',
            'phone' => $request->phone,
        ],
    ];

    $snapToken = Snap::getSnapToken($params);

    // Kirim variabel order dan snapToken ke view
    return view('pembeli.checkout', compact('snapToken', 'order'));
}

}