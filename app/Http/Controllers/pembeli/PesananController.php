<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Illuminate\Http\Request; // Menambahkan Request

class PesananController extends Controller
{
    public function index()
    {
        // Ambil semua pesanan milik user yang sedang login
        $pesanan = Order::with('produk') // pastikan relasi produk ada
                        ->where('user_id', Auth::id())
                        ->latest()
                        ->get();

        return view('pembeli.pesanan.index', compact('pesanan'));
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        // Pastikan hanya pesanan dengan status cancel yang bisa dihapus
        if ($order->status === 'cancel') {
            $order->delete();
            return back()->with('success', 'Pesanan berhasil dihapus.');
        }

        return back()->with('error', 'Hanya pesanan dengan status cancel yang bisa dihapus.');
    }

    public function bulkDelete(Request $request)
    {
        // Pastikan order_ids ada dan bukan array kosong
        $ids = $request->input('order_ids', []);

        if (empty($ids)) {
            return back()->with('error', 'Tidak ada pesanan yang dipilih untuk dihapus.');
        }

        // Hapus pesanan yang statusnya cancel dan ID ada di dalam array
        $deletedCount = Order::whereIn('id', $ids)
                            ->where('status', 'cancel')
                            ->delete();

        if ($deletedCount > 0) {
            return back()->with('success', "$deletedCount pesanan berhasil dihapus.");
        }

        return back()->with('error', 'Tidak ada pesanan dengan status cancel yang dipilih.');
    }
}
