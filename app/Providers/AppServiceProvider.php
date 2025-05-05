<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Keranjang;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $totalKeranjang = 0;

            if (Auth::check()) {
                $totalKeranjang = Keranjang::where('user_id', Auth::id())->sum('jumlah');
            }

            $view->with('totalKeranjang', $totalKeranjang);
        });
    }
}
