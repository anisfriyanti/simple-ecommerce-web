@extends('layouts.app')

@section('content')

    <div class="
        max-w-7xl
        mx-auto
        px-6
        py-16
    ">

        <div class="
            grid
            lg:grid-cols-2
            gap-16
            items-start
        ">

            <!-- PRODUCT IMAGE -->
            <div>

                <div class="
                    bg-gray-100
                    rounded-3xl
                    h-[600px]
                ">
                </div>

            </div>

            <!-- PRODUCT INFO -->
            <div>

                <span class="
                    text-pink-500
                    font-medium
                ">
                    {{ $product->category->name }}
                </span>

                <h1 class="
                    text-5xl
                    font-bold
                    mt-4
                ">
                    {{ $product->name }}
                </h1>

                <p class="
                    text-gray-500
                    mt-6
                    leading-relaxed
                ">
                    {{ $product->description }}
                </p>

                <div class="mt-10">

                    <strong class="
                        text-4xl
                    ">
                        Rp {{ number_format($product->price) }}
                    </strong>

                </div>

                <div class="
                    mt-10
                    flex
                    gap-4
                ">

                    <form action="/cart/add/{{ $product->id }}" method="POST">

                        @csrf

                        <button class="
                            bg-black
                            text-white
                            px-8
                            py-4
                            rounded-2xl
                            hover:opacity-80
                        ">
                            Add to Cart
                        </button>

                    </form>

                    <button class="
                        border
                        border-black
                        px-8
                        py-4
                        rounded-2xl
                        hover:bg-black
                        hover:text-white
                    ">
                        Buy Now
                    </button>

                </div>

                <div class="
                    mt-10
                    border-t
                    pt-8
                ">

                    <div class="flex justify-between py-2">
                        <span>Stock</span>
                        <span>{{ $product->stock }}</span>
                    </div>

                    <div class="flex justify-between py-2">
                        <span>SKU</span>
                        <span>{{ $product->sku }}</span>
                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection