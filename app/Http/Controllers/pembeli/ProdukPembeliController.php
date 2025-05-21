<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Ulasan;
use Illuminate\Support\Facades\DB;

class ProdukPembeliController extends Controller
{
    // Menampilkan semua produk untuk pembeli
    public function index()
    {
        $produks = Produk::latest()->paginate(12);
        return view('pembeli.produk.index', compact('produks'));
    }

    // Menampilkan detail produk beserta ulasan dan produk terkait
    public function show($id)
{
    $produk = Produk::with('user')->findOrFail($id);

    $ulasan = Ulasan::with('user')
        ->where('produks_id', $id)
        ->latest()
        ->get();

    // Hitung rata-rata bintang per user, lalu rata-ratakan semua user
    $avgBintang = DB::table(function ($query) use ($id) {
            $query->from('ulasan')
                ->select('users_id', DB::raw('AVG(bintang) as user_avg'))
                ->where('produks_id', $id)
                ->groupBy('users_id');
        }, 'subquery')
        ->select(DB::raw('AVG(user_avg) as rata_rata'))
        ->value('rata_rata');

    // Tambahkan rating sementara ke objek produk
    $produk->rating = $avgBintang;

    // Produk lain dari penjual yang sama
    $produkTerkait = Produk::where('user_id', $produk->user_id)
        ->where('id', '!=', $produk->id)
        ->latest()
        ->take(3)
        ->get();

    return view('pembeli.produk.show', compact('produk', 'ulasan', 'produkTerkait'));
}




}
