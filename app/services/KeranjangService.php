<?php

namespace App\Services;

use App\Models\Keranjang;

class KeranjangService
{
    public function tambahKeranjang($userId, $produkId, $jumlah)
    {
        $keranjang = Keranjang::firstOrNew([
            'user_id' => $userId,
            'produk_id' => $produkId,
        ]);
        $keranjang->jumlah += $jumlah;
        $keranjang->save();

        return $keranjang;
    }

    public function updateJumlah($id, $jumlah)
    {
        $keranjang = Keranjang::find($id);
        if ($keranjang) {
            $keranjang->jumlah = $jumlah;
            $keranjang->save();
            return $keranjang;
        }
        return null;
    }

    public function hapusKeranjang($id)
    {
        return Keranjang::destroy($id);
    }

    public function getKeranjangByUser($userId)
    {
        return Keranjang::with('produk')->where('user_id', $userId)->get();
    }

    public function hapusItemTanpaProduk($userId)
    {
        Keranjang::where('user_id', $userId)
            ->whereDoesntHave('produk')
            ->delete();
    }
    public function getTotalJumlahByUser($userId)
    {
        return Keranjang::where('user_id', $userId)->sum('jumlah');
    }
}
