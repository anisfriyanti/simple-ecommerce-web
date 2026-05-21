@extends('layouts.app')

@section('content')

<div class="
    max-w-4xl
    mx-auto
    px-6
    py-16
">

    <h1 class="
        text-4xl
        font-bold
        mb-10
    ">
        Edit Product
    </h1>

    <form
        action="/admin/products/{{ $product->id }}"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-6"
    >

        @csrf
        @method('PUT')

        <div>

            <label class="block mb-2">
                Product Name
            </label>

            <input
                type="text"
                name="name"
                value="{{ $product->name }}"
                class="
                    w-full
                    border
                    rounded-2xl
                    px-4
                    py-3
                "
            >

        </div>

        <div>

            <label class="block mb-2">
                Slug
            </label>

            <input
                type="text"
                name="slug"
                value="{{ $product->slug }}"
                class="
                    w-full
                    border
                    rounded-2xl
                    px-4
                    py-3
                "
            >

        </div>

        <div>

            <label class="block mb-2">
                Description
            </label>

            <textarea
                name="description"
                rows="5"
                class="
                    w-full
                    border
                    rounded-2xl
                    px-4
                    py-3
                "
            >{{ $product->description }}</textarea>

        </div>

        <div>

            <label class="block mb-2">
                Price
            </label>

            <input
                type="number"
                name="price"
                value="{{ $product->price }}"
                class="
                    w-full
                    border
                    rounded-2xl
                    px-4
                    py-3
                "
            >

        </div>

        <div>

            <label class="block mb-2">
                Stock
            </label>

            <input
                type="number"
                name="stock"
                value="{{ $product->stock }}"
                class="
                    w-full
                    border
                    rounded-2xl
                    px-4
                    py-3
                "
            >

        </div>

        <div>

            <label class="block mb-2">
                Category
            </label>

            <select
                name="category_id"
                class="
                    w-full
                    border
                    rounded-2xl
                    px-4
                    py-3
                "
            >

                @foreach($categories as $category)

                    <option
                        value="{{ $category->id }}"
                        @selected(
                            $product->category_id === $category->id
                        )
                    >
                        {{ $category->name }}
                    </option>

                @endforeach

            </select>

        </div>

        <div>

            <label class="block mb-2">
                Current Image
            </label>

            <img
                src="{{ asset('storage/' . $product->image) }}"
                class="
                    w-40
                    rounded-2xl
                    mb-4
                "
            >

            <input
                type="file"
                name="image"
            >

        </div>

        <div class="
            flex
            items-center
            gap-3
        ">

            <input
                type="checkbox"
                name="is_featured"
                value="1"
                @checked($product->is_featured)
            >

            <label>
                Featured Product
            </label>

        </div>

        <button class="
            bg-black
            text-white
            px-8
            py-4
            rounded-2xl
        ">
            Update Product
        </button>

    </form>

</div>

@endsection