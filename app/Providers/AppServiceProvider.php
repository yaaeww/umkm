<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Facades\Keranjang; // Facade Keranjang kamu, bukan model langsung

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Daftarkan binding KeranjangService agar facade bisa resolve
        $this->app->singleton('keranjangservice', function ($app) {
            return new \App\Services\KeranjangService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $totalKeranjang = 0;

            if (Auth::check()) {
                // Panggil method dari service via facade
                $totalKeranjang = Keranjang::getTotalJumlahByUser(Auth::id());
            }

            $view->with('totalKeranjang', $totalKeranjang);
        });
    }
}
