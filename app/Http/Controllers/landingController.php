<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\kategoriProduk;  // Mengimpor model kategoriProduk
use App\Models\produk;

class landingController extends Controller
{
    public function index(Request $request)
    {
        //ambil data kategori
        $kategoris = KategoriProduk::latest()->get();

        // Mengambil produk berdasarkan pencarian (jika ada)
        $search = $request->query('search');
        $produks = produk::when($search, function ($query, $search) {
            return $query->where('nama', 'like', '%' . $search . '%')
                        ->orWhere('deskripsi', 'like', '%' . $search . '%');
        })->latest()->take(6)->get();

        // Mengirim data ke view
        return view('landing', compact('kategoris', 'produks'));
    }
}
