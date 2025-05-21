<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ulasan;
use App\Models\Order;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function index()
    {
        // Ambil ulasan user beserta relasi produk dan order
        $ratings = auth()->user()->ulasans()->with('produk', 'order')->latest()->get();

        // Ambil order user yang statusnya diterima, eager loading produk
        $orders = Order::where('user_id', auth()->id())
            ->where('status_pesanan', 'diterima')
            ->with('produk')
            ->get();

        $produkBelumDinilai = [];

        foreach ($orders as $order) {
            $produk = $order->produk; // satu produk terkait

            if ($produk) {
                $sudahDiulas = Ulasan::where('users_id', auth()->id())
                    ->where('orders_id', $order->id)
                    ->where('produks_id', $produk->id)
                    ->exists();

                if (!$sudahDiulas) {
                    $produkBelumDinilai[] = (object)[
                        'order' => $order,
                        'produk' => $produk,
                    ];
                }
            }
        }

        return view('pembeli.rating.index', compact('ratings', 'produkBelumDinilai'));
    }

    public function create(Request $request)
    {
        $orderId = $request->query('order');
        $productId = $request->query('product');

        $order = Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->where('status_pesanan', 'diterima')
            ->firstOrFail();

        $produk = Produk::findOrFail($productId);

        $exists = Ulasan::where('users_id', Auth::id())
            ->where('orders_id', $orderId)
            ->where('produks_id', $productId)
            ->exists();

        if ($exists) {
            return redirect()->route('pembeli.status.dikirim')
                ->with('error', 'Anda sudah memberikan ulasan untuk produk ini.');
        }

        return view('pembeli.rating.create', compact('order', 'produk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'orders_id' => 'required|exists:orders,id',
            'produks_id' => 'required|exists:produks,id',
            'bintang' => 'required|integer|min:1|max:5',
            'ulasan' => 'required|string|max:500',
        ]);

        $order = Order::where('id', $request->orders_id)
            ->where('user_id', Auth::id())
            ->where('status_pesanan', 'diterima')
            ->firstOrFail();

        $produk = Produk::findOrFail($request->produks_id);

        $exists = Ulasan::where('users_id', Auth::id())
            ->where('orders_id', $order->id)
            ->where('produks_id', $produk->id)
            ->exists();

        if ($exists) {
            return redirect()->route('pembeli.status.dikirim')
                ->with('error', 'Anda sudah memberikan ulasan untuk produk ini.');
        }

        Ulasan::create([
            'users_id' => Auth::id(),
            'orders_id' => $order->id,
            'produks_id' => $produk->id,
            'bintang' => $request->bintang,
            'ulasan' => $request->ulasan,
        ]);

        return redirect()->route('pembeli.status.dikirim')->with('success', 'Terima kasih atas ulasan Anda!');
    }
}
