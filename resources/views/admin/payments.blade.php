@extends('layouts.app')

@section('content')

<div class="
    max-w-7xl
    mx-auto
    px-6
    py-16
">

    <div class="
        flex
        justify-between
        items-center
        mb-10
    ">

        <h1 class="
            text-4xl
            font-bold
        ">
            Payment Verification
        </h1>

    </div>

    <div class="space-y-8">

        @forelse($payments as $payment)

            <div class="
                border
                rounded-3xl
                p-8
            ">

                <div class="
                    flex
                    justify-between
                    items-start
                ">

                    <div>

                        <h2 class="
                            text-2xl
                            font-bold
                        ">
                            {{ $payment->transaction->invoice_number }}
                        </h2>

                        <p class="
                            text-gray-500
                            mt-2
                        ">
                            User:
                            {{ $payment->transaction->user->name }}
                        </p>

                        <p class="
                            text-gray-500
                            mt-2
                        ">
                            Total:
                            Rp {{ number_format($payment->transaction->grand_total) }}
                        </p>

                    </div>

                    <div>

                        <span class="
                            bg-yellow-100
                            text-yellow-600
                            px-4
                            py-2
                            rounded-full
                            text-sm
                        ">
                            {{ $payment->payment_status }}
                        </span>

                    </div>

                </div>

                <div class="
                    mt-8
                ">

                    @if($payment->payment_proof)

                        <img
                            src="{{ asset('storage/' . $payment->payment_proof) }}"
                            class="
                                w-64
                                rounded-2xl
                                border
                            "
                        >

                    @endif

                </div>

                @if($payment->payment_status !== 'paid')

                    <form
                        action="/admin/payments/{{ $payment->id }}/approve"
                        method="POST"
                        class="mt-8"
                    >

                        @csrf

                        <button class="
                            bg-green-500
                            text-white
                            px-6
                            py-3
                            rounded-2xl
                            hover:opacity-80
                        ">
                            Approve Payment
                        </button>

                    </form>

                @endif

            </div>

        @empty

            <div class="
                text-center
                py-20
            ">

                <h2 class="
                    text-3xl
                    font-semibold
                ">
                    No payments found
                </h2>

            </div>

        @endforelse

    </div>

</div>

@endsection