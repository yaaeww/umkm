<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    // Tampilkan checkout dari semua produk dalam keranjang
    public function index()
    {
        $items = Keranjang::where('user_id', Auth::id())->with('produk')->get()
            ->filter(fn($item) => $item->produk !== null);

        if ($items->isEmpty()) {
            return redirect()->route('pembeli.keranjang.index')->with('error', 'Keranjang kosong atau produk tidak tersedia.');
        }

        $totalHarga = $items->sum(function ($item) {
            $item->subtotal = $item->produk->harga * $item->jumlah;
            return $item->subtotal;
        });

        return view('pembeli.checkout', compact('items', 'totalHarga'));
    }

    // Checkout per Produk
    public function checkoutProduk($produk_id, $quantity)
    {
        $produk = Produk::findOrFail($produk_id);

        if ($produk->stok < $quantity) {
            return redirect()->back()->with('error', 'Stok produk tidak mencukupi.');
        }

        $items = collect([
            (object)[
                'produk' => $produk,
                'jumlah' => $quantity,
                'subtotal' => $produk->harga * $quantity,
            ]
        ]);

        $totalHarga = $produk->harga * $quantity;

        return view('pembeli.checkout', compact('items', 'totalHarga'));
    }

    // Simpan pesanan (Checkout Semua)
    public function store(Request $request)
{
    $request->validate([
        'alamat_pengiriman' => 'required|string|max:255',
        'nomor_hp' => 'required|string|max:20',
        'metode_pembayaran' => 'required|in:cod,transfer',
    ]);

    $keranjangs = Keranjang::where('user_id', Auth::id())->with('produk')->get()
        ->filter(fn($item) => $item->produk !== null);

    if ($keranjangs->isEmpty()) {
        return redirect()->back()->with('error', 'Tidak ada produk yang bisa diproses.');
    }

    DB::beginTransaction();

    try {
        $kodePesanan = 'ORD-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));

        $pesanan = Pesanan::create([
            'user_id' => Auth::id(),
            'kode_pesanan' => $kodePesanan,
            'alamat_pengiriman' => $request->alamat_pengiriman,
            'nomor_hp' => $request->nomor_hp,
            'total_harga' => 0,
            'metode_pembayaran' => $request->metode_pembayaran,
        ]);

        $totalHarga = 0;

        foreach ($keranjangs as $item) {
            $produk = $item->produk;

            if ($produk->stok < $item->jumlah) {
                DB::rollBack();
                return redirect()->back()->with('error', "Stok produk '{$produk->nama}' tidak mencukupi.");
            }

            $produk->stok -= $item->jumlah;
            $produk->save();

            PesananDetail::create([
                'pesanan_id' => $pesanan->id,
                'produk_id' => $produk->id,
                'harga' => $produk->harga,
                'jumlah' => $item->jumlah,
            ]);

            $totalHarga += $produk->harga * $item->jumlah;
        }

        $pesanan->update(['total_harga' => $totalHarga]);
        Keranjang::where('user_id', Auth::id())->delete();

        DB::commit();

        if ($pesanan->metode_pembayaran === 'cod') {
            return redirect()->route('pembeli.pesanan.show', $pesanan->id)
                ->with('success', 'Checkout berhasil! Silakan siapkan pembayaran saat produk tiba.');
        }

        // Misal metode transfer: bisa redirect ke halaman instruksi pembayaran atau midtrans
        return redirect()->route('pembeli.pesanan.index')->with('success', 'Pesanan berhasil dibuat. Silakan selesaikan pembayaran.');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Checkout gagal: ' . $e->getMessage());
    }
}

}
