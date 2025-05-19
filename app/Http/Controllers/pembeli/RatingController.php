<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Ulasan;

class RatingController extends Controller
{
    /**
     * Menampilkan daftar produk dari pesanan yang sudah diterima
     * tetapi belum diberi ulasan oleh user.
     */
    public function index()
    {
        $userId = Auth::id();

        // Ambil semua order yang sudah diterima oleh user
        $ordersDiterima = Order::with('produks')
            ->where('user_id', $userId)
            ->where('status', 'diterima')
            ->get();

        // Ambil kombinasi orders_id dan produks_id yang sudah diberi ulasan
        $ulasanOrderProduk = Ulasan::where('users_id', $userId)
            ->get(['orders_id', 'produks_id'])
            ->map(function ($u) {
                return $u->orders_id . '-' . $u->produks_id;
            })->toArray();

        // Filter produk dalam setiap order yang belum diberi ulasan
        $produkBelumDinilai = [];

        foreach ($ordersDiterima as $order) {
            foreach ($order->produks as $produk) {
                $key = $order->id . '-' . $produk->id;
                if (!in_array($key, $ulasanOrderProduk)) {
                    $produkBelumDinilai[] = (object)[
                        'order_id' => $order->id,
                        'produk' => $produk,
                        'status_order' => $order->status
                    ];
                }
            }
        }

        return view('pembeli.rating.index', [
            'produkBelumDinilai' => $produkBelumDinilai
        ]);
    }

    /**
     * Menyimpan ulasan baru untuk produk pada suatu order
     */
    public function store(Request $request)
    {
        $request->validate([
            'orders_id'  => 'required|exists:orders,id',
            'produks_id' => 'required|exists:produk,id',
            'bintang'    => 'required|integer|min:1|max:5',
            'ulasan'     => 'required|string|max:1000',
        ]);

        $userId = Auth::id();

        // Pastikan order milik user dan sudah diterima
        $order = Order::where('id', $request->orders_id)
            ->where('user_id', $userId)
            ->where('status', 'diterima')
            ->firstOrFail();

        // Cek apakah user sudah memberi ulasan untuk produk ini pada order tersebut
        $existingUlasan = Ulasan::where('orders_id', $request->orders_id)
            ->where('produks_id', $request->produks_id)
            ->where('users_id', $userId)
            ->first();

        if ($existingUlasan) {
            return redirect()->back()->with('error', 'Anda sudah memberi ulasan untuk produk ini pada pesanan tersebut.');
        }

        // Simpan ulasan baru
        Ulasan::create([
            'users_id'   => $userId,
            'produks_id' => $request->produks_id,
            'orders_id'  => $request->orders_id,
            'bintang'    => $request->bintang,
            'ulasan'     => $request->ulasan,
        ]);

        return redirect()->route('pembeli.rating')->with('success', 'Terima kasih atas penilaian Anda!');
    }
}
