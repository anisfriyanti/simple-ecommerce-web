@extends('layouts.app')

@section('content')

    <div class="
        max-w-7xl
        mx-auto
        px-6
        py-16
    ">

        <h1 class="
            text-4xl
            font-bold
            mb-10
        ">
            My Orders
        </h1>

        @forelse($transactions as $transaction)

            <div class="
                    border
                    rounded-3xl
                    p-8
                    mb-8
                ">

                <div class="
                        flex
                        justify-between
                        items-center
                        mb-6
                    ">

                    <div>

                        <h2 class="
                                text-2xl
                                font-bold
                            ">
                            {{ $transaction->invoice_number }}
                        </h2>

                        <p class="text-gray-500 mt-2">
                            {{ $transaction->created_at->format('d M Y H:i') }}
                        </p>

                    </div>

                    <div class="text-right">

                        <span class="
                                bg-yellow-100
                                text-yellow-600
                                px-4
                                py-2
                                rounded-full
                                text-sm
                            ">
                            {{ $transaction->payment_status }}
                        </span>

                    </div>

                </div>

                <div class="space-y-4">

                    @foreach($transaction->items as $item)

                        <div class="
                                    flex
                                    justify-between
                                    border-b
                                    pb-4
                                ">

                            <div>

                                <h3 class="font-semibold">
                                    {{ $item->product->name }}
                                </h3>

                                <p class="text-gray-500 text-sm">
                                    Qty:
                                    {{ $item->qty }}
                                </p>

                            </div>

                            <strong>

                                Rp {{ number_format($item->subtotal) }}

                            </strong>

                        </div>

                    @endforeach

                </div>

                <div class="
                        mt-6
                        flex
                        justify-between
                        items-center
                    ">

                    <strong class="
                            text-2xl
                        ">
                        Total:
                        Rp {{ number_format($transaction->grand_total) }}
                    </strong>

                    @if($transaction->payment_status !== 'paid')

                            <a href="/payments/{{ $transaction->id }}" class="
                            bg-black
                            text-white
                            px-6
                            py-3
                            rounded-2xl
                            hover:opacity-80
                        ">
                                Upload Payment
                            </a>

                    @else

                                <span class="
                            bg-green-100
                            text-green-600
                            px-4
                            py-2
                            rounded-full
                            text-sm
                        ">
                                    Paid
                                </span>

                    @endif

                </div>

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
                    No orders yet
                </h2>

            </div>

        @endforelse

    </div>

@endsection