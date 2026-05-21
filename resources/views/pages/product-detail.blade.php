@extends('layouts.app')

@section('content')

    <div class="mx-auto max-w-7xl px-6 py-16">

        <div class="grid items-start gap-16 lg:grid-cols-2">

            <!-- PRODUCT IMAGE -->
            <div>

                <div class="overflow-hidden rounded-[36px] border border-white/70 bg-white p-4 shadow-[0_24px_60px_rgba(15,23,42,0.1)]">
                    <img
                        src="{{ $product->thumbnail ? asset('storage/' . $product->thumbnail) : 'https://images.unsplash.com/photo-1571781926291-c477ebfd024b?q=80&w=1200&auto=format&fit=crop' }}"
                        alt="{{ $product->name }}"
                        class="h-[600px] w-full rounded-[28px] object-cover"
                    >
                </div>

            </div>

            <!-- PRODUCT INFO -->
            <div>

                <span class="inline-flex rounded-full bg-rose-50 px-4 py-2 text-sm font-semibold text-rose-500">
                    {{ $product->category->name }}
                </span>

                <h1 class="mt-5 text-5xl font-black tracking-tight text-slate-900">
                    {{ $product->name }}
                </h1>

                <div class="mt-6 flex flex-wrap gap-3">
                    <span class="rounded-full border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-600">
                        Stock {{ $product->stock }}
                    </span>
                    <span class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600">
                        SKU {{ $product->sku }}
                    </span>
                </div>

                <p class="mt-8 text-lg leading-relaxed text-slate-500">
                    {{ $product->description }}
                </p>

                <div class="mt-10 rounded-[32px] border border-white/70 bg-white/90 p-8 shadow-sm">

                    <p class="text-sm font-medium uppercase tracking-[0.2em] text-slate-400">Price</p>
                    <strong class="mt-2 block text-5xl font-black text-slate-900">
                        Rp {{ number_format($product->price) }}
                    </strong>

                    <p class="mt-3 text-sm text-slate-500">Produk pilihan dengan kualitas premium untuk rutinitas harian Anda.</p>

                </div>

                <div class="mt-10 flex flex-wrap gap-4">

                    <form action="/cart/add/{{ $product->id }}" method="POST">

                        @csrf

                        <button class="rounded-2xl bg-slate-900 px-8 py-4 text-white shadow-xl shadow-slate-200 transition hover:-translate-y-1 hover:bg-rose-500">
                            Add to Cart
                        </button>

                    </form>

                    <a href="/products" class="rounded-2xl border border-slate-300 bg-white px-8 py-4 text-slate-700 shadow-sm transition hover:-translate-y-1 hover:border-rose-200 hover:text-rose-500">
                        Continue Shopping
                    </a>

                </div>

                <div class="mt-12 grid gap-4 sm:grid-cols-3">

                    <div class="rounded-3xl border border-white/70 bg-white p-5 shadow-sm">
                        <p class="text-sm text-slate-400">Availability</p>
                        <p class="mt-2 text-lg font-bold text-slate-900">Ready Stock</p>
                    </div>

                    <div class="rounded-3xl border border-white/70 bg-white p-5 shadow-sm">
                        <p class="text-sm text-slate-400">Category</p>
                        <p class="mt-2 text-lg font-bold text-slate-900">{{ $product->category->name }}</p>
                    </div>

                    <div class="rounded-3xl border border-white/70 bg-white p-5 shadow-sm">
                        <p class="text-sm text-slate-400">Secure Checkout</p>
                        <p class="mt-2 text-lg font-bold text-slate-900">Midtrans Ready</p>
                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection