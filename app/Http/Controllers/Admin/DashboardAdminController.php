<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use App\Models\KategoriProduk;
use App\Models\User;

class DashboardAdminController extends Controller
{
    /**
     * Tampilkan halaman dashboard admin dengan data statistik.
     */
    public function index()
    {
        // Jumlah UMKM yang sudah punya produk (jumlah toko aktif)
        $totalProduk = Umkm::whereHas('produks')->count();

        // Jumlah kategori produk (diinput oleh admin)
        $jumlahKategori = KategoriProduk::count();

        // Jumlah penjual yang punya data UMKM
        $totalPenjual = User::where('role', 'penjual')
                            ->whereHas('umkm')
                            ->count();

        return view('admin.dashboard', compact(
            'totalProduk',
            'jumlahKategori',
            'totalPenjual'
        ));
    }
}
