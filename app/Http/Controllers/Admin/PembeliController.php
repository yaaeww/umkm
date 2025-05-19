<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PembeliController extends Controller
{
    public function index()
    {
        $pembeli = User::where('role', 'pembeli')->get();
        return view('admin.pembeli.index', compact('pembeli'));
    }
    public function edit($id)
    {
        $pembeli = User::where('role', 'pembeli')->findOrFail($id);
        return view('admin.pembeli.edit', compact('pembeli'));
    }


    public function update(Request $request, $id)
    {
        $user = User::where('role', 'penjual')->findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);
        $user->update($request->only(['name', 'email']));
        return redirect()->route('admin.penjual.index')->with('success', 'Data penjual berhasil diperbarui');
    }

    public function destroy($id)
    {
        $user = User::where('role', 'penjual')->findOrFail($id);
        $user->delete();
        return redirect()->route('admin.penjual.index')->with('success', 'Penjual berhasil dihapus');
    }
}
