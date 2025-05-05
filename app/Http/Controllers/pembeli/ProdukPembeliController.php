<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Produk;

class ProdukPembeliController extends Controller
{
    // Lihat semua produk (untuk pembeli)
    public function index()
    {
        $produks = Produk::latest()->paginate(12);
        return view('pembeli.produk.index', compact('produks'));
    }

    // Lihat detail produk
    public function show($id)
{
    $produk = Produk::with('user')->findOrFail($id);

    // Produk terkait dari toko yang sama, kecuali produk ini sendiri
    $produkTerkait = Produk::where('user_id', $produk->user_id)
                        ->where('id', '!=', $produk->id)
                        ->latest()
                        ->take(6)
                        ->get();

    return view('pembeli.produk.show', compact('produk', 'produkTerkait'));
}

}
