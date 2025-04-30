<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    // ✅ Tampilkan semua item keranjang user
    public function index()
    {
        // Hapus item yang tidak memiliki produk (produk sudah dihapus)
        Keranjang::where('user_id', Auth::id())
            ->whereDoesntHave('produk')
            ->delete();

        $keranjangs = Keranjang::with('produk')
            ->where('user_id', Auth::id())
            ->get();

        return view('pembeli.keranjang.index', compact('keranjangs'));
    }

    // ✅ Tambah produk ke keranjang
    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $produk = Produk::findOrFail($request->produk_id);

        $keranjang = Keranjang::firstOrNew([
            'user_id' => Auth::id(),
            'produk_id' => $request->produk_id,
        ]);

        $keranjang->jumlah += $request->quantity;
        $keranjang->save();

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    // ✅ Update jumlah produk dalam keranjang
    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $keranjang = Keranjang::where('user_id', Auth::id())->findOrFail($id);
        $keranjang->jumlah = $request->jumlah;
        $keranjang->save();

        return redirect()->back()->with('success', 'Jumlah produk diperbarui.');
    }

    // ✅ Hapus produk dari keranjang
    public function destroy($id)
    {
        $keranjang = Keranjang::where('user_id', Auth::id())->findOrFail($id);
        $keranjang->delete();

        return redirect()->back()->with('success', 'Produk dihapus dari keranjang.');
    }
}
