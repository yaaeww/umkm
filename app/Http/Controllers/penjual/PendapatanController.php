<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\UMKM;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PendapatanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $umkm = UMKM::where('user_id', $user->id)->first();
        $pendapatanPerProduk = collect();

        if ($umkm) {
            $pendapatanPerProduk = DB::table('orders')
                ->join('produks', 'orders.produk_id', '=', 'produks.id')
                ->where('produks.umkm_id', $umkm->id)
                ->where('orders.status', 'complete')
                ->select(
                    'produks.nama as nama_produk',
                    DB::raw('SUM(orders.jumlah) as total_terjual'),
                    DB::raw('SUM(orders.total_harga) as total_pendapatan')
                )
                ->groupBy('produks.nama')
                ->get();
        }

        return view('penjual.pendapatan-per-produk', compact('pendapatanPerProduk'));
    }
}
