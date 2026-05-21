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

    <div class="space-y-8">

        @foreach($transactions as $transaction)

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

                    <div class="flex flex-wrap gap-3 text-right">

                        <div class="inline-block rounded-full bg-green-100 px-4 py-2 text-sm font-semibold text-green-700">
                            {{ $transaction->payment_status }}
                        </div>

                        <div class="inline-block rounded-full bg-blue-100 px-4 py-2 text-sm font-semibold text-blue-700">
                            {{ ucfirst($transaction->transaction_status) }}
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
                                    Qty:
                                    {{ $item->qty }}
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

    {{-- ORDER STATUS BADGE --}}
    <div class="mb-6">

        <p class="mb-2 text-sm text-slate-500">
            Order Status
        </p>

        <div class="inline-block rounded-full bg-blue-100 px-4 py-2 font-semibold text-blue-600">
            {{ ucfirst($transaction->transaction_status) }}
        </div>

    </div>

    {{-- UPDATE STATUS FORM --}}
    <form
        action="/admin/orders/{{ $transaction->id }}/status"
        method="POST"
        class="
            flex
            gap-4
            items-center
            flex-wrap
        "
    >

        @csrf

        <select
            name="transaction_status"
            class="rounded-2xl border border-slate-200 px-4 py-3 shadow-sm focus:border-rose-300 focus:outline-none focus:ring-2 focus:ring-rose-100"
        >

            <option
                value="pending"
                @selected(
                    $transaction->transaction_status === 'pending'
                )
            >
                Pending
            </option>

            <option
                value="paid"
                @selected(
                    $transaction->transaction_status === 'paid'
                )
            >
                Paid
            </option>

            <option
                value="processing"
                @selected(
                    $transaction->transaction_status === 'processing'
                )
            >
                Processing
            </option>

            <option
                value="shipped"
                @selected(
                    $transaction->transaction_status === 'shipped'
                )
            >
                Shipped
            </option>

            <option
                value="completed"
                @selected(
                    $transaction->transaction_status === 'completed'
                )
            >
                Completed
            </option>

            <option
                value="cancelled"
                @selected(
                    $transaction->transaction_status === 'cancelled'
                )
            >
                Cancelled
            </option>

        </select>

        <button class="rounded-2xl bg-slate-900 px-6 py-3 font-semibold text-white transition hover:bg-rose-500">
            Update Status
        </button>


                    </form>

                </div>

            </div>

        @endforeach

    </div>

</div>

@endsection