<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;

class ProdukAdminController extends Controller
{
    // ✅ Dashboard Admin - List Semua Produk
    public function dashboard()
    {
        $produks = Produk::latest()->paginate(10);
        return view('admin.dashboard', compact('produks'));
    }

    // ✅ CRUD Produk (Admin bisa manage produk kalau mau)
    public function index()
    {
        $produks = Produk::latest()->paginate(10);
        return view('admin.produk.index', compact('produks'));
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}
