<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Produk;
use App\Models\Order;
use App\Models\Keranjang;
use App\Models\User;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    // Konfigurasi Midtrans di constructor
    public function __construct()
    {
        // Inisialisasi konfigurasi Midtrans
        $this->initMidtrans();
    }

    // Fungsi inisialisasi Midtrans
    protected function initMidtrans()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    // ========================
    // METHODS UNTUK WEB
    // ========================

    // Tampilkan form pemesanan produk
    protected function hitungHargaSetelahDiskon(Produk $produk)
    {
        if (
            $produk->diskon &&
            $produk->diskon->persen_diskon > 0 &&
            now()->between($produk->diskon->tanggal_mulai, $produk->diskon->tanggal_berakhir)
        ) {
            return $produk->harga - ($produk->harga * $produk->diskon->persen_diskon / 100);
        }

        return $produk->harga;
    }

    public function showForm($produkId)
    {
        $produk = Produk::with('diskon')->findOrFail($produkId);
        $userId = Auth::id();

        $keranjang = Keranjang::where('produk_id', $produkId)
            ->where('user_id', $userId)
            ->first();

        $quantity = $keranjang ? $keranjang->jumlah : 1;
        $harga_diskon = $this->hitungHargaSetelahDiskon($produk);
        $total_harga = $harga_diskon * $quantity;

        return view('pembeli.order', compact('produk', 'quantity', 'harga_diskon', 'total_harga'));
    }

    public function konfirmasiPembelian($produk_id, $quantity)
    {
        $produk = Produk::with('diskon')->findOrFail($produk_id);
        $harga_diskon = $this->hitungHargaSetelahDiskon($produk);
        $total_harga = $harga_diskon * $quantity;

        return view('pembeli.order', compact('produk', 'quantity', 'harga_diskon', 'total_harga'));
    }

    // Proses checkout (untuk web - satu produk)
    public function checkout(Request $request)
    {
        try {
            $request->validate([
                'produk_id' => 'required|exists:produks,id',
                'jumlah' => 'required|integer|min:1',
                'name' => 'required|string',
                'phone' => 'required|string',
                'alamat' => 'required|string',
            ]);

            $produk = Produk::findOrFail($request->produk_id);
            $quantity = $request->jumlah;
            $total_harga = $produk->harga * $quantity;

            // Generate order_id yang UNIK
            $orderIdMidtrans = 'WEB-' . date('YmdHis') . '-' . Auth::id() . '-' . rand(1000, 9999);

            // Cek apakah sudah ada order dengan order_id_midtrans yang sama
            while (Order::where('order_id_midtrans', $orderIdMidtrans)->exists()) {
                $orderIdMidtrans = 'WEB-' . date('YmdHis') . '-' . Auth::id() . '-' . rand(10000, 99999);
            }

            // Buat order baru
            $order = Order::create([
                'user_id' => Auth::id(),
                'produk_id' => $produk->id,
                'jumlah' => $quantity,
                'total_harga' => $total_harga,
                'status' => 'pending',
                'name' => $request->name,
                'phone' => $request->phone,
                'alamat' => $request->alamat,
                'order_id_midtrans' => $orderIdMidtrans,
            ]);

            Log::info('Web Checkout - Order Created:', [
                'order_id' => $orderIdMidtrans,
                'produk_id' => $produk->id,
                'total' => $total_harga
            ]);

            // Siapkan parameter untuk Midtrans
            $params = [
                'transaction_details' => [
                    'order_id' => $orderIdMidtrans, // PASTIKAN ini tidak kosong
                    'gross_amount' => $total_harga,
                ],
                'customer_details' => [
                    'first_name' => $request->name,
                    'email' => Auth::user()->email,
                    'phone' => $request->phone,
                ],
                'item_details' => [
                    [
                        'id' => $produk->id,
                        'price' => $produk->harga,
                        'quantity' => $quantity,
                        'name' => $produk->nama,
                    ]
                ],
            ];

            // Dapatkan Snap Token
            $snapToken = Snap::getSnapToken($params);

            // Update order dengan snap token
            $order->update(['snap_token' => $snapToken]);

            return view('pembeli.checkout', compact('snapToken', 'order'));
        } catch (\Exception $e) {
            Log::error('Web Checkout Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // ========================
    // METHODS UNTUK API
    // ========================

    // API: Get all orders
    public function indexApi()
    {
        try {
            $user = Auth::user();

            $orders = Order::with('produk')
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Data order berhasil diambil',
                'data' => $orders
            ]);
        } catch (\Exception $e) {
            Log::error('API Index Error:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // API: Create new order dari keranjang (bisa multi produk)
    public function storeApi(Request $request)
    {
        try {
            $request->validate([
                'alamat_pengiriman' => 'required|string',
                'catatan' => 'nullable|string',
            ]);

            $user = Auth::user();

            // 1. Ambil item dari keranjang
            $keranjangItems = Keranjang::with('produk')
                ->where('user_id', $user->id)
                ->get();

            if ($keranjangItems->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Keranjang kosong'
                ], 400);
            }

            // 2. Generate order_id yang UNIK
            $orderIdMidtrans = 'API-' . date('YmdHis') . '-' . $user->id . '-' . rand(10000, 99999);

            // Cek duplikasi
            while (Order::where('order_id_midtrans', $orderIdMidtrans)->exists()) {
                $orderIdMidtrans = 'API-' . date('YmdHis') . '-' . $user->id . '-' . rand(10000, 99999);
            }

            Log::info('API Store - Order ID Generated:', ['order_id' => $orderIdMidtrans]);

            // 3. Buat order untuk SETIAP produk di keranjang
            $orders = [];
            $itemDetails = [];
            $totalAmount = 0;

            foreach ($keranjangItems as $item) {
                $subtotal = $item->jumlah * $item->produk->harga;
                $totalAmount += $subtotal;

                // Buat order untuk setiap produk
                $order = Order::create([
                    'user_id' => $user->id,
                    'produk_id' => $item->produk_id,
                    'jumlah' => $item->jumlah,
                    'total_harga' => $subtotal,
                    'status' => 'pending',
                    'alamat' => $request->alamat_pengiriman,
                    'name' => $user->name,
                    'phone' => $user->phone ?? $user->no_telepon ?? '',
                    'order_id_midtrans' => $orderIdMidtrans, // SAMA untuk semua order dalam satu checkout
                    'catatan' => $request->catatan,
                ]);

                $orders[] = $order;

                // Tambahkan ke item details untuk Midtrans
                $itemDetails[] = [
                    'id' => $item->produk_id,
                    'price' => (int) $item->produk->harga,
                    'quantity' => (int) $item->jumlah,
                    'name' => $item->produk->nama,
                ];
            }

            // 4. Siapkan parameter untuk Midtrans
            $params = [
                'transaction_details' => [
                    'order_id' => $orderIdMidtrans, // INI YANG DIPASTIKAN TIDAK KOSONG
                    'gross_amount' => $totalAmount,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone ?? $user->no_telepon ?? '',
                ],
                'item_details' => $itemDetails,
            ];

            Log::info('API Store - Midtrans Params:', $params);

            // 5. Dapatkan Snap Token dari Midtrans
            $snapToken = Snap::getSnapToken($params);

            // 6. Update semua orders dengan snap token yang sama
            Order::where('order_id_midtrans', $orderIdMidtrans)
                ->update(['snap_token' => $snapToken]);

            // 7. Kosongkan keranjang
            Keranjang::where('user_id', $user->id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Order berhasil dibuat',
                'data' => [
                    'order_id' => $orderIdMidtrans,
                    'snap_token' => $snapToken,
                    'redirect_url' => (config('midtrans.is_production')
                        ? 'https://app.midtrans.com/snap/v2/vtweb/'
                        : 'https://app.sandbox.midtrans.com/snap/v2/vtweb/') . $snapToken,
                    'total_amount' => $totalAmount,
                    'orders_count' => count($orders),
                    'orders' => $orders
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('API Store Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // API: Get specific order
    public function showApi($id)
    {
        try {
            $user = Auth::user();

            $order = Order::with('produk')
                ->where('id', $id)
                ->where('user_id', $user->id)
                ->first();

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data order berhasil diambil',
                'data' => $order
            ]);
        } catch (\Exception $e) {
            Log::error('API Show Error:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ========================
    // CALLBACK & SHARED METHODS
    // ========================

    // Callback dari Midtrans
    public function callback(Request $request)
    {
        try {
            Log::info('Midtrans Callback Received:', $request->all());

            $serverKey = config('midtrans.server_key');

            // Verifikasi signature
            $hashed = hash(
                "sha512",
                $request->order_id . $request->status_code . $request->gross_amount . $serverKey
            );

            if ($hashed !== $request->signature_key) {
                Log::warning('Invalid Midtrans Signature');
                return response()->json(['message' => 'Invalid signature'], 403);
            }

            // Cari semua orders dengan order_id_midtrans yang sama
            $orders = Order::where('order_id_midtrans', $request->order_id)->get();

            if ($orders->isEmpty()) {
                Log::warning('Orders not found for Midtrans callback:', ['order_id' => $request->order_id]);
                return response()->json(['message' => 'Orders not found'], 404);
            }

            $statusBaru = $this->mapTransactionStatus($request->transaction_status);

            // Update semua orders
            foreach ($orders as $order) {
                $order->status = $statusBaru;
                $order->save();

                // Jika status complete, kurangi stok
                if ($statusBaru === 'complete') {
                    $produk = Produk::find($order->produk_id);
                    if ($produk && $produk->stok >= $order->jumlah) {
                        $produk->stok -= $order->jumlah;
                        $produk->save();
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Callback processed successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Midtrans Callback Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Callback processing failed'
            ], 500);
        }
    }

    // Helper untuk mapping status Midtrans ke status aplikasi
    protected function mapTransactionStatus($midtransStatus)
    {
        $statusMap = [
            'capture' => 'complete',
            'settlement' => 'complete',
            'pending' => 'pending',
            'deny' => 'failed',
            'expire' => 'expired',
            'cancel' => 'canceled',
        ];

        return $statusMap[$midtransStatus] ?? 'pending';
    }

    // Tampilkan invoice
    public function invoice($id)
    {
        $order = Order::with('produk')->findOrFail($id);
        return view('pembeli.invoice', compact('order'));
    }

    // Status belum dibayar
    public function statusBelumBayar()
    {
        $userId = Auth::id();
        $orders = Order::with('produk')
            ->where('user_id', $userId)
            ->where('status', 'pending')
            ->whereNotNull('order_id_midtrans')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pembeli.status_belum_bayar', compact('orders'));
    }

    // Bayar ulang untuk pending order
    public function pending($order_id_midtrans)
    {
        $order = Order::with('produk')
            ->where('order_id_midtrans', $order_id_midtrans)
            ->firstOrFail();

        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $params = [
            'transaction_details' => [
                'order_id' => $order->order_id_midtrans,
                'gross_amount' => $order->total_harga,
            ],
            'customer_details' => [
                'first_name' => $order->name,
                'phone' => $order->phone,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);
        return view('pembeli.pending', compact('order', 'snapToken'));
    }

    // Batalkan pesanan manual
    public function batal($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status === 'pending') {
            $order->status = 'canceled';
            $order->save();
            return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan.');
        }

        return redirect()->back()->with('error', 'Pesanan tidak dapat dibatalkan.');
    }
}
