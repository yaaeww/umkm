<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        if ($kategoriId) {
            $kategoriAktif = KategoriProduk::with('children')->find($kategoriId);
            if ($kategoriAktif) {
                $subkategoris = $kategoriAktif->children;
                $subkategoriIds = $subkategoris->pluck('id')->toArray();
                $kategoriSemuaId = array_merge([$kategoriId], $subkategoriIds);
                $query->whereIn('kategori_produk_id', $kategoriSemuaId);
            }
        }

        if ($search) {
            $query->where('nama', 'like', '%' . $search . '%');
        }

        $produks = $query->with('kategori')->latest()->paginate(12);

        // Kategori utama (root)
        $kategoris = KategoriProduk::whereNull('parent_id')->orderBy('nama')->get();

        // Ambil produk terlaris yang sudah terjual lebih dari 10
        $produkTerlaris = Produk::select('produks.*', DB::raw('COUNT(orders.id) as jumlah_pesanan'))
            ->join('orders', 'orders.produk_id', '=', 'produks.id')
            ->groupBy('produks.id')
            ->having('jumlah_pesanan', '>=', 10)
            ->orderByDesc('jumlah_pesanan')
            ->limit(8)
            ->get();

        return view('pembeli.dashboard', compact(
            'produks',
            'kategoris',
            'kategoriAktif',
            'subkategoris',
            'search',
            'produkTerlaris'
        ));
    }
}
