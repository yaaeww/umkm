<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriProduk; // perbaiki kapitalisasi
use App\Models\Produk;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        // Ambil hanya kategori parent (parent_id = null)
        $kategoris = KategoriProduk::whereNull('parent_id')->latest()->get();

        // Mengambil produk berdasarkan pencarian (jika ada)
        $search = $request->query('search');
        $produks = Produk::when($search, function ($query, $search) {
            return $query->where('nama', 'like', '%' . $search . '%')
                        ->orWhere('deskripsi', 'like', '%' . $search . '%');
        })->latest()->take(6)->get();

        // Mengirim data ke view
        return view('landing', compact('kategoris', 'produks'));
    }
}
