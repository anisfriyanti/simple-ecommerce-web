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
        Add Category
    </h1>

    <form
        action="/admin/categories"
        method="POST"
        class="space-y-6"
    >

        @csrf

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
            Save Category
        </button>

    </form>

</div>

@endsection