<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class PenjualProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $umkm = Umkm::where('user_id', $user->id)->first();
        return view('penjual.profile.show', compact('user', 'umkm'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('penjual.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user->update([
            'name' => $request->name,
        ]);

        return redirect()->route('penjual.profile.show')->with('success', 'Profil berhasil diperbarui.');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = Auth::user();

        // Khusus penjual, hapus Produk + UMKM
        Produk::where('user_id', $user->id)->delete();
        Umkm::where('user_id', $user->id)->delete();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with('success', 'Akun berhasil dihapus.');
    }
}
