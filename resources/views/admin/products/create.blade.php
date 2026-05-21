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
        Add Product
    </h1>

    <form
        action="/admin/products"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-6"
    >

        @csrf

        <div>

            <label class="block mb-2">
                Product Name
            </label>

            <input
                type="text"
                name="name"
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
            ></textarea>

        </div>

        <div>

            <label class="block mb-2">
                Price
            </label>

            <input
                type="number"
                name="price"
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
                    >
                        {{ $category->name }}
                    </option>

                @endforeach

            </select>

        </div>

        <div>

            <label class="block mb-2">
                Product Image
            </label>

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
            Save Product
        </button>

    </form>

</div>

@endsection