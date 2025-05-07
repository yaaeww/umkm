<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\UMKM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardPenjualController extends Controller
{
    /**
     * Menampilkan halaman dashboard penjual.
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil UMKM milik user penjual
        $umkm = UMKM::where('user_id', $user->id)->first();

        // Default nilai
        $produks = collect();
        $totalProduk = 0;
        $totalKategori = 0;
        $totalPembeliUnik = 0;

        if ($umkm) {
            // Ambil produk-produk dari UMKM terkait
            $produks = Produk::where('umkm_id', $umkm->id)
                ->latest()
                ->paginate(10);

            // Ambil semua produk ID milik UMKM ini
            $produkIds = Produk::where('umkm_id', $umkm->id)->pluck('id');

            // Hitung total produk
            $totalProduk = $produks->total();

            // Hitung jumlah kategori unik dari produk
            $totalKategori = Produk::where('umkm_id', $umkm->id)
                ->distinct('kategori_produk_id')
                ->count('kategori_produk_id');

            // Hitung jumlah pembeli unik dari pesanan produk yang statusnya "complete"
            $totalPembeliUnik = \App\Models\Order::whereIn('produk_id', $produkIds)
                ->where('status', 'complete')
                ->distinct('user_id')
                ->count('user_id');
        }

        return view('penjual.dashboard', compact('umkm', 'produks', 'totalProduk', 'totalKategori', 'totalPembeliUnik'));
    }
}
