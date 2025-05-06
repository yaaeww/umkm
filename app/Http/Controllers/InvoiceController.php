<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{

    public function show($id)
    {
        $order = Order::with('produk')->findOrFail($id);
        return view('pembeli.invoice', compact('order'));
    }
}
