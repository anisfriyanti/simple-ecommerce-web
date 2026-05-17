@extends('layouts.app')

@section('content')

<div class="
    max-w-3xl
    mx-auto
    px-6
    py-16
">

    <h1 class="
        text-4xl
        font-bold
        mb-10
    ">
        Upload Payment Proof
    </h1>

    <div class="
        border
        rounded-3xl
        p-8
    ">

        <div class="mb-6">

            <h2 class="
                text-2xl
                font-semibold
            ">
                {{ $transaction->invoice_number }}
            </h2>

            <p class="text-gray-500 mt-2">
                Total:
                Rp {{ number_format($transaction->grand_total) }}
            </p>

        </div>

        <form
            action="/payments/{{ $transaction->id }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf

            <div class="mb-6">

                <label class="
                    block
                    mb-2
                    font-medium
                ">
                    Upload Payment Proof
                </label>

                <input
                    type="file"
                    name="payment_proof"
                    class="
                        w-full
                        border
                        rounded-2xl
                        p-4
                    "
                >

            </div>

            <button class="
                bg-black
                text-white
                px-8
                py-4
                rounded-2xl
                hover:opacity-80
            ">
                Submit Payment
            </button>

        </form>

    </div>

</div>

@endsection