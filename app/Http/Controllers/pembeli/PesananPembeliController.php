<?php

// namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Midtrans\Snap;
use Midtrans\Config;

class PesananPembeliController extends Controller
{
    public function checkout(Request $request)
    {
        $user = Auth::user();
        $keranjangs = Keranjang::where('user_id', $user->id)->with('produk')->get();

        if ($keranjangs->isEmpty()) {
            return redirect()->route('pembeli.keranjang.index')->with('error', 'Keranjang kamu kosong!');
        }

        $request->validate([
            'alamat_pengiriman' => 'required|string',
            'metode_pembayaran' => 'required|in:cod,transfer',
        ]);

        $totalHarga = $keranjangs->sum(function ($item) {
            return $item->produk->harga * $item->quantity;
        });

        $pesanan = Pesanan::create([
            'user_id' => $user->id,
            'kode_pesanan' => 'PSN-' . strtoupper(Str::random(8)),
            'total_harga' => $totalHarga,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status' => $request->metode_pembayaran === 'cod' ? 'pending' : 'unpaid',
            'alamat_pengiriman' => $request->alamat_pengiriman,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        // Simpan detail produk ke tabel lain kalau kamu mau
        // (Kalau belum ada, bisa tambahkan nanti)

        // Kosongkan keranjang
        Keranjang::where('user_id', $user->id)->delete();

        if ($request->metode_pembayaran === 'transfer') {
            // Setting Midtrans
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            $midtransParams = [
                'transaction_details' => [
                    'order_id' => $pesanan->kode_pesanan,
                    'gross_amount' => $totalHarga,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                ],
            ];

            $snapToken = Snap::getSnapToken($midtransParams);

            // Update snap_token
            $pesanan->update([
                'snap_token' => $snapToken,
            ]);

            // Redirect ke halaman detail pesanan
            return redirect()->route('pembeli.pesanan.show', $pesanan->id);
        }

        return redirect()->route('pembeli.pesanan.index')->with('success', 'Pesanan COD berhasil dibuat!');
    }

    public function index()
    {
        $pesanans = Pesanan::where('user_id', Auth::id())->latest()->get();
        return view('pembeli.pesanan.index', compact('pesanans'));
    }

    public function show(Pesanan $pesanan)
    {
        // Cek apakah pesanan ini milik user yang login
        if ($pesanan->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this order.');
        }

        return view('pembeli.pesanan.show', compact('pesanan'));
    }
}
