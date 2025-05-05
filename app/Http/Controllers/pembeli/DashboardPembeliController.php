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
    public function index(Request $request)
    {
        // Ambil kata kunci pencarian
        $search = $request->input('search');

        // Filter produk jika ada pencarian
        $query = Produk::query();

        if ($search) {
            $query->where('nama', 'like', '%' . $search . '%');
        }

        $produks = $query->latest()->paginate(12);
        $totalProduk = Produk::count();
        $produkTerbaru = Produk::latest()->take(5)->get();

        return view('pembeli.dashboard', compact('totalProduk', 'produkTerbaru', 'produks'));
    }
}
