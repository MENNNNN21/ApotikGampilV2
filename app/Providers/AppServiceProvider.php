<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Midtrans\Config; // <-- Tambahkan ini

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
        // ---> LETAKKAN KODE MIDTRANS DI SINI <---
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true; // Atau config('midtrans.is_sanitized')
        Config::$is3ds = true;       // Atau config('midtrans.is_3ds')
        // ---> BATAS AKHIR <---
    }
}