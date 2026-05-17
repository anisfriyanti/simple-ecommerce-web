@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-10">

    <div class="mb-10">
        <h1 class="text-4xl font-bold">
            Our Products
        </h1>

        <p class="text-gray-500 mt-2">
            Discover our latest beauty collection.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

        @foreach($products as $product)

            <div class="bg-white rounded-2xl shadow-sm overflow-hidden hover:shadow-lg transition">

                {{-- <div class="h-64 bg-gray-100"> --}}
                                    <img
                    src="{{ asset('storage/' . $product->image) }}"
                    class="
                        w-full
                        h-80
                        object-cover
                    "
                >
                                {{-- </div> --}}

                <div class="p-5">

                    <span class="text-sm text-pink-500 font-medium">
                        {{ $product->category->name }}
                    </span>

                    <h3 class="text-xl font-semibold mt-2">
                        {{ $product->name }}
                    </h3>

                    <p class="text-gray-500 text-sm mt-2">
                        {{ $product->short_description }}
                    </p>

                    <div class="mt-5 flex items-center justify-between">

                        <strong class="text-lg">
                            Rp {{ number_format($product->price) }}
                        </strong>

                        {{-- <button class="
                            bg-black
                            text-white
                            px-4
                            py-2
                            rounded-xl
                            hover:opacity-80
                        ">
                            View
                        </button> --}}
                        <a
                            href="/products/{{ $product->slug }}"
                            class="
                                bg-black
                                text-white
                                px-4
                                py-2
                                rounded-xl
                                hover:opacity-80
                            "
                        >
                            View
                        </a>

                    </div>

                </div>

            </div>

        @endforeach

    </div>

</div>

@endsection