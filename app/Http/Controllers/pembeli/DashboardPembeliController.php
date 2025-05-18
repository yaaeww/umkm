<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardPembeliController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $kategoriId = $request->input('kategori');

        $kategoriAktif = null;
        $subkategoris = collect();

        $query = Produk::query();

        // Ambil kategori root (utama)
        $kategoris = KategoriProduk::whereNull('parent_id')->orderBy('nama')->get();

        if ($kategoriId) {
            $kategoriAktif = KategoriProduk::with('children')->find($kategoriId);

            if ($kategoriAktif) {
                $subkategoris = $kategoriAktif->children;

                // Ambil semua kategori turunannya termasuk kategori aktif (rekursif)
                $kategoriIds = $this->getAllKategoriIds($kategoriAktif);

                // Produk dari semua kategori turunannya
                $produkQuery = Produk::whereIn('kategori_produk_id', $kategoriIds);

                if ($search) {
                    $produkQuery->where('nama', 'like', '%' . $search . '%');
                }

                $produks = $produkQuery->with('kategori')->latest()->paginate(12);
            } else {
                // Jika kategoriId tidak valid, beri produk kosong
                $produks = collect();
            }
        } else {
            // Jika tidak ada filter kategori
            if ($search) {
                $query->where('nama', 'like', '%' . $search . '%');
            }
            $produks = $query->with('kategori')->latest()->paginate(12);
        }

        // Produk terlaris: produk yang dipesan dengan status 'complete' dan jumlah pesanan >= 10
        $produkTerlaris = Produk::select('produks.*', DB::raw('SUM(orders.jumlah) as total_jumlah_pesanan'))
            ->leftJoin('orders', function ($join) {
                $join->on('orders.produk_id', '=', 'produks.id')
                    ->where('orders.status', '=', 'complete');
            })
            ->groupBy('produks.id')
            ->having('total_jumlah_pesanan', '>=', 10)
            ->orderByDesc('total_jumlah_pesanan')
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

    /**
     * Fungsi rekursif untuk dapatkan semua ID kategori anak termasuk kategori induknya
     */
    private function getAllKategoriIds(KategoriProduk $kategori)
    {
        $ids = [$kategori->id];

        foreach ($kategori->children as $child) {
            $ids = array_merge($ids, $this->getAllKategoriIds($child));
        }

        return $ids;
    }
}
