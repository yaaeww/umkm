<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = KategoriProduk::with(['parent', 'children'])->latest()->get();
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        $kategoriUtama = KategoriProduk::with('children')->whereNull('parent_id')->get();
        $kategoriUtamaFlat = $this->buildKategoriOptions($kategoriUtama);

        return view('admin.kategori.create', [
            'kategoriUtamaFlat' => $kategoriUtamaFlat
        ]);
    }

    public function edit($id)
    {
        $kategori = KategoriProduk::with('children')->findOrFail($id);

        $kategoriUtama = KategoriProduk::with('children')
            ->where('id', '!=', $id)
            ->get();

        $kategoriUtamaFlat = $this->buildKategoriOptions($kategoriUtama);

        return view('admin.kategori.edit', [
            'kategori' => $kategori,
            'kategoriUtamaFlat' => $kategoriUtamaFlat
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:kategori_produks,nama',
            'parent_id' => 'nullable|exists:kategori_produks,id',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
        ]);

        $namaFile = $request->hasFile('gambar')
            ? basename($request->file('gambar')->store('kategori', 'public'))
            : null;

        KategoriProduk::create([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
            'gambar' => $namaFile,
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $kategori = KategoriProduk::with('children')->findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:kategori_produks,id',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->parent_id) {
            $invalidIds = $this->getAllChildIds($kategori);
            if (in_array($request->parent_id, $invalidIds) || $request->parent_id == $kategori->id) {
                return back()->withErrors(['parent_id' => 'Kategori tidak bisa menjadi anak dari dirinya sendiri atau subkategori-nya.']);
            }
        }

        $data = [
            'nama' => $request->nama,
            'parent_id' => $request->parent_id,
        ];

        if ($request->hasFile('gambar')) {
            if ($kategori->gambar && Storage::disk('public')->exists('kategori/' . $kategori->gambar)) {
                Storage::disk('public')->delete('kategori/' . $kategori->gambar);
            }
            $data['gambar'] = basename($request->file('gambar')->store('kategori', 'public'));
        }

        $kategori->update($data);

        if ($request->has('subkategori_id') && $request->has('subkategori_nama')) {
            foreach ($request->subkategori_id as $index => $subId) {
                $sub = KategoriProduk::find($subId);
                if ($sub && $sub->parent_id == $kategori->id) {
                    $sub->update(['nama' => $request->subkategori_nama[$index]]);
                }
            }
        }

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kategori = KategoriProduk::findOrFail($id);

        if ($kategori->gambar && Storage::disk('public')->exists('kategori/' . $kategori->gambar)) {
            Storage::disk('public')->delete('kategori/' . $kategori->gambar);
        }

        KategoriProduk::where('parent_id', $kategori->id)->update(['parent_id' => null]);
        $kategori->delete();

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }

    private function getAllChildIds($kategori)
    {
        $ids = [];
        foreach ($kategori->children as $child) {
            $ids[] = $child->id;
            $ids = array_merge($ids, $this->getAllChildIds($child));
        }
        return $ids;
    }

    private function buildKategoriOptions($kategoris, $prefix = '')
    {
        $options = collect();

        foreach ($kategoris as $kategori) {
            $options->push((object)[
                'id' => $kategori->id,
                'nama' => $prefix . $kategori->nama
            ]);

            if ($kategori->children->isNotEmpty()) {
                $options = $options->merge($this->buildKategoriOptions($kategori->children, $prefix . '-- '));
            }
        }

        return $options;
    }

    private function isDescendant($kategoriId, $targetId)
    {
        if (!$targetId) return false;

        $parent = KategoriProduk::find($targetId);
        while ($parent) {
            if ($parent->id == $kategoriId) return true;
            $parent = $parent->parent;
        }
        return false;
    }
}
