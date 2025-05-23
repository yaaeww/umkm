<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Produk;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Facades\Keranjang;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind service untuk Keranjang
        $this->app->singleton('keranjangservice', function ($app) {
            return new \App\Services\KeranjangService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share total item di keranjang untuk semua view
        View::composer('*', function ($view) {
            $totalKeranjang = 0;

            if (Auth::check()) {
                $totalKeranjang = Keranjang::getTotalJumlahByUser(Auth::id());
            }

            $view->with('totalKeranjang', $totalKeranjang);
        });

        // Notifikasi pesanan "dikirim" untuk pembeli
        View::composer('layouts.pembeli-navbar', function ($view) {
            $notifikasiDikirim = collect(); // default kosong

            if (Auth::check() && Auth::user()->role === 'pembeli') {
                $notifikasiDikirim = Order::where('user_id', Auth::id())
                    ->where('status_pesanan', 'dikirim')
                    ->latest()
                    ->get();
            }

            $view->with('notifikasiDikirim', $notifikasiDikirim);
        });

        // Notifikasi pesanan untuk penjual
        View::composer('partials.sidebar-penjual', function ($view) {
            $notifPesananComplete = collect();
            $notifStatusPesanan = collect();

            if (Auth::check() && Auth::user()->role === 'penjual') {
                $produkIds = Produk::where('user_id', Auth::id())->pluck('id');

                $notifPesananComplete = Order::whereIn('produk_id', $produkIds)
                    ->where('status', 'complete')
                    ->latest()
                    ->get();

                $notifStatusPesanan = Order::whereIn('produk_id', $produkIds)
                    ->whereIn('status_pesanan', ['diterima', 'belum_diterima'])
                    ->latest()
                    ->get();
            }

            $view->with([
                'notifPesananComplete' => $notifPesananComplete,
                'notifStatusPesanan' => $notifStatusPesanan,
            ]);
        });
    }
}
