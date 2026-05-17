<nav class="
    border-b
    border-gray-200
    bg-white
    sticky
    top-0
    z-50
">

    <div class="
        max-w-7xl
        mx-auto
        px-6
        py-4
        flex
        items-center
        justify-between
    ">

        <div class="flex items-center gap-8">

            <a href="/" class="text-2xl font-bold">
                BrandCommerce
            </a>

            <div class="flex gap-6 text-sm">

                <a href="/" class="hover:text-pink-500">
                    Home
                </a>

                <a href="/products" class="hover:text-pink-500">
                    Products
                </a>

            </div>

        </div>

        <div class="flex items-center gap-4">

            @auth

                <a href="/dashboard" class="hover:text-pink-500">
                    Dashboard
                </a>


                <a href="/cart" class="hover:text-pink-500">
                    Cart
                </a>

                <a href="/orders" class="hover:text-pink-500">
                    Orders
                </a>
                    @if(auth()->user()->role === 'admin')

                    <a
                        href="/admin"
                        class="hover:text-pink-500"
                    >
                        Admin
                    </a>

                @endif

                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button type="submit" class="
                                bg-black
                                text-white
                                px-4
                                py-2
                                rounded-xl
                                hover:opacity-80
                            ">
                        Logout
                    </button>
                </form>

            @else

                <a href="/login" class="hover:text-pink-500">
                    Login
                </a>

                <a href="/register" class="
                            bg-black
                            text-white
                            px-4
                            py-2
                            rounded-xl
                            hover:opacity-80
                        ">
                    Register
                </a>

            @endauth

        </div>

    </div>

</nav>