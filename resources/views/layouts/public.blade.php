<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-gray-50">

    {{-- NAVBAR PUBLIK --}}
    <header class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

            <h1 class="text-lg font-bold">
                SIPORMA
            </h1>

            <div class="flex gap-4">
                <a href="/" class="text-gray-600 hover:text-black">Home</a>
                <a href="/login" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
                    Login
                </a>
            </div>

        </div>
    </header>


    {{-- CONTENT --}}
    <main class="py-10">
        @yield('content')
    </main>


    {{-- FOOTER --}}
    <footer class="text-center text-sm text-gray-400 py-6">
        © {{ date('Y') }} SIPORMA Diskominfotik
    </footer>

</body>
</html>