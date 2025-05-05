<?php

use Illuminate\Support\Facades\Route;
use App\Models\Produk;
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
    PenjualProfileController
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
    Route::get('/dashboard', [DashboardPenjualController::class, 'index'])->name('dashboard');
    Route::resource('produk', ProdukPenjualController::class);
    Route::resource('umkm', PenjualUmkmController::class)->only(['index', 'create', 'store', 'edit', 'update']);

    Route::controller(PenjualProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'show')->name('show');
        Route::get('/edit', 'edit')->name('edit');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
    });
});

/*
|----------------------------------------------------------------------
| Pembeli Routes
|----------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:pembeli'])->prefix('pembeli')->name('pembeli.')->group(function () {
    Route::get('/dashboard', [DashboardPembeliController::class, 'index'])->name('dashboard');

    Route::controller(ProdukPembeliController::class)->prefix('produk')->name('produk.')->group(function () {
        Route::get('/', 'index')->name('index'); // pembeli.produk.index
        Route::get('/{id}', 'show')->name('show'); // pembeli.produk.show
    });

    Route::controller(KeranjangController::class)->prefix('keranjang')->name('keranjang.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    Route::get('/order/{produk_id}/{quantity}', [OrderController::class, 'showForm'])->name('order');
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::get('/invoice/{id}', [OrderController::class, 'invoice']);

    Route::controller(CheckoutController::class)->prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::post('/midtrans', 'getMidtransToken')->name('midtrans');
        Route::get('/produk/{produk_id}/{quantity}', 'checkoutProduk')->name('produk');
    });

    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan');

    Route::controller(PembeliProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'show')->name('show');
        Route::get('/edit', 'edit')->name('edit');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
    });
});

require __DIR__ . '/auth.php';
