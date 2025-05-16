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

        $kategoriAktif = null;
        $subkategoris = collect();

        // Jika ada kategori dipilih
        if ($kategoriId) {
            $kategoriAktif = KategoriProduk::with('children')->find($kategoriId);

            if ($kategoriAktif) {
                $subkategoris = $kategoriAktif->children;

                // Ambil semua ID subkategori (anak)
                $subkategoriIds = $subkategoris->pluck('id')->toArray();

                // Tambahkan ID kategori utama juga
                $kategoriSemuaId = array_merge([$kategoriId], $subkategoriIds);

                $query->whereIn('kategori_produk_id', $kategoriSemuaId);
            }
        }

        // Pencarian jika ada
        if ($search) {
            $query->where('nama', 'like', '%' . $search . '%');
        }

        // Ambil semua produk setelah filter
        $produks = $query->with('kategori')->latest()->paginate(12);
        $totalProduk = Produk::count();
        $produkTerbaru = Produk::latest()->take(5)->get();

        // Ambil hanya kategori utama (root)
        $kategoris = KategoriProduk::whereNull('parent_id')->orderBy('nama')->get();

        return view('pembeli.dashboard', compact(
            'produks',
            'totalProduk',
            'produkTerbaru',
            'kategoris',
            'kategoriAktif',
            'subkategoris',
            'search'
        ));
    }
}
