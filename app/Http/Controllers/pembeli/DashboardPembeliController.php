<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;

class DashboardPembeliController extends Controller
{
    /**
     * Menampilkan halaman dashboard pembeli.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $kategoriId = $request->input('kategori');

        $query = Produk::query();

        if ($search) {
            $query->where('nama', 'like', '%' . $search . '%');
        }

        if ($kategoriId) {
            $query->where('kategori_produk_id', $kategoriId);
        }

        $produks = $query->latest()->paginate(12);
        $totalProduk = Produk::count();
        $produkTerbaru = Produk::latest()->take(5)->get();
        $kategoris = KategoriProduk::orderBy('nama')->get();

        // Ambil nama kategori yang dipilih (jika ada)
        $kategoriAktif = null;
        if ($kategoriId) {
            $kategoriAktif = KategoriProduk::find($kategoriId);
        }

        return view('pembeli.dashboard', compact(
            'produks',
            'totalProduk',
            'produkTerbaru',
            'kategoris',
            'kategoriAktif',
            'search'
        ));
    }
}
