<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Publik | Siporma</title>

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    @vite(['resources/css/app.css','resources/js/app.js'])

</head>

<body class="bg-gray-50 text-gray-800">

    <!-- NAVBAR -->
    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">

            <div class="flex items-center gap-3">
                <img src="{{ asset('images/icon/prov_sumbar.png') }}" class="h-10 w-auto">
                <span class="text-xl font-bold text-gray-900 tracking-tight">
                    Siporma<span class="text-blue-600">.</span>
                </span>
            </div>

            <div class="flex gap-4">

                <a href="{{ route('public.dashboard') }}" class="text-gray-600 hover:text-blue-600 font-medium">
                    Dashboard
                </a>

                <a href="{{ route('public.project') }}" class="text-gray-600 hover:text-blue-600 font-medium">
                    Project
                </a>

                <a href="{{ route('login') }}"
                    class="px-5 py-2.5 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                    Masuk
                </a>

            </div>

        </div>
    </nav>


    <!-- HERO -->
    <section class="relative pt-20 pb-24 overflow-hidden">

        <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center">

            <div>

                <span class="px-4 py-2 bg-blue-50 text-blue-600 text-sm font-semibold rounded-full mb-6 inline-block">
                    Project Mahasiswa Magang
                </span>

                <h1 class="text-5xl font-extrabold text-gray-900 leading-tight mb-6">
                    Dashboard Publik
                    <span class="text-blue-600">Project Magang</span>
                </h1>

                <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                    Menampilkan berbagai project mahasiswa magang yang telah divalidasi oleh
                    Dinas Kominfo dan Statistik.
                </p>

                <div class="flex gap-4">

                    <a href="{{ route('public.project') }}"
                        class="px-8 py-4 bg-blue-600 text-white rounded-2xl font-bold hover:scale-105 transition shadow-xl shadow-blue-200">

                        Lihat Semua Project

                    </a>

                </div>

            </div>

            <div class="relative">

                <div class="absolute -top-20 -right-20 w-64 h-64 bg-blue-100 rounded-full blur-3xl opacity-50"></div>

                <img src="{{ asset('images/icon/kampus.png') }}" class="relative z-10 w-4/5 mx-auto rounded-3xl">

            </div>

        </div>

    </section>


    <!-- STATISTIK -->
    <section class="bg-white py-16">

        <div class="max-w-7xl mx-auto px-6">

            <div class="grid md:grid-cols-4 gap-6 text-center">

                <div class="bg-gray-50 p-8 rounded-xl">
                    <h3 class="text-3xl font-bold text-blue-600">150+</h3>
                    <p class="text-sm text-gray-500">Mahasiswa Magang</p>
                </div>

                <div class="bg-gray-50 p-8 rounded-xl">
                    <h3 class="text-3xl font-bold text-blue-600">500+</h3>
                    <p class="text-sm text-gray-500">Project</p>
                </div>

                <div class="bg-gray-50 p-8 rounded-xl">
                    <h3 class="text-3xl font-bold text-blue-600">30+</h3>
                    <p class="text-sm text-gray-500">Universitas</p>
                </div>

                <div class="bg-gray-50 p-8 rounded-xl">
                    <h3 class="text-3xl font-bold text-blue-600">12</h3>
                    <p class="text-sm text-gray-500">Kategori Teknologi</p>
                </div>

            </div>

        </div>

    </section>

    <!-- PROJECT TERBARU -->
    <section class="py-20">

        <div class="max-w-7xl mx-auto px-6">

            <h2 class="text-3xl font-bold mb-10">
                Project Terbaru
            </h2>

            <div class="grid md:grid-cols-3 gap-8">

                @forelse($projects as $project)

                <div class="bg-white rounded-2xl border border-gray-100 p-6 hover:shadow-xl transition">

                    <h3 class="font-bold text-lg mb-2">
                        {{ $project->title }}
                    </h3>

                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                        {{ $project->description }}
                    </p>

                    <p class="text-sm text-gray-500">
                        {{ $project->user->profile->pr_nama ?? '-' }}
                    </p>

                    <p class="text-xs text-gray-400 mb-4">
                        {{ $project->user->profile->kampus->km_nama_kampus ?? '-' }}
                    </p>

                    <div class="flex flex-wrap gap-2 mb-4">

                        @forelse($project->teknologis as $tech)

                        <span class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded-lg">
                            {{ $tech->nama }}
                        </span>

                        @empty

                        <span class="text-xs text-gray-400">
                            Tidak ada teknologi
                        </span>

                        @endforelse

                    </div>

                    <a href="{{ route('public.project.detail',$project->id) }}"
                        class="text-blue-600 text-sm font-semibold hover:underline">

                        Detail Project →

                    </a>

                </div>

                @empty

                <p class="text-gray-500">
                    Belum ada project yang dipublish
                </p>

                @endforelse

            </div>

        </div>

    </section>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-white text-center py-6 mt-20">

        Siporma © {{ date('Y') }}

    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        AOS.init({
            duration: 1000,
            once: true
        });

    </script>
</body>

</html>
