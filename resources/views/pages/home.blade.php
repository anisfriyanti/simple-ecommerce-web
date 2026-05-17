@extends('layouts.app')

@section('content')

<!-- HERO SECTION -->
<section class="
    min-h-screen
    bg-gradient-to-b
    from-pink-50
    to-white
">

    <div class="
        max-w-7xl
        mx-auto
        px-6
        py-24
        grid
        lg:grid-cols-2
        gap-12
        items-center
    ">

        <!-- LEFT CONTENT -->
        <div>

            <span class="
                inline-block
                bg-pink-100
                text-pink-500
                px-4
                py-2
                rounded-full
                text-sm
                font-medium
            ">
                Beauty • Skincare • Lifestyle
            </span>

            <h1 class="
                text-5xl
                lg:text-7xl
                font-bold
                leading-tight
                mt-6
            ">
                Elevate Your
                <span class="text-pink-500">
                    Beauty
                </span>
                Experience
            </h1>

            <p class="
                mt-6
                text-gray-600
                text-lg
                leading-relaxed
            ">
                Discover modern skincare and beauty essentials
                designed for confidence, elegance, and everyday glow.
            </p>

            <div class="mt-10 flex gap-4">

                <a
                    href="/products"
                    class="
                        bg-black
                        text-white
                        px-8
                        py-4
                        rounded-2xl
                        hover:opacity-80
                        transition
                    "
                >
                    Shop Now
                </a>

                <a
                    href="/products"
                    class="
                        border
                        border-black
                        px-8
                        py-4
                        rounded-2xl
                        hover:bg-black
                        hover:text-white
                        transition
                    "
                >
                    Explore
                </a>

            </div>

        </div>

        <!-- RIGHT IMAGE -->
        <div class="relative">

            <div class="
                absolute
                -top-10
                -left-10
                w-72
                h-72
                bg-pink-200
                rounded-full
                blur-3xl
                opacity-40
            ">
            </div>

            <div class="
                relative
                bg-white
                rounded-[40px]
                shadow-2xl
                overflow-hidden
            ">

                <img
                    src=\"https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?q=80&w=1200&auto=format&fit=crop\"
                    alt=\"Beauty Product\"
                    class=\"w-full h-[600px] object-cover\"
                >

            </div>

        </div>

    </div>

</section>


<!-- FEATURED PRODUCTS -->
<section class="py-24 bg-white">

    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-16">

            <span class="
                text-pink-500
                font-medium
            ">
                Featured Collection
            </span>

            <h2 class="
                text-4xl
                font-bold
                mt-4
            ">
                Best Seller Products
            </h2>

            <p class="
                text-gray-500
                mt-4
            ">
                Curated beauty essentials loved by our customers.
            </p>

        </div>

        <div class="
            grid
            grid-cols-1
            md:grid-cols-2
            lg:grid-cols-3
            gap-8
        ">

            @foreach($featuredProducts as $product)

                <div class="
                    bg-white
                    rounded-3xl
                    overflow-hidden
                    shadow-sm
                    hover:shadow-xl
                    transition
                ">

                    <div class="
                        h-80
                        bg-gray-100
                    ">
                    </div>

                    <div class="p-6">

                        <span class="
                            text-sm
                            text-pink-500
                            font-medium
                        ">
                            {{ $product->category->name }}
                        </span>

                        <h3 class="
                            text-2xl
                            font-semibold
                            mt-3
                        ">
                            {{ $product->name }}
                        </h3>

                        <p class="
                            text-gray-500
                            mt-3
                        ">
                            {{ $product->short_description }}
                        </p>

                        <div class="
                            mt-6
                            flex
                            items-center
                            justify-between
                        ">

                            <strong class="text-xl">

                                Rp {{ number_format($product->price) }}

                            </strong>

                            <button class="
                                bg-black
                                text-white
                                px-5
                                py-3
                                rounded-2xl
                                hover:opacity-80
                            ">
                                View
                            </button>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</section>

@endsection