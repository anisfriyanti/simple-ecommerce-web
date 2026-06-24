<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="flex min-h-screen flex-col items-center justify-center bg-gradient-to-br from-rose-50 via-white to-slate-100 px-6 py-10">
            <div class="text-center">
                <a href="/" class="inline-flex items-center gap-3">
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-rose-400 via-pink-500 to-orange-400 text-sm font-black text-white shadow-lg shadow-rose-200">
                        BC
                    </span>
                    <span class="text-2xl font-black tracking-tight text-slate-900">
                        BrandCommerce
                    </span>
                </a>

                <p class="mt-3 text-sm text-slate-500">
                    Demo ecommerce with cart, checkout, payment, and admin monitoring.
                </p>
            </div>

            <div class="mt-8 w-full max-w-md overflow-hidden rounded-[32px] border border-white/70 bg-white/90 px-6 py-6 shadow-xl shadow-slate-200/70 backdrop-blur">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
