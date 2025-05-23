<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PendapatanController extends Controller
{
    public function index()
    {
        // Total semua penjualan dari order 'complete'
        $totalPendapatan = DB::table('orders')
            ->join('produks', 'orders.produk_id', '=', 'produks.id')
            ->join('umkms', 'produks.umkm_id', '=', 'umkms.id')
            ->where('orders.status', 'complete')
            ->sum('orders.total_harga');

        $pendapatanAdmin = $totalPendapatan * 0.2;

        // Rekap per toko
        $rekapPerToko = DB::table('orders')
            ->join('produks', 'orders.produk_id', '=', 'produks.id')
            ->join('umkms', 'produks.umkm_id', '=', 'umkms.id')
            ->where('orders.status', 'complete')
            ->select('umkms.nama_toko', DB::raw('SUM(orders.total_harga) as total_penjualan'))
            ->groupBy('umkms.nama_toko')
            ->orderByDesc('total_penjualan')
            ->get();

        return view('admin.pendapatan.index', compact('totalPendapatan', 'pendapatanAdmin', 'rekapPerToko'));
    }
}
