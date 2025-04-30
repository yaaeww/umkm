<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\UMKM;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdukPenjualController extends Controller
{
    // ✅ Dashboard Penjual
    public function dashboard()
    {
        $umkm = UMKM::where('user_id', Auth::id())->first();

        $produks = $umkm
            ? Produk::where('umkm_id', $umkm->id)->latest()->paginate(10)
            : collect(); // kosong kalau belum punya UMKM

        return view('penjual.dashboard', compact('produks', 'umkm'));
    }

    // ✅ CRUD Produk (Penjual)
    public function index()
    {
        if ($redirect = $this->ensureUserHasUMKM()) {
            return $redirect;
        }

        $umkm = $this->getUserUMKM();
        $produks = Produk::where('umkm_id', $umkm->id)->latest()->paginate(10);
        return view('penjual.produk.index', compact('produks'));
    }

    public function create()
    {
        if ($redirect = $this->ensureUserHasUMKM()) {
            return $redirect;
        }

        $kategoriProduks = KategoriProduk::all();
        return view('penjual.produk.create', compact('kategoriProduks'));
    }

    public function store(Request $request)
    {
        if ($redirect = $this->ensureUserHasUMKM()) {
            return $redirect;
        }

        $request->validate([
            'kategori_produk_id' => 'required|exists:kategori_produks,id',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $umkm = $this->getUserUMKM();
        $data = $request->only(['kategori_produk_id', 'nama', 'deskripsi', 'harga', 'stok']);
        $data['user_id'] = Auth::id();
        $data['umkm_id'] = $umkm->id;
        $data['rating'] = 0;

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('produks', 'public');
        }

        Produk::create($data);

        return redirect()->route('penjual.produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }
 
    public function edit($id)
    {
        if ($redirect = $this->ensureUserHasUMKM()) {
            return $redirect;
        }

        $produk = $this->findProdukByUser($id);
        $kategoriProduks = KategoriProduk::all();
        return view('penjual.produk.edit', compact('produk', 'kategoriProduks'));
    }

    public function update(Request $request, $id)
    {
        if ($redirect = $this->ensureUserHasUMKM()) {
            return $redirect;
        }

        $produk = $this->findProdukByUser($id);

        $request->validate([
            'kategori_produk_id' => 'required|exists:kategori_produks,id',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['kategori_produk_id', 'nama', 'deskripsi', 'harga', 'stok']);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('produks', 'public');
        }

        $produk->update($data);

        return redirect()->route('penjual.produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        if ($redirect = $this->ensureUserHasUMKM()) {
            return $redirect;
        }

        $produk = $this->findProdukByUser($id);
        $produk->delete();

        return redirect()->route('penjual.produk.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function show($id)
    {
        if ($redirect = $this->ensureUserHasUMKM()) {
            return $redirect;
        }

        $produk = $this->findProdukByUser($id);

        return view('penjual.produk.show', compact('produk'));
    }

    // ✅ Helpers
    private function getUserUMKM()
    {
        return UMKM::where('user_id', Auth::id())->first();
    }

    private function ensureUserHasUMKM()
    {
        if (!UMKM::where('user_id', Auth::id())->exists()) {
            return redirect()->route('penjual.umkm.index')->with('error', 'Silahkan buat UMKM terlebih dahulu.');
        }
        return null;
    }

    private function findProdukByUser($id)
    {
        $umkm = $this->getUserUMKM();
        $produk = Produk::where('id', $id)->where('umkm_id', $umkm->id)->first();
        if (!$produk) {
            abort(403, 'Produk tidak ditemukan atau bukan milik Anda.');
        }
        return $produk;
    }
}
