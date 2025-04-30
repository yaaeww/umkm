<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UMKM;
use App\Models\Produk;
use Illuminate\Http\Request;

class AdminUmkmController extends Controller
{
    /**
     * Menampilkan semua daftar UMKM (approved, pending, rejected).
     */
    public function index()
    {
        $approvedUmkms = UMKM::where('status', 'approved')->latest()->get();
        $pendingUmkms = UMKM::where('status', 'pending')->latest()->get();
        $rejectedUmkms = UMKM::where('status', 'rejected')->latest()->get();

        return view('admin.umkm.index', compact('approvedUmkms', 'pendingUmkms', 'rejectedUmkms'));
    }

    /**
     * Menyetujui UMKM.
     */
    public function approve($id)
    {
        $umkm = UMKM::findOrFail($id);
        $umkm->update(['status' => 'approved']);

        return redirect()->route('admin.umkm.index')->with('success', 'UMKM berhasil disetujui.');
    }

    /**
     * Menolak UMKM.
     */
    public function reject($id)
    {
        $umkm = UMKM::findOrFail($id);
        $umkm->update(['status' => 'rejected']);

        return redirect()->route('admin.umkm.index')->with('error', 'UMKM telah ditolak.');
    }

    /**
     * Menampilkan detail UMKM.
     */
    public function show($id)
    {
        $umkm = UMKM::findOrFail($id);
        return view('admin.umkm.show', compact('umkm'));
    }

    /**
     * Menampilkan semua produk dari UMKM tertentu.
     */
    public function products($id)
    {
        $umkm = UMKM::findOrFail($id);
        $products = Produk::where('umkm_id', $id)->latest()->get();
        return view('admin.umkm.products', compact('umkm', 'products'));
    }

    /**
     * Menghapus UMKM (khusus yang status 'rejected').
     */
    public function destroy($id)
    {
        $umkm = UMKM::findOrFail($id);

        if ($umkm->status !== 'rejected') {
            return redirect()->route('admin.umkm.index')->with('error', 'Hanya UMKM yang sudah ditolak yang bisa dihapus.');
        }

        // Hapus produk terkait jika diperlukan
        Produk::where('umkm_id', $id)->delete();

        $umkm->delete();

        return redirect()->route('admin.umkm.index')->with('success', 'UMKM berhasil dihapus.');
    }
}
