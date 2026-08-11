@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl px-6 py-16">

    @if(session('success'))
        <div class="mb-6 rounded-3xl border border-green-200 bg-green-50 px-6 py-4 text-green-700 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 rounded-3xl border border-red-200 bg-red-50 px-6 py-4 text-red-700 shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-10 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <span class="inline-flex rounded-full border border-rose-200 bg-white px-4 py-2 text-sm font-semibold text-rose-500 shadow-sm">
                Shopping summary
            </span>
            <h1 class="mt-5 text-4xl font-black tracking-tight text-slate-900">
        Shopping Cart
            </h1>
            <p class="mt-3 text-slate-500">Review produk pilihan Anda sebelum melanjutkan ke pembayaran.</p>
        </div>
    </div>

    @if($cart && $cart->items->count())

        <div class="grid gap-8 lg:grid-cols-[1.6fr_0.9fr]">

            <div class="space-y-6">

            @php
                $grandTotal = 0;
                $shippingCost = $shippingCost ?? 0;
            @endphp

            @foreach($cart->items as $item)

                @php
                    $grandTotal += $item->subtotal;
                    $availableStock = $item->product?->stock ?? 0;
                @endphp

                <div class="flex flex-col justify-between gap-6 rounded-[32px] border border-white/70 bg-white p-6 shadow-sm md:flex-row md:items-center">

                    <div class="flex items-center gap-5">

                        <img
                            src="{{ $item->product->thumbnail ? asset('storage/' . $item->product->thumbnail) : 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?q=80&w=800&auto=format&fit=crop' }}"
                            alt="{{ $item->product->name }}"
                            class="h-24 w-24 rounded-3xl object-cover"
                        >

                        <div>

                        <h3 class="text-2xl font-bold text-slate-900">
                            {{ $item->product->name }}
                        </h3>

                        <p class="mt-2 text-sm text-slate-500">
                            Qty:
                            {{ $item->qty }}
                        </p>

                        <p class="mt-1 text-sm font-semibold text-rose-500">
                            Rp {{ number_format($item->price) }} / item
                        </p>

                        <p class="mt-1 text-sm font-semibold {{ $availableStock > 0 ? 'text-emerald-600' : 'text-red-500' }}">
                            {{ $availableStock > 0 ? 'Stock tersedia: ' . $availableStock : 'Out of Stock' }}
                        </p>

                        </div>

                    </div>

                    <div class="text-right space-y-3">

                        <strong class="text-2xl font-black text-slate-900">
                            Rp {{ number_format($item->subtotal) }}
                        </strong>

                        <form
                            action="/cart/update/{{ $item->id }}"
                            method="POST"
                            class="flex items-center justify-end gap-3"
                        >
                            @csrf

                            <input
                                type="number"
                                name="qty"
                                min="0"
                                max="{{ $availableStock }}"
                                value="{{ $item->qty }}"
                                class="w-20 rounded-2xl border border-slate-200 px-3 py-2 text-center shadow-sm focus:border-rose-300 focus:outline-none focus:ring-2 focus:ring-rose-100"
                            >

                            <button class="rounded-2xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-rose-500">
                                Update
                            </button>
                        </form>

                        <p class="text-sm text-slate-500">
                            Isi 0 untuk menghapus produk dari cart.
                        </p>

                        @if($item->qty > $availableStock)
                            <p class="text-sm font-semibold text-red-500">
                                Qty di cart melebihi stock terbaru. Kurangi qty sebelum checkout.
                            </p>
                        @endif

                    </div>

                </div>

            @endforeach

            </div>

            <div class="h-fit rounded-[32px] border border-white/70 bg-white p-8 shadow-sm">

                <p class="text-sm font-medium uppercase tracking-[0.2em] text-slate-400">Order Summary</p>

                <div class="mt-8 space-y-4 text-sm text-slate-500">
                    <div class="flex items-center justify-between">
                        <span>Items</span>
                        <span>{{ $cart->items->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($grandTotal) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Shipping</span>
                        <span>{{ $shippingCost > 0 ? 'Rp ' . number_format($shippingCost) : 'Calculated at checkout' }}</span>
                    </div>
                </div>

                <div class="mt-6 rounded-3xl bg-slate-900 px-6 py-5 text-white">
                    <p class="text-sm text-slate-300">Total Payment</p>
                    <h2 class="mt-2 text-3xl font-black">
                        Rp {{ number_format($grandTotal + $shippingCost) }}
                    </h2>
                </div>

                <a
                    href="/checkout"
                    class="mt-6 inline-flex w-full justify-center rounded-2xl bg-rose-500 px-8 py-4 font-semibold text-white shadow-xl shadow-rose-200 transition hover:-translate-y-1 hover:bg-rose-600"
                >
                    Checkout Securely
                </a>

                <x-payment-maintenance-notice class="mt-5" />

                <p class="mt-4 text-center text-sm text-slate-500">Pembayaran diproses aman melalui sistem checkout Anda.</p>

            </div>

        </div>

    @else

        <div class="rounded-[32px] border border-dashed border-slate-300 bg-white/70 py-20 text-center shadow-sm">

            <h2 class="text-3xl font-bold text-slate-900">
                Your cart is empty
            </h2>

            <p class="mt-3 text-slate-500">Yuk, temukan produk favoritmu dan mulai belanja.</p>

            <a href="/products" class="mt-8 inline-flex rounded-2xl bg-slate-900 px-6 py-3 text-white transition hover:bg-rose-500">
                Browse Products
            </a>

        </div>

    @endif

</div>

@endsection
