<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ChatBotController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;


// Admin Controllers
use App\Http\Controllers\Admin\{
    DashboardAdminController,
    ProdukAdminController,
    KategoriController,
    AdminUmkmController,
    AdminProfileController,
    PenjualController,
    PembeliController,
    PendapatanController as AdminPendapatanController
};

// Penjual Controllers
use App\Http\Controllers\Penjual\{
    DashboardPenjualController,
    ProdukPenjualController,
    PenjualUmkmController,
    PenjualProfileController,
    PenjualPesananController,
    PenjualInvoiceController,
    PendapatanController
};

// Pembeli Controllers
use App\Http\Controllers\Pembeli\{
    DashboardPembeliController,
    ProdukPembeliController,
    PembeliProfileController,
    KeranjangController,
    OrderController,
    CheckoutController,
    PesananController,
    RatingController
};

// Invoice Controller (umum)
use App\Http\Controllers\InvoiceController;

/*
|--------------------------------------------------------------------------
| Landing & Auth Redirect
|--------------------------------------------------------------------------
*/

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/chatbot', [ChatBotController::class, 'index'])->name('chatbot.index');
Route::post('/chatbot', [ChatBotController::class, 'chat'])
    ->name('chatbot.chat')
    ->middleware('auth');

Route::get('/verify-email', function () {
    return view('auth.verify-email');
})->middleware(['auth'])->name('verification.notice');

// Google Auth Routes

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);
Route::get('/auth/google/role', [GoogleController::class, 'chooseRole'])->name('auth.google.role');
Route::post('/auth/google/save-role', [GoogleController::class, 'saveRole'])->name('auth.google.saveRole');


Route::middleware('auth')->get('/redirect-after-login', function () {
    return match (auth()->user()->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'penjual' => redirect()->route('penjual.dashboard'),
        'pembeli' => redirect()->route('pembeli.dashboard'),
        default => abort(403),
    };
});

Route::middleware('auth')->get('/dashboard', fn() => redirect('/redirect-after-login'));

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
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
        Route::post('/{id}/notify', [AdminUmkmController::class, 'sendNotification'])->name('notify');
        Route::delete('/produk/{id}', [AdminUmkmController::class, 'destroyProduct'])->name('produk.destroy');
        Route::delete('/{id}', [AdminUmkmController::class, 'destroy'])->name('destroy');
    });

    Route::controller(AdminProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'show')->name('show');
        Route::get('/edit', 'edit')->name('edit');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
    });
    Route::get('pendapatan', [AdminPendapatanController::class, 'index'])->name('pendapatan.index');

    Route::resource('penjual', PenjualController::class)->only(['index', 'edit', 'update', 'destroy']);
    Route::resource('pembeli', PembeliController::class)->only(['index', 'edit', 'update', 'destroy']);
});

/*
|--------------------------------------------------------------------------
| Penjual Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:penjual'])->prefix('penjual')->name('penjual.')->group(function () {
    Route::get('/dashboard', [DashboardPenjualController::class, 'index'])->name('dashboard');

    Route::resource('produk', ProdukPenjualController::class);
    Route::resource('umkm', PenjualUmkmController::class)->only(['index', 'create', 'store', 'edit', 'update']);

    Route::get('/pesanan', [PenjualPesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{order}/buat', [PenjualPesananController::class, 'create'])->name('pesanan.create');
    Route::patch('/pesanan/{order}/update-status', [PenjualPesananController::class, 'updateStatus'])->name('pesanan.updateStatus');
    Route::get('/pesanan/{order}/invoice/pdf', [PenjualInvoiceController::class, 'generatePdf'])->name('pesanan.invoice.pdf');
    Route::get('/invoice/{id}', [PenjualInvoiceController::class, 'show'])->name('invoice.show');

    // Pendapatan
    Route::get('/pendapatan', [PendapatanController::class, 'index'])->name('pendapatan.index');
    Route::get('/pendapatan-per-produk', [PendapatanController::class, 'index'])->name('pendapatan.per-produk');
    Route::get('/pendapatan/{id}/detail', [PendapatanController::class, 'show'])->name('pendapatan.detail');

    Route::get('/pendapatan/{id}/export-excel', [PendapatanController::class, 'exportDetailExcel'])->name('pendapatan.detail.export.excel');
    Route::get('/pendapatan/{id}/export-pdf', [PendapatanController::class, 'exportDetailPdf'])->name('pendapatan.detail.export.pdf');

    Route::get('/pendapatan/export/excel', [PendapatanController::class, 'exportSummaryExcel'])->name('pendapatan.export.summary.excel');
    Route::get('/pendapatan/export/pdf', [PendapatanController::class, 'exportSummaryPdf'])->name('pendapatan.export.summary.pdf');

    // Profil Penjual
    Route::controller(PenjualProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'show')->name('show');
        Route::get('/edit', 'edit')->name('edit');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
        Route::post('/avatar', 'updateAvatar')->name('avatar');
    });
});

/*
|--------------------------------------------------------------------------
| Pembeli Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:pembeli'])->prefix('pembeli')->name('pembeli.')->group(function () {
    Route::get('/dashboard', [DashboardPembeliController::class, 'index'])->name('dashboard');

    Route::controller(ProdukPembeliController::class)->prefix('produk')->name('produk.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
    });

    Route::controller(KeranjangController::class)->prefix('keranjang')->name('keranjang.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    Route::get('/order/{produk_id}/{quantity}', [OrderController::class, 'showForm'])->name('order');
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::get('/status/belum-bayar', [OrderController::class, 'statusBelumBayar'])->name('status.belum-bayar');
    Route::get('/status/dikemas', [PesananController::class, 'statusDikemas'])->name('status.dikemas');
    Route::get('/status/dikirim', [PesananController::class, 'dikirim'])->name('status.dikirim');
    Route::get('/pending/{order_id_midtrans}', [OrderController::class, 'pending'])->name('pending');
    Route::delete('/order/{id}', [OrderController::class, 'batal'])->name('order.batal');
    Route::post('/order/cancel/{order_id}', [OrderController::class, 'cancelExpiredOrder'])->name('order.cancelExpired');

    Route::get('/invoice/{id}', [InvoiceController::class, 'show'])->name('invoice.show');

    Route::controller(CheckoutController::class)->prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', 'index')->name('form');
        Route::post('/store', 'store')->name('store');
        Route::post('/midtrans', 'getMidtransToken')->name('midtrans');
    });

    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::patch('/pesanan/{id}/status', [PesananController::class, 'updateStatus'])->name('pesanan.updateStatus');
    Route::delete('/pesanan/bulk-delete', [PesananController::class, 'bulkDelete'])->name('pesanan.bulkDelete');
    Route::delete('/pesanan/{id}', [PesananController::class, 'destroy'])->name('pesanan.destroy');

    Route::controller(PembeliProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'show')->name('show');
        Route::get('/edit', 'edit')->name('edit');
        Route::patch('/', 'update')->name('update');
    });

    Route::get('/rating', [RatingController::class, 'index'])->name('rating.index');
    Route::get('/rating/create', [RatingController::class, 'create'])->name('rating.create');
    Route::post('/rating', [RatingController::class, 'store'])->name('rating.store');
});

// Auth Routes
require __DIR__ . '/auth.php';
