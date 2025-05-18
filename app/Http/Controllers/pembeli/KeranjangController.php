<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Facades\Keranjang; // Facade KeranjangService
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    /**
     * Tampilkan semua item keranjang user yang sedang login.
     */
    public function index()
    {
        // Hapus item keranjang yang produknya sudah tidak ada lagi
        Keranjang::hapusItemTanpaProduk(Auth::id());

        // Ambil daftar keranjang user
        $keranjangs = Keranjang::getKeranjangByUser(Auth::id());

        return view('pembeli.keranjang.index', compact('keranjangs'));
    }

    /**
     * Tambah produk ke keranjang user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Pastikan produk ada, kalau tidak otomatis error 404
        Produk::findOrFail($request->produk_id);

        // Tambah produk ke keranjang user
        Keranjang::tambahKeranjang(Auth::id(), $request->produk_id, $request->quantity);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    /**
     * Update jumlah produk dalam keranjang.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        // Update jumlah produk, return false kalau gagal
        $keranjang = Keranjang::updateJumlah($id, $request->jumlah);

        if (!$keranjang) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Keranjang tidak ditemukan atau gagal diperbarui.'
                ], 404);
            }
            return redirect()->back()->with('error', 'Keranjang tidak ditemukan atau gagal diperbarui.');
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Jumlah produk diperbarui.'
            ]);
        }

        return redirect()->back()->with('success', 'Jumlah produk diperbarui.');
    }

    /**
     * Hapus produk dari keranjang.
     */
    public function destroy($id)
    {
        $deleted = Keranjang::hapusKeranjang($id);

        if (!$deleted) {
            return redirect()->back()->with('error', 'Keranjang tidak ditemukan atau gagal dihapus.');
        }

        return redirect()->back()->with('success', 'Produk dihapus dari keranjang.');
    }
}
