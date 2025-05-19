<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PenjualController extends Controller
{
    public function index()
    {
        $penjual = User::where('role', 'penjual')->get();
        return view('admin.penjual.index', compact('penjual'));
    }
    public function edit($id)
    {
        $penjual = User::where('role', 'penjual')->findOrFail($id); // misal model User dengan role penjual
        return view('admin.penjual.edit', compact('penjual'));
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
