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
    // Tampilkan checkout dari keranjang
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

    // Checkout langsung dari 1 produk
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

    // Simpan pesanan dari keranjang
    public function store(Request $request)
    {
        $request->validate([
            'alamat_pengiriman' => 'required|string|max:255',
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
                'total_harga' => 0,
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

            return redirect()->route('pembeli.pesanan.index')->with('success', 'Checkout berhasil! Pesanan Anda telah dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Checkout gagal: ' . $e->getMessage());
        }
    }

    // Simpan pesanan langsung dari 1 produk
    public function checkoutProdukStore(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'jumlah' => 'required|integer|min:1',
            'alamat_pengiriman' => 'required|string|max:255',
        ]);

        $produk = Produk::findOrFail($request->produk_id);

        if ($produk->stok < $request->jumlah) {
            return redirect()->back()->with('error', 'Stok produk tidak mencukupi.');
        }

        DB::beginTransaction();

        try {
            $kodePesanan = 'ORD-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));

            $subtotal = $produk->harga * $request->jumlah;

            $pesanan = Pesanan::create([
                'user_id' => Auth::id(),
                'kode_pesanan' => $kodePesanan,
                'alamat_pengiriman' => $request->alamat_pengiriman,
                'total_harga' => $subtotal,
            ]);

            $produk->stok -= $request->jumlah;
            $produk->save();

            PesananDetail::create([
                'pesanan_id' => $pesanan->id,
                'produk_id' => $produk->id,
                'harga' => $produk->harga,
                'jumlah' => $request->jumlah,
            ]);

            DB::commit();

            return redirect()->route('pembeli.pesanan.index')->with('success', 'Pesanan berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Checkout gagal: ' . $e->getMessage());
        }
    }
}
