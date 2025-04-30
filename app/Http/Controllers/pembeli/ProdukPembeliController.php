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
        $produk = Produk::findOrFail($id);
        return view('pembeli.produk.show', compact('produk'));
    }
}
