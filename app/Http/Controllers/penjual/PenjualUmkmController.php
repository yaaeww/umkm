<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\UMKM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenjualUmkmController extends Controller
{
    /**
     * Menampilkan status UMKM milik user (apakah pending, approved, rejected, atau belum daftar).
     */
    public function index()
    {
        $user = Auth::user();
        $umkm = UMKM::where('user_id', $user->id)->first();

        return view('penjual.umkm.index', compact('umkm'));
    }

    /**
     * Menampilkan form pendaftaran UMKM baru.
     */
    public function create()
    {
        return view('penjual.umkm.create');
    }

    /**
     * Menyimpan data pendaftaran UMKM baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_toko'  => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'alamat'    => 'required|string|max:255',
            'no_telp'   => 'nullable|string|max:255',
            'logo'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        UMKM::create([
            'user_id'    => Auth::id(),
            'produk_id'  => null,
            'status'     => 'pending', // otomatis pending
            'nama_toko'  => $request->nama_toko,
            'deskripsi'  => $request->deskripsi,
            'alamat'     => $request->alamat,
            'no_telp'    => $request->no_telp,
            'logo'       => $logoPath,
        ]);

        return redirect()->route('penjual.umkm.index')->with('success', 'UMKM berhasil didaftarkan. Menunggu persetujuan admin.');
    }
}
