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
use Midtrans\Notification;

class CheckoutController extends Controller
{
    // Tampilkan halaman checkout dari keranjang
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

    // Proses dan buat order Midtrans (tidak mengurangi stok di sini!)
    public function checkout(Request $request)
    {
        $produk_id = $request->input('produk_id');
        $produk = Produk::findOrFail($produk_id);
        $quantity = intval($request->input('jumlah'));
        $total_harga = $quantity * $produk->harga;

        if ($produk->stok < $quantity) {
            return redirect()->back()->with('error', 'Stok produk tidak mencukupi.');
        }

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

        // Midtrans config
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

        return view('pembeli.checkout', compact('snapToken', 'order'));
    }

    // Midtrans callback - kurangi stok saat transaksi berhasil
    public function midtransCallback(Request $request)
    {
        $notif = new Notification();

        $transaction = $notif->transaction_status;
        $order_id = $notif->order_id;

        $order = Order::where('order_id_midtrans', $order_id)->first();

        if (!$order) {
            return response()->json(['message' => 'Order tidak ditemukan'], 404);
        }

        if (in_array($transaction, ['capture', 'settlement']) && $order->status !== 'completed') {
            $produk = $order->produk;

            if ($produk && $produk->stok >= $order->jumlah) {
                $produk->stok -= $order->jumlah;
                $produk->save();

                $order->status = 'completed';
                $order->save();
            }
        } elseif (in_array($transaction, ['cancel', 'expire', 'deny'])) {
            $order->status = 'failed';
            $order->save();
        }

        return response()->json(['message' => 'Notifikasi diproses']);
    }
}