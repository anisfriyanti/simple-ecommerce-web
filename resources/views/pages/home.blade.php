@extends('layouts.app')

@section('content')

<section class="relative overflow-hidden">

    <div class="absolute inset-x-0 top-0 -z-10 h-[34rem] bg-[radial-gradient(circle_at_top_left,_rgba(244,114,182,0.18),_transparent_35%),radial-gradient(circle_at_top_right,_rgba(251,146,60,0.16),_transparent_30%)]"></div>

    <div class="mx-auto grid max-w-7xl items-center gap-12 px-6 py-16 sm:py-20 lg:grid-cols-2 lg:py-24">

        <div>

            <span class="inline-flex items-center gap-2 rounded-full border border-rose-200 bg-white/90 px-4 py-2 text-sm font-semibold text-rose-500 shadow-sm">
                Beauty • Skincare • Daily Glow
            </span>

            <h1 class="mt-6 text-4xl font-black leading-tight tracking-tight text-slate-900 sm:text-5xl lg:text-7xl">
                Glow essentials for
                <span class="bg-gradient-to-r from-rose-500 via-pink-500 to-orange-400 bg-clip-text text-transparent">
                    your routine
                </span>
            </h1>

            <p class="mt-6 max-w-xl text-lg leading-relaxed text-slate-600">
                Temukan pilihan skincare dan beauty essentials untuk tampilan
                kulit yang lebih segar, sehat, dan percaya diri setiap hari.
            </p>

            <div class="mt-10 flex flex-wrap gap-4">

                <a
                    href="/products"
                    class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-8 py-4 font-semibold text-white shadow-xl shadow-slate-200 transition hover:-translate-y-1 hover:bg-rose-500"
                >
                    Shop Products
                </a>

                <a
                    href="/products"
                    class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-8 py-4 font-semibold text-slate-700 shadow-sm transition hover:-translate-y-1 hover:border-rose-200 hover:text-rose-500"
                >
                    Explore Collection
                </a>

            </div>

            <div class="mt-12 grid max-w-xl grid-cols-1 gap-4 sm:grid-cols-3">
                <div class="rounded-3xl border border-white/70 bg-white/80 p-5 shadow-sm backdrop-blur">
                    <p class="text-3xl font-black text-slate-900">Fresh</p>
                    <p class="mt-1 text-sm text-slate-500">Daily skincare picks</p>
                </div>
                <div class="rounded-3xl border border-white/70 bg-white/80 p-5 shadow-sm backdrop-blur">
                    <p class="text-3xl font-black text-slate-900">Glow</p>
                    <p class="mt-1 text-sm text-slate-500">Beauty favorites</p>
                </div>
                <div class="rounded-3xl border border-white/70 bg-white/80 p-5 shadow-sm backdrop-blur">
                    <p class="text-3xl font-black text-slate-900">Care</p>
                    <p class="mt-1 text-sm text-slate-500">Self-care essentials</p>
                </div>
            </div>

        </div>

        <div class="relative">

            <div class="absolute -left-8 top-10 h-40 w-40 rounded-full bg-rose-200/60 blur-3xl"></div>
            <div class="absolute -right-8 bottom-10 h-48 w-48 rounded-full bg-orange-200/60 blur-3xl"></div>

            <div class="relative overflow-hidden rounded-[40px] border border-white/60 bg-white p-4 shadow-[0_30px_80px_rgba(15,23,42,0.14)]">

                <img
                    src="https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?q=80&w=1200&auto=format&fit=crop"
                    alt="Beauty Product"
                    class="h-[420px] w-full rounded-[28px] object-cover sm:h-[520px] lg:h-[600px]"
                >

                <div class="absolute inset-x-6 bottom-6 rounded-3xl bg-white/90 px-6 py-4 shadow-xl backdrop-blur sm:inset-x-auto sm:left-10 sm:right-10">
                    <p class="text-sm font-semibold text-rose-500">New Arrival</p>
                    <h3 class="mt-1 text-xl font-bold text-slate-900">Glow Ritual Collection</h3>
                    <p class="mt-1 text-sm text-slate-500">Serum, moisturizer, and everyday beauty care.</p>
                </div>

            </div>

        </div>

    </div>

</section>


<!-- FEATURED PRODUCTS -->
<section class="py-24">

    <div class="max-w-7xl mx-auto px-6">

        <div class="mb-16 text-center">

            <span class="font-semibold text-rose-500">
                Featured Collection
            </span>

            <h2 class="mt-4 text-4xl font-black tracking-tight text-slate-900">
                Featured Products
            </h2>

            <p class="mt-4 text-slate-500">
                Produk pilihan untuk rutinitas beauty dan self-care harian.
            </p>

        </div>

        <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">

            @foreach($featuredProducts as $product)

                <div class="group flex h-full flex-col overflow-hidden rounded-[32px] border border-white/70 bg-white shadow-sm transition duration-300 hover:-translate-y-2 hover:shadow-[0_24px_60px_rgba(15,23,42,0.12)]">

                    <div class="aspect-[4/3] overflow-hidden bg-slate-100">
                        <img
                            src="{{ $product->thumbnail ? asset('storage/' . $product->thumbnail) : 'https://images.unsplash.com/photo-1515377905703-c4788e51af15?q=80&w=1200&auto=format&fit=crop' }}"
                            alt="{{ $product->name }}"
                            class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                        >
                    </div>

                    <div class="flex flex-1 flex-col p-6">

                        <span class="inline-flex rounded-full bg-rose-50 px-3 py-1 text-sm font-semibold text-rose-500">
                            {{ $product->category->name }}
                        </span>

                        <h3 class="mt-4 text-2xl font-bold text-slate-900">
                            {{ $product->name }}
                        </h3>

                        <p class="mt-3 line-clamp-2 text-sm leading-6 text-slate-500">
                            {{ $product->short_description }}
                        </p>

                        <div class="mt-auto flex items-end justify-between gap-4 pt-6">

                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Price</p>
                                <strong class="mt-1 block text-xl font-black text-slate-900">

                                    Rp {{ number_format($product->price) }}

                                </strong>
                            </div>

                            <a href="/products/{{ $product->slug }}" class="rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-rose-500">
                                View Product
                            </a>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</section>

@endsection
