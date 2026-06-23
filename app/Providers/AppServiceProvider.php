<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Vite;

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
        Vite::createAssetPathsUsing(
            static fn (string $path, ?bool $secure = null): string => '/'.ltrim($path, '/')
        );

        \Midtrans\Config::$serverKey =
            config('midtrans.server_key');

        \Midtrans\Config::$isProduction =
            config('midtrans.is_production');

        \Midtrans\Config::$isSanitized = true;

        \Midtrans\Config::$is3ds = true;
        //
    }
}
