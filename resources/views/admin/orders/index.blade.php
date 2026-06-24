@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl px-6 py-16">

    <div class="mb-12 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">

        <div>
            <span class="inline-flex rounded-full border border-rose-200 bg-white px-4 py-2 text-sm font-semibold text-rose-500 shadow-sm">
                Admin dashboard
            </span>

            <h1 class="mt-5 text-5xl font-black tracking-tight text-slate-900">
                Order Management
            </h1>

            <p class="mt-3 text-slate-500">
                Manage customer transactions and shipping.
            </p>
        </div>

        <div class="rounded-[28px] border border-white/70 bg-white/80 px-6 py-5 shadow-sm backdrop-blur">
            <p class="text-sm text-slate-500">Total orders</p>
            <p class="mt-1 text-3xl font-black text-slate-900">{{ $transactions->count() }}</p>
        </div>

    </div>

    @php
        $paymentStatusLabels = [
            'paid' => 'Paid',
            'pending' => 'Pending',
            'expired' => 'Expired',
            'cancelled' => 'Cancelled',
            'failed' => 'Failed',
        ];

        $orderStatuses = [
            'pending' => 'Pending',
            'processing' => 'Processing',
            'shipped' => 'Shipped',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ];

        $paymentStatusClasses = [
            'paid' => 'bg-green-100 text-green-700 ring-green-200',
            'pending' => 'bg-amber-100 text-amber-700 ring-amber-200',
            'expired' => 'bg-slate-100 text-slate-700 ring-slate-200',
            'cancelled' => 'bg-red-100 text-red-700 ring-red-200',
            'failed' => 'bg-red-100 text-red-700 ring-red-200',
        ];

        $orderStatusClasses = [
            'pending' => 'bg-amber-100 text-amber-700 ring-amber-200',
            'processing' => 'bg-blue-100 text-blue-700 ring-blue-200',
            'shipped' => 'bg-indigo-100 text-indigo-700 ring-indigo-200',
            'completed' => 'bg-green-100 text-green-700 ring-green-200',
            'cancelled' => 'bg-red-100 text-red-700 ring-red-200',
        ];
    @endphp

    <div class="space-y-8">

        @foreach($transactions as $transaction)

            @php
                $paymentStatus = $transaction->payment_status ?? 'pending';
                $orderStatus = $transaction->transaction_status ?? 'pending';
                $paymentBadgeClass = $paymentStatusClasses[$paymentStatus] ?? $paymentStatusClasses['pending'];
                $orderBadgeClass = $orderStatusClasses[$orderStatus] ?? $orderStatusClasses['pending'];
            @endphp

            <div class="rounded-[32px] border border-white/70 bg-white p-8 shadow-sm">

                <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">

                    <div>

                        <h2 class="text-2xl font-bold text-slate-900">
                            {{ $transaction->invoice_number }}
                        </h2>

                        <p class="mt-2 text-slate-500">
                            Customer:
                            {{ $transaction->user->name }}
                        </p>

                        <p class="mt-2 text-slate-500">
                            Total:
                            Rp {{ number_format($transaction->grand_total) }}
                        </p>

                    </div>

                    <div class="flex flex-wrap gap-3 lg:justify-end">

                        <div class="rounded-2xl border border-slate-100 bg-slate-50 px-4 py-3">
                            <p class="text-xs font-bold uppercase tracking-wide text-slate-500">
                                Payment Status
                            </p>

                            <span class="mt-2 inline-flex rounded-full px-3 py-1 text-sm font-semibold ring-1 {{ $paymentBadgeClass }}">
                                {{ $paymentStatusLabels[$paymentStatus] ?? ucfirst($paymentStatus) }}
                            </span>
                        </div>

                        <div class="rounded-2xl border border-slate-100 bg-slate-50 px-4 py-3">
                            <p class="text-xs font-bold uppercase tracking-wide text-slate-500">
                                Order Status
                            </p>

                            <span class="mt-2 inline-flex rounded-full px-3 py-1 text-sm font-semibold ring-1 {{ $orderBadgeClass }}">
                                {{ $orderStatuses[$orderStatus] ?? ucfirst($orderStatus) }}
                            </span>
                        </div>

                    </div>

                </div>

                {{-- ITEMS --}}
                <div class="mt-8 space-y-4 rounded-[28px] bg-slate-50 p-6">

                    @foreach($transaction->items as $item)

                        <div class="flex flex-col justify-between gap-4 border-b border-slate-200 pb-4 last:border-b-0 last:pb-0 md:flex-row md:items-center">

                            <div class="flex items-center gap-4">

                                <img
                                    src="{{ $item->product->thumbnail ? asset('storage/' . $item->product->thumbnail) : 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?q=80&w=800&auto=format&fit=crop' }}"
                                    alt="{{ $item->product->name }}"
                                    class="h-16 w-16 rounded-2xl object-cover"
                                >

                                <div>
                                    <p class="font-semibold text-slate-900">
                                        {{ $item->product->name }}
                                    </p>

                                    <p class="text-sm text-slate-500">
                                        Qty: {{ $item->qty }}
                                    </p>

                                </div>

                            </div>

                            <p class="font-semibold text-slate-900">
                                Rp {{ number_format($item->subtotal) }}
                            </p>

                        </div>

                    @endforeach

                </div>

                {{-- STATUS UPDATE --}}
                <div class="mt-8 rounded-[28px] border border-slate-200 bg-white p-6">

                    <div class="mb-5">
                        <p class="text-sm font-bold uppercase tracking-wide text-slate-400">
                            Update Order Status
                        </p>
                        <p class="mt-1 text-sm text-slate-500">
                            This form only changes the order/shipping status. Payment status stays controlled by payment flow.
                        </p>
                    </div>

                    <form
                        action="/admin/orders/{{ $transaction->id }}/status"
                        method="POST"
                        class="flex flex-wrap items-center gap-4"
                    >

                        @csrf

                        <select
                            name="transaction_status"
                            aria-label="Order status"
                            class="rounded-2xl border border-slate-200 px-4 py-3 shadow-sm focus:border-rose-300 focus:outline-none focus:ring-2 focus:ring-rose-100"
                        >

                            @foreach($orderStatuses as $status => $label)
                                <option
                                    value="{{ $status }}"
                                    @selected($orderStatus === $status)
                                >
                                    {{ $label }}
                                </option>
                            @endforeach

                        </select>

                        <button class="rounded-2xl bg-slate-900 px-6 py-3 font-semibold text-white transition hover:bg-rose-500">
                            Save Order Status
                        </button>

                    </form>

                </div>

            </div>

        @endforeach

    </div>

</div>

@endsection
