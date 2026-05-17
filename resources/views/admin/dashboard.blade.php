@extends('layouts.app')

@section('content')

<div class="
    max-w-7xl
    mx-auto
    px-6
    py-16
">

    <h1 class="
        text-5xl
        font-bold
        mb-12
    ">
        Admin Dashboard
    </h1>

    <div class="
        grid
        grid-cols-1
        md:grid-cols-2
        lg:grid-cols-4
        gap-8
    ">

        <div class="
            bg-white
            shadow-sm
            rounded-3xl
            p-8
        ">

            <p class="text-gray-500">
                Products
            </p>

            <h2 class="
                text-4xl
                font-bold
                mt-4
            ">
                {{ $totalProducts }}
            </h2>

        </div>

        <div class="
            bg-white
            shadow-sm
            rounded-3xl
            p-8
        ">

            <p class="text-gray-500">
                Users
            </p>

            <h2 class="
                text-4xl
                font-bold
                mt-4
            ">
                {{ $totalUsers }}
            </h2>

        </div>

        <div class="
            bg-white
            shadow-sm
            rounded-3xl
            p-8
        ">

            <p class="text-gray-500">
                Transactions
            </p>

            <h2 class="
                text-4xl
                font-bold
                mt-4
            ">
                {{ $totalTransactions }}
            </h2>

        </div>

        <div class="
            bg-white
            shadow-sm
            rounded-3xl
            p-8
        ">

            <p class="text-gray-500">
                Income
            </p>

            <h2 class="
                text-3xl
                font-bold
                mt-4
            ">
                Rp {{ number_format($totalIncome) }}
            </h2>

        </div>

    </div>

</div>

@endsection