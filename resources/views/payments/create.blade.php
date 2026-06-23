@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-5xl px-6 py-20">

    <div class="grid gap-8 lg:grid-cols-[1.1fr_0.9fr]">

        <div class="rounded-[36px] border border-white/70 bg-white p-10 shadow-[0_24px_60px_rgba(15,23,42,0.1)] text-center lg:text-left">

        <span class="inline-flex rounded-full border border-rose-200 bg-rose-50 px-4 py-2 text-sm font-semibold text-rose-500">
            Secure payment
        </span>

        <h1 class="mt-6 text-4xl font-black tracking-tight text-slate-900">
            Complete Payment
        </h1>

        <p class="mb-6 mt-4 text-slate-500">
            Invoice:
            {{ $transaction->invoice_number }}
        </p>

        <p class="mb-4 text-sm text-slate-500">
            Selesaikan pembayaran Anda dengan Midtrans untuk memproses pesanan ini.
        </p>

        <p class="mb-10 text-5xl font-black text-slate-900">
            Rp {{ number_format($transaction->grand_total) }}
        </p>

        <button
            id="pay-button"
            class="rounded-2xl bg-slate-900 px-8 py-4 font-semibold text-white shadow-xl shadow-slate-200 transition hover:-translate-y-1 hover:bg-rose-500"
        >
            Pay Now
        </button>

        </div>

        <div class="space-y-6 rounded-[36px] border border-white/70 bg-slate-900 p-8 text-white shadow-[0_24px_60px_rgba(15,23,42,0.16)]">
            <div>
                <p class="text-sm uppercase tracking-[0.2em] text-slate-400">Payment benefit</p>
                <h2 class="mt-3 text-3xl font-black">Fast, clean, and secure checkout.</h2>
            </div>

            <div class="space-y-4 text-sm text-slate-300">
                <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
                    <p class="font-semibold text-white">Protected payment gateway</p>
                    <p class="mt-2">Transaksi diarahkan ke Midtrans agar pembayaran lebih aman dan terpercaya.</p>
                </div>
                <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
                    <p class="font-semibold text-white">Instant confirmation flow</p>
                    <p class="mt-2">Setelah proses selesai, Anda akan langsung kembali ke halaman order.</p>
                </div>
                <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
                    <p class="font-semibold text-white">Invoice reference</p>
                    <p class="mt-2 break-all">{{ $transaction->invoice_number }}</p>
                </div>
            </div>
        </div>

    </div>

</div>

{{-- MIDTRANS --}}
<script
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}"
></script>

<script>

document
    .getElementById('pay-button')
    .onclick = function () {

        window.snap.pay(
            '{{ $transaction->snap_token }}',
            {
                onSuccess: function () {
                    window.location.href = '/orders';
                },
                onPending: function () {
                    window.location.href = '/orders';
                },
                onError: function () {
                    alert('Pembayaran gagal diproses. Silakan coba lagi.');
                },
                onClose: function () {
                    console.log('Customer closed the popup without finishing the payment');
                }
            }
        );
    };

</script>

@endsection