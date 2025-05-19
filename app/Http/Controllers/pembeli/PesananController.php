<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    // Tampilkan semua pesanan user
    public function index()
    {
        $pesanan = Order::with('produk') // Pastikan relasi produk benar
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('pembeli.pesanan.index', compact('pesanan'));
    }

    // Hapus pesanan yang statusnya cancel
    public function destroy($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($order->status === 'cancel') {
            $order->delete();
            return back()->with('success', 'Pesanan berhasil dihapus.');
        }

        return back()->with('error', 'Hanya pesanan dengan status cancel yang bisa dihapus.');
    }

    // Update status pesanan dari dikirim jadi diterima
    public function updateStatus(Request $request, $id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($order->status_pesanan === 'dikirim' && $order->status === 'complete') {
            $order->status_pesanan = 'diterima';
            $order->save();

            return redirect()->route('pembeli.status.dikirim')->with('success', 'Pesanan telah dikonfirmasi diterima.');
        }

        return redirect()->back()->with('error', 'Status pesanan tidak dapat diubah.');
    }

    // Pesanan dengan status dikemas
    public function statusDikemas()
    {
        $pesananDikemas = Order::with('produk')
            ->where('user_id', Auth::id())
            ->where('status_pesanan', 'dikemas')
            ->latest()
            ->get();

        return view('pembeli.pesanan.dikemas', compact('pesananDikemas'));
    }

    // Pesanan yang sedang dikirim dan sudah diterima
    public function dikirim()
    {
        $orders = Order::with('produks')->where('user_id', auth()->id())
            ->whereIn('status_pesanan', ['dikirim', 'diterima'])
            ->latest()->get();

        return view('pembeli.pesanan.dikirim', compact('orders'));
    }

    // Hapus banyak pesanan sekaligus dengan status cancel
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('order_ids', []);

        if (empty($ids)) {
            return back()->with('error', 'Tidak ada pesanan yang dipilih untuk dihapus.');
        }

        $deletedCount = Order::whereIn('id', $ids)
            ->where('status', 'cancel')
            ->delete();

        if ($deletedCount > 0) {
            return back()->with('success', "$deletedCount pesanan berhasil dihapus.");
        }

        return back()->with('error', 'Tidak ada pesanan dengan status cancel yang dipilih.');
    }
}
