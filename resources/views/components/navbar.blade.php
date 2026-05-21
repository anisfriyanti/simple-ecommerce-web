<nav class="sticky top-0 z-50 border-b border-white/40 bg-white/80 backdrop-blur-xl">

    <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">

        <div class="flex items-center gap-8">

            <a href="/" class="flex items-center gap-3 text-2xl font-black tracking-tight text-slate-900">
                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-rose-400 via-pink-500 to-orange-400 text-sm text-white shadow-lg shadow-rose-200">
                    BC
                </span>
                <span>
                    BrandCommerce
                </span>
            </a>

            <div class="hidden items-center gap-2 rounded-full border border-slate-200 bg-white/80 p-2 text-sm font-medium text-slate-600 shadow-sm md:flex">

                <a href="/" class="rounded-full px-4 py-2 transition hover:bg-rose-50 hover:text-rose-500">
                    Home
                </a>

                <a href="/products" class="rounded-full px-4 py-2 transition hover:bg-rose-50 hover:text-rose-500">
                    Products
                </a>

            </div>

        </div>

        <div class="flex items-center gap-3 text-sm font-medium text-slate-600">

            @auth

                <a href="/dashboard" class="hidden rounded-full px-4 py-2 transition hover:bg-rose-50 hover:text-rose-500 md:inline-flex">
                    Dashboard
                </a>


                <a href="/cart" class="rounded-full border border-slate-200 bg-white px-4 py-2 shadow-sm transition hover:-translate-y-0.5 hover:border-rose-200 hover:text-rose-500">
                    Cart
                </a>

                <a href="/orders" class="rounded-full border border-slate-200 bg-white px-4 py-2 shadow-sm transition hover:-translate-y-0.5 hover:border-rose-200 hover:text-rose-500">
                    Orders
                </a>
                    @if(auth()->user()->role === 'admin')

                    <a
                        href="/admin"
                        class="hidden rounded-full px-4 py-2 transition hover:bg-rose-50 hover:text-rose-500 md:inline-flex"
                    >
                        Admin
                    </a>

                @endif

                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button type="submit" class="rounded-2xl bg-slate-900 px-5 py-2.5 text-white shadow-lg shadow-slate-200 transition hover:-translate-y-0.5 hover:bg-rose-500">
                        Logout
                    </button>
                </form>

            @else

                <a href="/login" class="rounded-full px-4 py-2 transition hover:bg-rose-50 hover:text-rose-500">
                    Login
                </a>

                <a href="/register" class="rounded-2xl bg-slate-900 px-5 py-2.5 text-white shadow-lg shadow-slate-200 transition hover:-translate-y-0.5 hover:bg-rose-500">
                    Register
                </a>

            @endauth

        </div>

    </div>

</nav>