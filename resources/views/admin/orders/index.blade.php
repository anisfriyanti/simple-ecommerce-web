@extends('layouts.app')

@section('content')

<div class="
    max-w-7xl
    mx-auto
    px-6
    py-16
">

    <div class="
        mb-12
    ">

        <h1 class="
            text-5xl
            font-bold
        ">
            Order Management
        </h1>

        <p class="
            text-gray-500
            mt-3
        ">
            Manage customer transactions and shipping.
        </p>

    </div>

    <div class="space-y-8">

        @foreach($transactions as $transaction)

            <div class="
                border
                rounded-3xl
                p-8
                bg-white
                shadow-sm
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
                            {{ $transaction->invoice_number }}
                        </h2>

                        <p class="
                            text-gray-500
                            mt-2
                        ">
                            Customer:
                            {{ $transaction->user->name }}
                        </p>

                        <p class="
                            text-gray-500
                            mt-2
                        ">
                            Total:
                            Rp {{ number_format($transaction->grand_total) }}
                        </p>

                    </div>

                    <div class="
                        text-right
                    ">

                        <p class="
                            text-sm
                            text-gray-500
                        ">
                            Payment Status
                        </p>

                        <div class="
                            mt-2
                            inline-block
                            px-4
                            py-2
                            rounded-full
                            bg-green-100
                            text-green-600
                        ">
                            {{ $transaction->payment_status }}
                        </div>

                    </div>

                </div>

                {{-- ITEMS --}}
                <div class="
                    mt-8
                    border-t
                    pt-6
                    space-y-4
                ">

                    @foreach($transaction->items as $item)

                        <div class="
                            flex
                            justify-between
                        ">

                            <div>

                                <p class="
                                    font-semibold
                                ">
                                    {{ $item->product->name }}
                                </p>

                                <p class="
                                    text-sm
                                    text-gray-500
                                ">
                                    Qty:
                                    {{ $item->quantity }}
                                </p>

                            </div>

                            <p class="
                                font-semibold
                            ">
                                Rp {{ number_format($item->subtotal) }}
                            </p>

                        </div>

                    @endforeach

                </div>

                {{-- STATUS UPDATE --}}
                <div class="
    mt-8
    border-t
    pt-6
">

    {{-- ORDER STATUS BADGE --}}
    <div class="mb-6">

        <p class="
            text-sm
            text-gray-500
            mb-2
        ">
            Order Status
        </p>

        <div class="
            inline-block
            px-4
            py-2
            rounded-full
            bg-blue-100
            text-blue-600
            font-semibold
        ">
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
            class="
                border
                rounded-xl
                px-4
                py-3
            "
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

        <button class="
            bg-black
            text-white
            px-6
            py-3
            rounded-2xl
            hover:opacity-90
            transition
        ">
            Update Status
        </button>


                    </form>

                </div>

            </div>

        @endforeach

    </div>

</div>

@endsection