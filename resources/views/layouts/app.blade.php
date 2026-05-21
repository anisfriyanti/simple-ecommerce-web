<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ config('app.name') }}</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>
<body class="min-h-screen bg-gradient-to-b from-rose-50 via-white to-slate-50 text-gray-800">

    @include('components.navbar')

    <main class="pb-16">
        @yield('content')
    </main>

</body>
</html>