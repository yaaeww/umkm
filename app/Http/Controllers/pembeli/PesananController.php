<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class PesananController extends Controller
{
    public function index()
    {
        $orders = Order::with('produk')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('pembeli.pesanan.index', ['orders' => $orders]);
    }

    public function statusDikemas()
    {
        $orders = Order::with('produk')
            ->where('user_id', Auth::id())
            ->where('status_pesanan', 'dikemas')
            ->latest()
            ->get();

        return view('pembeli.pesanan.dikemas', ['orders' => $orders]);
    }

    public function dikirim()
    {
        $orders = Order::with('produk')
            ->where('user_id', Auth::id())
            ->whereIn('status_pesanan', ['dikirim', 'diterima'])
            ->latest()
            ->get();

        return view('pembeli.pesanan.dikirim', ['orders' => $orders]);
    }


    public function updateStatus(Request $request, $id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($order->status_pesanan === 'dikirim' && $order->status === 'complete') {
            $order->status_pesanan = 'diterima';
            $order->save();

            return redirect()->route('pembeli.status.dikirim')
                ->with('success', 'Pesanan telah dikonfirmasi diterima.');
        }

        return back()->with('error', 'Status pesanan tidak dapat diubah.');
    }

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

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('order_ids', []);

        if (empty($ids)) {
            return back()->with('error', 'Tidak ada pesanan yang dipilih untuk dihapus.');
        }

        $deletedCount = Order::whereIn('id', $ids)
            ->where('user_id', Auth::id())
            ->where('status', 'cancel')
            ->delete();

        if ($deletedCount > 0) {
            return back()->with('success', "$deletedCount pesanan berhasil dihapus.");
        }

        return back()->with('error', 'Tidak ada pesanan dengan status cancel yang dipilih.');
    }
}
