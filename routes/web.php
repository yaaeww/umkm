<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;

// Admin Controllers
use App\Http\Controllers\Admin\{
    DashboardAdminController,
    ProdukAdminController,
    KategoriController,
    AdminUmkmController,
    AdminProfileController
};

// Penjual Controllers
use App\Http\Controllers\Penjual\{
    DashboardPenjualController,
    ProdukPenjualController,
    PenjualUmkmController,
    PenjualProfileController,
    PenjualPesananController,
    PenjualInvoiceController
};

// Pembeli Controllers
use App\Http\Controllers\Pembeli\{
    DashboardPembeliController,
    ProdukPembeliController,
    PembeliProfileController,
    KeranjangController,
    OrderController,
    CheckoutController,
    PesananController
};

// Invoice Controller (khusus agar tidak bentrok)
use App\Http\Controllers\InvoiceController;

/*
|----------------------------------------------------------------------
| Landing Page
|----------------------------------------------------------------------
*/

Route::get('/', [LandingController::class, 'index'])->name('landing');

/*
|----------------------------------------------------------------------
| Redirect After Login
|----------------------------------------------------------------------
*/
Route::middleware('auth')->get('/redirect-after-login', function () {
    return match (auth()->user()->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'penjual' => redirect()->route('penjual.dashboard'),
        'pembeli' => redirect()->route('pembeli.dashboard'),
        default => abort(403),
    };
});

/*
|----------------------------------------------------------------------
| Universal Dashboard Redirect
|----------------------------------------------------------------------
*/
Route::middleware('auth')->get('/dashboard', fn() => redirect('/redirect-after-login'));

/*
|----------------------------------------------------------------------
| Admin Routes
|----------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('dashboard');

    Route::resource('produk', ProdukAdminController::class)->except(['create', 'edit', 'update', 'store', 'show']);
    Route::resource('kategori', KategoriController::class)->except(['edit', 'update']);
    Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');

    Route::prefix('umkm')->name('umkm.')->group(function () {
        Route::get('/', [AdminUmkmController::class, 'index'])->name('index');
        Route::get('/{id}/show', [AdminUmkmController::class, 'show'])->name('show');
        Route::get('/{id}/products', [AdminUmkmController::class, 'products'])->name('products');
        Route::post('/{id}/approve', [AdminUmkmController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [AdminUmkmController::class, 'reject'])->name('reject');
        Route::delete('/{id}', [AdminUmkmController::class, 'destroy'])->name('destroy');
        Route::delete('/produk/{id}', [AdminUmkmController::class, 'destroyProduct'])->name('produk.destroy');
        Route::delete('/umkm/{id}', [AdminUmkmController::class, 'destroy'])->name('admin.umkm.destroy');
        Route::post('/{id}/notify', [AdminUmkmController::class, 'sendNotification'])->name('notify');
    });

    Route::controller(AdminProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'show')->name('show');
        Route::get('/edit', 'edit')->name('edit');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
    });
});

/*
|----------------------------------------------------------------------
| Penjual Routes
|----------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:penjual'])->prefix('penjual')->name('penjual.')->group(function () {
    // Dashboard Penjual
    Route::get('/dashboard', [DashboardPenjualController::class, 'index'])->name('dashboard');

    // Produk & UMKM
    Route::resource('produk', ProdukPenjualController::class);
    Route::resource('umkm', PenjualUmkmController::class)->only(['index', 'create', 'store', 'edit', 'update']);

    // Pesanan
    Route::get('/pesanan', [PenjualPesananController::class, 'index'])->name('pesanan.index');
    Route::get('/invoice/{id}', [PenjualInvoiceController::class, 'show'])->name('invoice.show');
    Route::get('/pesanan/{order}/buat', [PenjualPesananController::class, 'create'])->name('pesanan.create');
    Route::patch('pesanan/{order}/update-status', [PenjualPesananController::class, 'updateStatus'])->name('pesanan.updateStatus');

    // Pendapatan Per Produk
    Route::get('/pendapatan-per-produk', [\App\Http\Controllers\Penjual\PendapatanController::class, 'index'])->name('pendapatan.index');

    // Profile
    Route::controller(PenjualProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'show')->name('show');
        Route::get('/edit', 'edit')->name('edit');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');

        // Menambahkan route untuk update avatar
        Route::post('/avatar', [PenjualProfileController::class, 'updateAvatar'])->name('avatar');
    });
});

/*
|----------------------------------------------------------------------
| Pembeli Routes
|----------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:pembeli'])->prefix('pembeli')->name('pembeli.')->group(function () {
    Route::get('/dashboard', [DashboardPembeliController::class, 'index'])->name('dashboard');

    // Produk
    Route::controller(ProdukPembeliController::class)->prefix('produk')->name('produk.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
    });

    // Keranjang
    Route::controller(KeranjangController::class)->prefix('keranjang')->name('keranjang.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    // Order & Checkout
    Route::get('/order/{produk_id}/{quantity}', [OrderController::class, 'showForm'])->name('order');
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::get('/status/belum-bayar', [OrderController::class, 'statusBelumBayar'])->name('status.belum-bayar');
    Route::get('/status/dikemas', [PesananController::class, 'statusDikemas'])->name('status.dikemas');
    Route::get('/status/dikirim', [PesananController::class, 'dikirim'])->name('status.dikirim');
    Route::get('/pending/{order_id_midtrans}', [OrderController::class, 'pending'])->name('pending');
    Route::delete('/order/{id}', [OrderController::class, 'batal'])->name('order.batal');
    Route::post('/order/cancel/{order_id}', [OrderController::class, 'cancelExpiredOrder'])->name('order.cancelExpired');

    // Invoice
    Route::get('/invoice/{id}', [InvoiceController::class, 'show'])->name('invoice.show');

    // CheckoutController
    Route::controller(CheckoutController::class)->prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', 'index')->name('form');
        Route::post('/store', 'store')->name('store');
        Route::post('/midtrans', 'getMidtransToken')->name('midtrans');
    });

    // Pesanan
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::patch('/pesanan/{id}/status', [PesananController::class, 'updateStatus'])->name('pesanan.updateStatus');
    Route::delete('pesanan/bulk-delete', [PesananController::class, 'bulkDelete'])->name('pesanan.bulkDelete');
    Route::delete('/pesanan/{id}', [PesananController::class, 'destroy'])->name('pesanan.destroy');

    // Tambahkan di dalam grup route pembeli
    // Profil Pembeli
    Route::controller(PembeliProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'show')->name('show');       // pembeli.profile.show
        Route::get('/edit', 'edit')->name('edit');   // pembeli.profile.edit
        Route::patch('/', 'update')->name('update');   // pembeli.profile.update
    });
});

require __DIR__ . '/auth.php';
