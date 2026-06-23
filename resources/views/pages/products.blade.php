@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl px-6 py-16">

    <div class="mb-12 flex flex-col justify-between gap-6 lg:flex-row lg:items-center">

        <div>

            <span class="inline-flex rounded-full border border-rose-200 bg-white px-4 py-2 text-sm font-semibold text-rose-500 shadow-sm">
                Curated collection
            </span>

            <h1 class="mt-5 text-5xl font-black tracking-tight text-slate-900">
                Our Products
            </h1>

            <p class="mt-3 max-w-2xl text-slate-500">
                Discover our curated beauty collection.
            </p>

        </div>

        <div class="rounded-[28px] border border-white/70 bg-white/80 px-6 py-5 shadow-sm backdrop-blur">
            <p class="text-sm text-slate-500">Total item</p>
            <p class="mt-1 text-3xl font-black text-slate-900">{{ $products->count() }}</p>
        </div>

    </div>

    {{-- CATEGORY FILTER --}}
    <div class="mb-10 flex flex-wrap gap-3">

        <a
            href="/products"
            class="rounded-full border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-500"
        >
            All
        </a>

        @foreach($categories as $category)

            <a
                href="/products?category={{ $category->slug }}"
                class="rounded-full border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-500"
            >
                {{ $category->name }}
            </a>

        @endforeach

    </div>

    {{-- PRODUCT GRID --}}
    <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">

        @foreach($products as $product)

            <a
                href="/products/{{ $product->slug }}"
                class="group block overflow-hidden rounded-[32px] border border-white/70 bg-white shadow-sm transition duration-300 hover:-translate-y-2 hover:shadow-[0_24px_60px_rgba(15,23,42,0.12)]"
            >

                {{-- PRODUCT IMAGE --}}
                <img
                    src="{{ $product->thumbnail ? asset('storage/' . $product->thumbnail) : 'https://images.unsplash.com/photo-1512496015851-a90fb38ba796?q=80&w=1200&auto=format&fit=crop' }}"
                    alt="{{ $product->name }}"
                    class="h-80 w-full object-cover transition duration-500 group-hover:scale-105"
                >

                {{-- PRODUCT CONTENT --}}
                <div class="p-6">

                    {{-- CATEGORY --}}
                    <p class="mb-3 inline-flex rounded-full bg-rose-50 px-3 py-1 text-sm font-semibold text-rose-500">
                        {{ $product->category->name }}
                    </p>

                    {{-- PRODUCT NAME --}}
                    <h2 class="text-2xl font-bold text-slate-900">
                        {{ $product->name }}
                    </h2>

                    {{-- DESCRIPTION --}}
                    <p class="mt-3 line-clamp-2 text-slate-500">
                        {{ $product->description }}
                    </p>

                    {{-- PRICE --}}
                    <div class="mt-6 flex items-center justify-between">

                        <p class="text-2xl font-black text-slate-900">
                            Rp {{ number_format($product->price) }}
                        </p>

                        <div class="rounded-2xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition group-hover:bg-rose-500">
                            View Product
                        </div>

                    </div>

                </div>

            </a>

        @endforeach

    </div>

</div>

@endsection