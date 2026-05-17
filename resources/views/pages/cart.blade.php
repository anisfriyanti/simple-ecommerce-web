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
        Shopping Cart
    </h1>

    @if($cart && $cart->items->count())

        <div class="space-y-6">

            @php
                $grandTotal = 0;
            @endphp

            @foreach($cart->items as $item)

                @php
                    $grandTotal += $item->subtotal;
                @endphp

                <div class="
                    border
                    rounded-3xl
                    p-6
                    flex
                    justify-between
                    items-center
                ">

                    <div>

                        <h3 class="
                            text-2xl
                            font-semibold
                        ">
                            {{ $item->product->name }}
                        </h3>

                        <p class="text-gray-500 mt-2">
                            Qty:
                            {{ $item->qty }}
                        </p>

                    </div>

                    <div class="text-right">

                        <strong class="
                            text-2xl
                        ">
                            Rp {{ number_format($item->subtotal) }}
                        </strong>

                    </div>

                </div>

            @endforeach

        </div>

        <div class="
            mt-10
            border-t
            pt-8
            flex
            justify-between
            items-center
        ">

            <div>

                <h2 class="
                    text-3xl
                    font-bold
                ">
                    Total:
                    Rp {{ number_format($grandTotal) }}
                </h2>

            </div>

           <form
    action="/checkout"
    method="POST"
>

    @csrf

    <button class="
        bg-black
        text-white
        px-8
        py-4
        rounded-2xl
        hover:opacity-80
    ">
        Checkout
    </button>

</form>

        </div>

    @else

        <div class="
            text-center
            py-20
        ">

            <h2 class="
                text-3xl
                font-semibold
            ">
                Your cart is empty
            </h2>

        </div>

    @endif

</div>

@endsection