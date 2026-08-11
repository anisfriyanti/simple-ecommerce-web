@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl px-6 py-16">

    @if(session('error'))
        <div class="mb-6 rounded-3xl border border-red-200 bg-red-50 px-6 py-4 text-red-700 shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 rounded-3xl border border-red-200 bg-red-50 px-6 py-4 text-red-700 shadow-sm">
            <p class="font-bold text-red-800">Lengkapi data pengiriman.</p>
            <p class="mt-1 text-sm">Periksa kembali field yang ditandai sebelum lanjut ke pembayaran.</p>
        </div>
    @endif

    <div class="mb-10 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <span class="inline-flex rounded-full border border-rose-200 bg-white px-4 py-2 text-sm font-semibold text-rose-500 shadow-sm">
                Shipping details
            </span>

            <h1 class="mt-5 text-4xl font-black tracking-tight text-slate-900">
                Checkout
            </h1>

            <p class="mt-3 max-w-2xl text-slate-500">
                Isi alamat pengiriman sebagai snapshot untuk order ini. Data ini tidak berubah meski profil atau alamat Anda diperbarui nanti.
            </p>
        </div>
    </div>

    <div class="grid gap-8 lg:grid-cols-[1.4fr_0.8fr]">
        <form
            method="POST"
            action="/checkout"
            class="rounded-[32px] border border-white/70 bg-white p-6 shadow-sm sm:p-8"
            novalidate
        >
            @csrf

            <input type="hidden" name="shipping_cost" value="{{ $shippingCost }}">

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label for="recipient_name" class="text-sm font-semibold text-slate-700">Nama penerima</label>
                    <input
                        id="recipient_name"
                        type="text"
                        name="recipient_name"
                        value="{{ old('recipient_name', auth()->user()->name) }}"
                        class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 shadow-sm focus:border-rose-300 focus:outline-none focus:ring-2 focus:ring-rose-100"
                        required
                    >
                    @error('recipient_name')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="recipient_phone" class="text-sm font-semibold text-slate-700">No HP</label>
                    <input
                        id="recipient_phone"
                        type="text"
                        name="recipient_phone"
                        value="{{ old('recipient_phone') }}"
                        placeholder="081234567890"
                        class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 shadow-sm focus:border-rose-300 focus:outline-none focus:ring-2 focus:ring-rose-100"
                        required
                    >
                    @error('recipient_phone')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-5">
                <label for="address_line" class="text-sm font-semibold text-slate-700">Alamat lengkap</label>
                <textarea
                    id="address_line"
                    name="address_line"
                    rows="4"
                    class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 shadow-sm focus:border-rose-300 focus:outline-none focus:ring-2 focus:ring-rose-100"
                    required
                >{{ old('address_line') }}</textarea>
                @error('address_line')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-5 grid gap-5 md:grid-cols-2">
                <div>
                    <label for="province" class="text-sm font-semibold text-slate-700">Provinsi</label>
                    <input
                        id="province"
                        type="text"
                        name="province"
                        value="{{ old('province') }}"
                        class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 shadow-sm focus:border-rose-300 focus:outline-none focus:ring-2 focus:ring-rose-100"
                        required
                    >
                    @error('province')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="city" class="text-sm font-semibold text-slate-700">Kota/Kabupaten</label>
                    <input
                        id="city"
                        type="text"
                        name="city"
                        value="{{ old('city') }}"
                        class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 shadow-sm focus:border-rose-300 focus:outline-none focus:ring-2 focus:ring-rose-100"
                        required
                    >
                    @error('city')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="district" class="text-sm font-semibold text-slate-700">Kecamatan</label>
                    <input
                        id="district"
                        type="text"
                        name="district"
                        value="{{ old('district') }}"
                        class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 shadow-sm focus:border-rose-300 focus:outline-none focus:ring-2 focus:ring-rose-100"
                        required
                    >
                    @error('district')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="postal_code" class="text-sm font-semibold text-slate-700">Kode Pos</label>
                    <input
                        id="postal_code"
                        type="text"
                        name="postal_code"
                        value="{{ old('postal_code') }}"
                        class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 shadow-sm focus:border-rose-300 focus:outline-none focus:ring-2 focus:ring-rose-100"
                        required
                    >
                    @error('postal_code')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 rounded-3xl border border-slate-100 bg-slate-50 p-5 text-sm text-slate-600">
                <p class="font-bold text-slate-900">Shipping foundation</p>
                <p class="mt-2">
                    Pilihan kurir dan biaya pengiriman masih placeholder untuk fase RajaOngkir berikutnya.
                </p>
            </div>

            <button class="mt-8 w-full rounded-2xl bg-slate-900 px-8 py-4 font-semibold text-white shadow-xl shadow-slate-200 transition hover:-translate-y-1 hover:bg-rose-500">
                Continue to Payment
            </button>
        </form>

        <aside class="h-fit rounded-[32px] border border-white/70 bg-white p-6 shadow-sm sm:p-8">
            <p class="text-sm font-medium uppercase tracking-[0.2em] text-slate-400">Order Summary</p>

            <div class="mt-6 space-y-4">
                @foreach($cart->items as $item)
                    <div class="flex justify-between gap-4 border-b border-slate-100 pb-4 last:border-b-0">
                        <div>
                            <p class="font-semibold text-slate-900">{{ $item->product->name }}</p>
                            <p class="mt-1 text-sm text-slate-500">Qty: {{ $item->qty }}</p>
                        </div>

                        <p class="font-semibold text-slate-900">
                            Rp {{ number_format($item->subtotal) }}
                        </p>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 space-y-3 text-sm text-slate-500">
                <div class="flex justify-between">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($subtotal) }}</span>
                </div>

                <div class="flex justify-between">
                    <span>Shipping</span>
                    <span>{{ $shippingCost > 0 ? 'Rp ' . number_format($shippingCost) : 'Rp 0' }}</span>
                </div>
            </div>

            <div class="mt-6 rounded-3xl bg-slate-900 px-6 py-5 text-white">
                <p class="text-sm text-slate-300">Grand Total</p>
                <h2 class="mt-2 text-3xl font-black">
                    Rp {{ number_format($grandTotal) }}
                </h2>
            </div>

            <x-payment-maintenance-notice class="mt-6" />
        </aside>
    </div>

</div>

@endsection
