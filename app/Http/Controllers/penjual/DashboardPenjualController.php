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

        // Cari UMKM milik user
        $umkm = UMKM::where('user_id', $user->id)->first();

        if ($umkm) {
            // Ambil produk-produk UMKM
            $produks = Produk::where('umkm_id', $umkm->id)->latest()->paginate(10);

            // Hitung total produk
            $totalProduk = $produks->total();

            // Hitung total kategori unik dari produk
            $totalKategori = Produk::where('umkm_id', $umkm->id)
                ->distinct('kategori_produk_id')
                ->count('kategori_produk_id');
        } else {
            // Kalau belum punya UMKM
            $produks = collect();
            $totalProduk = 0;
            $totalKategori = 0;
        }

        return view('penjual.dashboard', compact('produks', 'umkm', 'totalProduk', 'totalKategori'));
    }
}
