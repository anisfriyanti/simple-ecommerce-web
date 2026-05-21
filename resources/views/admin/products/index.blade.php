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
            Manage Products
        </h1>

        <a
            href="/admin/products/create"
            class="
                bg-black
                text-white
                px-6
                py-3
                rounded-2xl
            "
        >
            Add Product
        </a>

    </div>

    <div class="space-y-6">

   @foreach($products as $product)

        <div class="
            border
            rounded-3xl
            p-6
            flex
            justify-between
            items-center
            bg-white
            shadow-sm
        ">

            <div class="
                flex
                items-center
                gap-6
            ">

                <img
                    src="{{ asset('storage/' . $product->image) }}"
                    class="
                        w-24
                        h-24
                        object-cover
                        rounded-2xl
                    "
                >

                <div>

                    <h2 class="
                        text-2xl
                        font-bold
                    ">
                        {{ $product->name }}
                    </h2>

                    <p class="
                        text-gray-500
                        mt-2
                    ">
                        Rp {{ number_format($product->price) }}
                    </p>

                </div>

            </div>

            <div class="
                flex
                items-center
                gap-3
            ">

                <a
                    href="/admin/products/{{ $product->id }}/edit"
                    class="
                        px-4
                        py-2
                        rounded-xl
                        bg-blue-100
                        text-blue-600
                        hover:bg-blue-200
                        transition
                    "
                >
                    Edit
                </a>

                <form
                    action="/admin/products/{{ $product->id }}"
                    method="POST"
                >

                    @csrf
                    @method('DELETE')

                    <button
                        class="
                            px-4
                            py-2
                            rounded-xl
                            bg-red-100
                            text-red-600
                            hover:bg-red-200
                            transition
                        "
                        onclick="
                            return confirm(
                                'Delete this product?'
                            )
                        "
                    >
                        Delete
                    </button>

                </form>

            </div>

        </div>

    @endforeach

    </div>

</div>

@endsection