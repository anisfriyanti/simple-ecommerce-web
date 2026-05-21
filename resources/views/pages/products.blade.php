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
        mb-12
    ">

        <div>

            <h1 class="
                text-5xl
                font-bold
            ">
                Our Products
            </h1>

            <p class="
                text-gray-500
                mt-3
            ">
                Discover our curated beauty collection.
            </p>

        </div>

    </div>

    {{-- CATEGORY FILTER --}}
    <div class="
        flex
        gap-4
        mb-10
        flex-wrap
    ">

        <a
            href="/products"
            class="
                px-5
                py-2
                rounded-full
                border
                hover:bg-black
                hover:text-white
                transition
            "
        >
            All
        </a>

        @foreach($categories as $category)

            <a
                href="/products?category={{ $category->slug }}"
                class="
                    px-5
                    py-2
                    rounded-full
                    border
                    hover:bg-black
                    hover:text-white
                    transition
                "
            >
                {{ $category->name }}
            </a>

        @endforeach

    </div>

    {{-- PRODUCT GRID --}}
    <div class="
        grid
        grid-cols-1
        md:grid-cols-2
        lg:grid-cols-3
        gap-8
    ">

        @foreach($products as $product)

            <a
                href="/products/{{ $product->slug }}"
                class="
                    block
                    bg-white
                    rounded-3xl
                    overflow-hidden
                    shadow-sm
                    hover:shadow-xl
                    transition
                "
            >

                {{-- PRODUCT IMAGE --}}
                <img
                    src="{{ asset('storage/' . $product->image) }}"
                    class="
                        w-full
                        h-80
                        object-cover
                    "
                >

                {{-- PRODUCT CONTENT --}}
                <div class="p-6">

                    {{-- CATEGORY --}}
                    <p class="
                        text-sm
                        text-pink-500
                        font-semibold
                        mb-3
                    ">
                        {{ $product->category->name }}
                    </p>

                    {{-- PRODUCT NAME --}}
                    <h2 class="
                        text-2xl
                        font-bold
                    ">
                        {{ $product->name }}
                    </h2>

                    {{-- DESCRIPTION --}}
                    <p class="
                        text-gray-500
                        mt-3
                        line-clamp-2
                    ">
                        {{ $product->description }}
                    </p>

                    {{-- PRICE --}}
                    <div class="
                        mt-6
                        flex
                        justify-between
                        items-center
                    ">

                        <p class="
                            text-2xl
                            font-bold
                        ">
                            Rp {{ number_format($product->price) }}
                        </p>

                        <div class="
                            px-4
                            py-2
                            rounded-xl
                            bg-black
                            text-white
                            text-sm
                        ">
                            View Product
                        </div>

                    </div>

                </div>

            </a>

        @endforeach

    </div>

</div>

@endsection