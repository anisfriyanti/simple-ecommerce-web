@extends('layouts.app')

@section('content')

    <div class="mx-auto max-w-7xl px-6 py-16">

        @if(session('success'))
            <div class="mb-6 rounded-3xl border border-green-200 bg-green-50 px-6 py-4 text-green-700 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-10 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <span class="inline-flex rounded-full border border-rose-200 bg-white px-4 py-2 text-sm font-semibold text-rose-500 shadow-sm">
                    Purchase history
                </span>
                <h1 class="mt-5 text-4xl font-black tracking-tight text-slate-900">
                    My Orders
                </h1>
                <p class="mt-3 text-slate-500">Pantau pembayaran dan status pesanan Anda dengan tampilan yang lebih rapi.</p>
            </div>

            <div class="rounded-[28px] border border-white/70 bg-white/80 px-6 py-5 shadow-sm backdrop-blur">
                <p class="text-sm text-slate-500">Total orders</p>
                <p class="mt-1 text-3xl font-black text-slate-900">{{ $transactions->count() }}</p>
            </div>
        </div>

        <x-payment-maintenance-notice class="mb-8" />

        @forelse($transactions as $transaction)

            @php
                $paymentStatus = $transaction->payment_status;
                $orderStatus = $transaction->transaction_status;

                $statusLabel = match (true) {
                    $paymentStatus === 'cancelled' || $orderStatus === 'cancelled' => 'Dibatalkan',
                    $paymentStatus === 'failed' => 'Pembayaran Gagal',
                    $paymentStatus === 'expired' => 'Pembayaran Expired',
                    $paymentStatus === 'pending' => 'Belum Dibayar',
                    $paymentStatus === 'paid' && $orderStatus === 'processing' => 'Diproses',
                    $orderStatus === 'shipped' => 'Dikirim',
                    $orderStatus === 'completed' => 'Selesai',
                    default => 'Menunggu Update',
                };

                $statusClasses = match ($statusLabel) {
                    'Belum Dibayar' => 'bg-yellow-100 text-yellow-700',
                    'Diproses' => 'bg-blue-100 text-blue-700',
                    'Dikirim' => 'bg-indigo-100 text-indigo-700',
                    'Selesai' => 'bg-green-100 text-green-700',
                    'Pembayaran Expired' => 'bg-slate-100 text-slate-700',
                    'Dibatalkan' => 'bg-red-100 text-red-700',
                    'Pembayaran Gagal' => 'bg-red-100 text-red-700',
                    default => 'bg-slate-100 text-slate-700',
                };
            @endphp

            <div class="mb-8 rounded-[32px] border border-white/70 bg-white p-6 shadow-sm sm:p-8">

                <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                    <div>

                        <h2 class="text-2xl font-bold text-slate-900">
                            {{ $transaction->invoice_number }}
                        </h2>

                        <p class="mt-2 text-slate-500">
                            {{ $transaction->created_at->format('d M Y H:i') }}
                        </p>

                    </div>

                    <div class="flex flex-col items-start gap-2 lg:items-end">

                        <p class="text-xs font-bold uppercase tracking-wide text-slate-400">Status pesanan</p>

                        <span class="rounded-full px-4 py-2 text-sm font-semibold {{ $statusClasses }}">
                            {{ $statusLabel }}
                        </span>

                    </div>

                </div>

                <div class="space-y-4 rounded-[28px] bg-slate-50 p-5">

                    @foreach($transaction->items as $item)

                        <div class="flex flex-col justify-between gap-4 border-b border-slate-200 pb-4 last:border-b-0 last:pb-0 md:flex-row md:items-center">

                            <div class="flex items-center gap-4">

                                <div class="h-16 w-16 overflow-hidden rounded-2xl bg-white">
                                    <img
                                        src="{{ $item->product->thumbnail ? asset('storage/' . $item->product->thumbnail) : 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?q=80&w=800&auto=format&fit=crop' }}"
                                        alt="{{ $item->product->name }}"
                                        class="h-full w-full object-cover"
                                    >
                                </div>

                                <div>

                                    <h3 class="font-semibold text-slate-900">
                                        {{ $item->product->name }}
                                    </h3>

                                    <p class="text-sm text-slate-500">
                                        Qty: {{ $item->qty }}
                                    </p>

                                </div>

                            </div>

                            <strong class="text-slate-900">

                                Rp {{ number_format($item->subtotal) }}

                            </strong>

                        </div>

                    @endforeach

                </div>

                <div class="mt-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                    <strong class="text-2xl font-black text-slate-900">
                        Total:
                        Rp {{ number_format($transaction->grand_total) }}
                    </strong>

                    @if($transaction->payment_status === 'pending')

                        <a href="/payments/{{ $transaction->id }}" class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-6 py-3 font-semibold text-white transition hover:bg-rose-500">
                            Pay Now
                        </a>

                    @endif

                </div>

            </div>

        @empty

            <div class="rounded-[32px] border border-dashed border-slate-300 bg-white/70 py-20 text-center shadow-sm">

                <h2 class="text-3xl font-bold text-slate-900">
                    No orders yet
                </h2>

                <p class="mt-3 text-slate-500">Belum ada transaksi. Mulai belanja untuk melihat riwayat pesanan Anda di sini.</p>

                <a href="/products" class="mt-8 inline-flex rounded-2xl bg-slate-900 px-6 py-3 text-white transition hover:bg-rose-500">
                    Start Shopping
                </a>

            </div>

        @endforelse

    </div>

@endsection
