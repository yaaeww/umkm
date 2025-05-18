<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriProduk;
use App\Models\Produk;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        // Ambil kategori induk dan eager load subkategoris dan produks
        $kategoris = KategoriProduk::with(['subkategoris', 'produks'])
            ->whereNull('parent_id')
            ->latest()
            ->get();

        // Pencarian produk jika ada query search
        $search = $request->query('search');
        $produks = Produk::when($search, function ($query, $search) {
                return $query->where('nama', 'like', '%' . $search . '%')
                            ->orWhere('deskripsi', 'like', '%' . $search . '%');
            })
            ->latest()
            ->take(6)
            ->get();

        return view('landing', compact('kategoris', 'produks'));
    }
}
