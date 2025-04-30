<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil berdasarkan role.
     */
    public function show()
    {
        $user = Auth::user();

        if ($user->role === 'penjual') {
            // Jika role penjual, ambil juga data UMKM nya
            $umkm = Umkm::where('user_id', $user->id)->first();
            return view('profile.show-penjual', compact('user', 'umkm'));
        }

        // Untuk role lain (admin, pembeli) cukup user saja
        return view('profile.show-' . $user->role, compact('user'));
    }

    /**
     * Tampilkan form edit profil.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit-' . $user->role, compact('user'));
    }

    /**
     * Perbarui informasi user.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user->update([
            'name' => $request->name,
        ]);

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Hapus akun user beserta data relasi yang dimiliki.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = Auth::user();

        if ($user->role === 'penjual') {
            Produk::where('user_id', $user->id)->delete();
            Umkm::where('user_id', $user->id)->delete(); // Hapus juga toko UMKM nya
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with('success', 'Akun berhasil dihapus.');
    }
}
