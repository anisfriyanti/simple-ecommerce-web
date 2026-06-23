@extends('layouts.app')

@section('content')

<section class="relative overflow-hidden">

    <div class="absolute inset-x-0 top-0 -z-10 h-[34rem] bg-[radial-gradient(circle_at_top_left,_rgba(244,114,182,0.18),_transparent_35%),radial-gradient(circle_at_top_right,_rgba(251,146,60,0.16),_transparent_30%)]"></div>

    <div class="mx-auto grid max-w-7xl items-center gap-12 px-6 py-20 lg:grid-cols-2 lg:py-24">

        <!-- LEFT CONTENT -->
        <div>

            <span class="inline-flex items-center gap-2 rounded-full border border-rose-200 bg-white/90 px-4 py-2 text-sm font-semibold text-rose-500 shadow-sm">
                ✨ Beauty • Skincare • Lifestyle
            </span>

            <h1 class="mt-6 text-5xl font-black leading-tight tracking-tight text-slate-900 lg:text-7xl">
                Elevate Your
                <span class="bg-gradient-to-r from-rose-500 via-pink-500 to-orange-400 bg-clip-text text-transparent">
                    Beauty
                </span>
                Experience
            </h1>

            <p class="mt-6 max-w-xl text-lg leading-relaxed text-slate-600">
                Discover modern skincare and beauty essentials
                designed for confidence, elegance, and everyday glow.
            </p>

            <div class="mt-10 flex flex-wrap gap-4">

                <a
                    href="/products"
                    class="rounded-2xl bg-slate-900 px-8 py-4 text-white shadow-xl shadow-slate-200 transition hover:-translate-y-1 hover:bg-rose-500"
                >
                    Shop Now
                </a>

                <a
                    href="/products"
                    class="rounded-2xl border border-slate-300 bg-white px-8 py-4 text-slate-700 shadow-sm transition hover:-translate-y-1 hover:border-rose-200 hover:text-rose-500"
                >
                    Explore
                </a>

            </div>

            <div class="mt-12 grid max-w-xl grid-cols-3 gap-4">
                <div class="rounded-3xl border border-white/70 bg-white/80 p-5 shadow-sm backdrop-blur">
                    <p class="text-3xl font-black text-slate-900">1.2k+</p>
                    <p class="mt-1 text-sm text-slate-500">Happy customers</p>
                </div>
                <div class="rounded-3xl border border-white/70 bg-white/80 p-5 shadow-sm backdrop-blur">
                    <p class="text-3xl font-black text-slate-900">98%</p>
                    <p class="mt-1 text-sm text-slate-500">Positive review</p>
                </div>
                <div class="rounded-3xl border border-white/70 bg-white/80 p-5 shadow-sm backdrop-blur">
                    <p class="text-3xl font-black text-slate-900">24h</p>
                    <p class="mt-1 text-sm text-slate-500">Fast response</p>
                </div>
            </div>

        </div>

        <!-- RIGHT IMAGE -->
        <div class="relative">

            <div class="absolute -left-8 top-10 h-40 w-40 rounded-full bg-rose-200/60 blur-3xl"></div>
            <div class="absolute -right-8 bottom-10 h-48 w-48 rounded-full bg-orange-200/60 blur-3xl"></div>

            <div class="relative overflow-hidden rounded-[40px] border border-white/60 bg-white p-4 shadow-[0_30px_80px_rgba(15,23,42,0.14)]">

                <img
                    src="https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?q=80&w=1200&auto=format&fit=crop"
                    alt="Beauty Product"
                    class="h-[600px] w-full rounded-[28px] object-cover"
                >

                <div class="absolute bottom-10 left-10 rounded-3xl bg-white/85 px-6 py-4 shadow-xl backdrop-blur">
                    <p class="text-sm font-semibold text-rose-500">New Arrival</p>
                    <h3 class="mt-1 text-xl font-bold text-slate-900">Glow Ritual Collection</h3>
                    <p class="mt-1 text-sm text-slate-500">Soft, clean, and radiant essentials.</p>
                </div>

            </div>

        </div>

    </div>

</section>


<!-- FEATURED PRODUCTS -->
<section class="py-24">

    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-16">

            <span class="font-semibold text-rose-500">
                Featured Collection
            </span>

            <h2 class="mt-4 text-4xl font-black tracking-tight text-slate-900">
                Best Seller Products
            </h2>

            <p class="mt-4 text-slate-500">
                Curated beauty essentials loved by our customers.
            </p>

        </div>

        <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">

            @foreach($featuredProducts as $product)

                <div class="group overflow-hidden rounded-[32px] border border-white/70 bg-white shadow-sm transition duration-300 hover:-translate-y-2 hover:shadow-[0_24px_60px_rgba(15,23,42,0.12)]">

                    <img
                        src="{{ $product->thumbnail ? asset('storage/' . $product->thumbnail) : 'https://images.unsplash.com/photo-1515377905703-c4788e51af15?q=80&w=1200&auto=format&fit=crop' }}"
                        alt="{{ $product->name }}"
                        class="h-80 w-full object-cover transition duration-500 group-hover:scale-105"
                    >

                    <div class="p-6">

                        <span class="inline-flex rounded-full bg-rose-50 px-3 py-1 text-sm font-semibold text-rose-500">
                            {{ $product->category->name }}
                        </span>

                        <h3 class="mt-4 text-2xl font-bold text-slate-900">
                            {{ $product->name }}
                        </h3>

                        <p class="mt-3 line-clamp-2 text-slate-500">
                            {{ $product->short_description }}
                        </p>

                        <div class="mt-6 flex items-center justify-between">

                            <strong class="text-xl font-black text-slate-900">

                                Rp {{ number_format($product->price) }}

                            </strong>

                            <a href="/products/{{ $product->slug }}" class="rounded-2xl bg-slate-900 px-5 py-3 text-white transition hover:bg-rose-500">
                                View
                            </a>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</section>

@endsection