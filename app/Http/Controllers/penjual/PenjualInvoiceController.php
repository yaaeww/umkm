<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class PenjualInvoiceController extends Controller
{
    public function show($id)
    {
        $user = Auth::user();

        // Ambil order dengan produk yang terkait ke UMKM milik penjual saat ini
        $order = Order::with(['produk', 'user'])
            ->where('id', $id)
            ->whereHas('produk.umkm', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->firstOrFail();

        return view('penjual.invoice.show', compact('order'));
    }
}
