<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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

        $namaFile = null;

        if ($request->hasFile('gambar')) {
            // Simpan file dan ambil nama file-nya saja
            $namaFile = $request->file('gambar')->store('kategori', 'public');
            $namaFile = basename($namaFile); // hanya simpan nama file
        }

        KategoriProduk::create([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
            'gambar' => $namaFile,
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kategori = KategoriProduk::findOrFail($id);
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $kategori = KategoriProduk::findOrFail($id);

        $request->validate([
            'nama' => 'required|unique:kategori_produks,nama,' . $kategori->id,
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
        ]);

        // Simpan file baru jika ada
        $namaFile = $kategori->gambar;

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($kategori->gambar && Storage::disk('public')->exists('kategori/' . $kategori->gambar)) {
                Storage::disk('public')->delete('kategori/' . $kategori->gambar);
            }

            // Simpan gambar baru dan ambil nama file-nya
            $namaFile = $request->file('gambar')->store('kategori', 'public');
            $namaFile = basename($namaFile); // hanya simpan nama file
        }

        // Update kategori
        $kategori->update([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
            'gambar' => $namaFile,
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kategori = KategoriProduk::findOrFail($id);

        if ($kategori->gambar) {
            $path = 'kategori/' . $kategori->gambar;
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        $kategori->delete();

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori dan gambarnya berhasil dihapus!');
    }
}
