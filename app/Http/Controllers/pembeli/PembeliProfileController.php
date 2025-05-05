<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembeliProfileController extends Controller
{
    // Tampilkan halaman profil pembeli
    public function show()
    {
        $user = Auth::user();
        return view('pembeli.profile.show', compact('user'));
    }

    // Update data profil pembeli
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'avatar' => 'nullable|string|max:255',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'avatar' => $request->avatar,
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}
