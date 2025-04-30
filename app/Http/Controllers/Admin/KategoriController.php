<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = KategoriProduk::latest()->get();
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'nama' => 'required|unique:kategori_produks,nama',
        'gambar' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
    ]);

    $gambarPath = null;
    if ($request->hasFile('gambar')) {
        $filename = time() . '_' . $request->file('gambar')->getClientOriginalName();
        $request->file('gambar')->move(public_path('gambar/kategori'), $filename);
        $gambarPath = 'gambar/kategori/' . $filename;
    }

    KategoriProduk::create([
        'nama' => $request->nama,
        'slug' => Str::slug($request->nama),
        'gambar' => $gambarPath, // <- gunakan field gambar!
    ]);

    return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
}

public function destroy($id)
{
    $kategori = \App\Models\KategoriProduk::findOrFail($id);

    // Hapus gambar kalau ada
    if ($kategori->gambar) {
        $gambarPath = public_path($kategori->gambar);

        if (file_exists($gambarPath)) {
            unlink($gambarPath);
        }
    }

    $kategori->delete();

    return redirect()->route('admin.kategori.index')->with('success', 'Kategori dan gambarnya berhasil dihapus!');
}

}
