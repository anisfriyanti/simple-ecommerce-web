@extends('layouts.app')

@section('content')

<div class="
    max-w-3xl
    mx-auto
    px-6
    py-16
">

    <h1 class="
        text-4xl
        font-bold
        mb-10
    ">
        Edit Category
    </h1>

    <form
        action="/admin/categories/{{ $category->id }}"
        method="POST"
        class="space-y-6"
    >

        @csrf
        @method('PUT')

        <div>

            <label class="
                block
                mb-2
            ">
                Category Name
            </label>

            <input
                type="text"
                name="name"
                value="{{ $category->name }}"
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

            <label class="
                block
                mb-2
            ">
                Slug
            </label>

            <input
                type="text"
                name="slug"
                value="{{ $category->slug }}"
                class="
                    w-full
                    border
                    rounded-2xl
                    px-4
                    py-3
                "
            >

        </div>

        <button class="
            bg-black
            text-white
            px-8
            py-4
            rounded-2xl
        ">
            Update Category
        </button>

    </form>

</div>

@endsection