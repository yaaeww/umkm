<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class DashboardPembeliController extends Controller
{
    /**
     * Menampilkan halaman dashboard pembeli.
     */
    public function index()
    {
        $totalProduk = Produk::count();
        $produkTerbaru = Produk::latest()->take(5)->get();
        $produks = Produk::latest()->paginate(12); // Data untuk katalog

        return view('pembeli.dashboard', compact('totalProduk', 'produkTerbaru', 'produks'));
    }
}
