@extends('layouts.app')

@section('content')

<div class="
    max-w-5xl
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
            Manage Categories
        </h1>

        <a
            href="/admin/categories/create"
            class="
                bg-black
                text-white
                px-6
                py-3
                rounded-2xl
            "
        >
            Add Category
        </a>

    </div>

    <div class="space-y-4">

       @foreach($categories as $category)

    <div class="
        border
        rounded-2xl
        p-6
        flex
        justify-between
        items-center
    ">

        <h2 class="
            text-2xl
            font-semibold
        ">
            {{ $category->name }}
        </h2>

        <div class="
            flex
            items-center
            gap-3
        ">

            <a
                href="/admin/categories/{{ $category->id }}/edit"
                class="
                    px-4
                    py-2
                    rounded-xl
                    bg-blue-100
                    text-blue-600
                "
            >
                Edit
            </a>

            <form
                action="/admin/categories/{{ $category->id }}"
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
                    "
                    onclick="
                        return confirm(
                            'Delete this category?'
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