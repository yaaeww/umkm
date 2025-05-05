<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Produk;

class PesananController extends Controller
{
    public function index()
    {
        // Ambil semua pesanan milik user yang sedang login
        $pesanan = Order::with('produk') // pastikan relasi produk ada
                        ->where('user_id', Auth::id())
                        ->latest()
                        ->get();

        return view('pembeli.pesanan.index', compact('pesanan'));
    }
}
