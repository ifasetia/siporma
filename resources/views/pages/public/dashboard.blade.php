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
                <img src="{{ asset('images/icon/LOGO.png') }}" class="h-10 w-auto">
                <span class="text-xl font-bold text-gray-900 tracking-tight">
                    Siporma<span class="text-blue-600">.</span>
                </span>
            </div>

            <div class="flex gap-4">

                <a href="{{ route('public.dashboard') }}" class="text-blue-600 font-semibold">
                    Dashboard
                </a>

                <a href="{{ route('public.project') }}" class="text-gray-600 hover:text-blue-600 font-medium">
                    Project
                </a>

                <a href="{{ route('public.analytics') }}" class="text-gray-600 hover:text-blue-600 font-medium">
                    Analytics
                </a>

            </div>

        </div>
    </nav>


    <!-- HERO -->
    <section class="relative pt-20 pb-24 overflow-hidden">

        <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center">

            <div>

                <span class="px-4 py-2 bg-blue-50 text-blue-600 text-sm font-semibold rounded-full mb-6 inline-block">
                    Project Intern
                </span>

                <h1 class="text-5xl → text-4xl font-extrabold → font-bold text-gray-900 leading-tight mb-6">
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

                <img src="{{ asset('images/icon/TEMA.png') }}" class="relative z-10 w-4/5 mx-auto rounded-3xl">

            </div>

        </div>

    </section>



    <!-- STATISTIK -->
    <section class="py-20">

        <div class="max-w-6xl mx-auto px-6">

            <div class="text-center mb-16" data-aos="fade-up">

                <h2 class="text-3xl font-bold text-gray-900 mb-4">
                    Statistik Program Magang
                </h2>

                <div class="w-20 h-1.5 bg-blue-600 mx-auto rounded-full"></div>

                <p class="text-gray-500 mt-4">
                    Data real dari sistem pengelolaan project magang
                </p>

            </div>


            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 justify-items-center">

                <div class="bg-white/80 backdrop-blur-md 
                                p-7 rounded-2xl 
                                border border-gray-200/50 
                                shadow-[0_10px_30px_rgba(0,0,0,0.06)]
                                hover:shadow-xl 
                                hover:-translate-y-1
                                transition-all duration-300 ease-out
                                flex flex-col gap-4
                                max-w-[220px] w-full">
                    <div class="flex items-center gap-4">

                        <div class="w-12 h-12 
        bg-gradient-to-br from-blue-50 to-blue-100 
        rounded-xl flex items-center justify-center 
        shadow-sm">
                            <i data-lucide="user" class="w-6 h-6 text-blue-600"></i>
                        </div>

                        <div>
                            <p class="text-gray-500 text-xs font-bold uppercase tracking-wide">Total Intern</p>
                            <h3 class="text-2xl font-semibold text-gray-900 leading-tight">
                                {{ $totalIntern }}
                            </h3>
                        </div>

                    </div>

                    <p class="text-xs text-gray-400 mt-1">
                        Mahasiswa magang aktif
                    </p>
                </div>

                <div class="bg-white/80 backdrop-blur-md 
    p-6 rounded-2xl 
    border border-gray-200/60 
    shadow-[0_10px_30px_rgba(0,0,0,0.06)]
    hover:shadow-2xl 
    hover:-translate-y-2 
    hover:scale-[1.02]
    transition-all duration-500 ease-out
    flex flex-col gap-4
    max-w-[220px] w-full">

                    <div class="flex items-center gap-4">

                        <div class="w-12 h-12 
            bg-gradient-to-br from-blue-50 to-blue-100 
            rounded-xl flex items-center justify-center 
            shadow-sm">
                            <i data-lucide="folder" class="w-6 h-6 text-indigo-600"></i>
                        </div>

                        <div>
                            <p class="text-gray-500 text-xs font-bold uppercase tracking-wide">Project Publik</p>
                            <h3 class="text-2xl font-semibold tracking-tight text-gray-900">
                                {{ $totalProject }}
                            </h3>
                        </div>

                    </div>

                    <p class="text-xs text-gray-400 mt-1">
                        Project dipublikasikan
                    </p>

                </div>


                <!-- KAMPUS -->
                <div class="bg-white/80 backdrop-blur-md 
    p-6 rounded-2xl 
    border border-gray-200/60 
    shadow-[0_10px_30px_rgba(0,0,0,0.06)]
    hover:shadow-2xl 
    hover:-translate-y-2 
    hover:scale-[1.02]
    transition-all duration-500 ease-out
    flex flex-col gap-4
    max-w-[220px] w-full">

                    <div class="flex items-center gap-4">

                        <div class="w-12 h-12 
            bg-gradient-to-br from-blue-50 to-blue-100 
            rounded-xl flex items-center justify-center 
            shadow-sm">
                            <i data-lucide="building-2" class="w-6 h-6 text-purple-600"></i>
                        </div>

                        <div>
                            <p class="text-gray-500 text-xs font-bold uppercase tracking-wide">Universitas</p>
                            <h3 class="text-2xl font-semibold tracking-tight text-gray-900">
                                {{ $totalKampus }}
                            </h3>
                        </div>

                    </div>

                    <p class="text-xs text-gray-400 mt-1">
                        Universitas terlibat
                    </p>

                </div>

                <!-- TEKNOLOGI -->
                <div class="bg-white/80 backdrop-blur-md 
    p-6 rounded-2xl 
    border border-gray-200/60 
    shadow-[0_10px_30px_rgba(0,0,0,0.06)]
    hover:shadow-2xl 
    hover:-translate-y-2 
    hover:scale-[1.02]
    transition-all duration-500 ease-out
    flex flex-col gap-4
    max-w-[220px] w-full">

                    <div class="flex items-center gap-4">

                        <div class="w-12 h-12 
            bg-gradient-to-br from-blue-50 to-blue-100 
            rounded-xl flex items-center justify-center 
            shadow-sm">
                            <i data-lucide="laptop" class="w-6 h-6 text-emerald-600"></i>
                        </div>

                        <div>
                            <p class="text-gray-500 text-xs font-bold uppercase tracking-wide">Teknologi</p>
                            <h3 class="text-2xl font-semibold tracking-tight text-gray-900">
                                {{ $totalTeknologi }}
                            </h3>
                        </div>

                    </div>

                </div>

                <a href="{{ route('public.analytics') }}" class="text-blue-600 font-semibold text-sm hover:underline">

                    Lihat Selengkapnya →
                </a>

            </div>

    </section>

    <!-- STATISTIK -->
    <!-- <section id="stats" class="bg-white py-24 border-t border-gray-100">

        <div class="max-w-7xl mx-auto px-6">

            <div class="text-center mb-16">

                <h2 class="text-3xl font-bold text-gray-900">
                    Statistik Program Magang
                </h2>

                <p class="text-gray-500 mt-2 text-sm">
                    Data real dari sistem pengelolaan project magang
                </p>

            </div>


            <div class="grid md:grid-cols-4 gap-8 text-center">

                <div class="bg-gray-50 p-8 rounded-2xl hover:shadow-xl hover:-translate-y-1 transition duration-300">

                    <div class="text-blue-600 text-4xl mb-3">🎓</div>

                    <h3 class="text-4xl font-bold text-gray-900 counter" data-target="{{ $totalIntern }}">
                        0
                    </h3>

                    <p class="text-sm text-gray-500 mt-2">
                        Intern Aktif
                    </p>

                    <p class="text-xs text-gray-400 mt-1">
                        Mahasiswa yang sedang mengikuti program magang
                    </p>

                </div>


                <div class="bg-gray-50 p-8 rounded-2xl hover:shadow-xl hover:-translate-y-1 transition duration-300">

                    <div class="text-blue-600 text-4xl mb-3">💻</div>

                    <h3 class="text-4xl font-bold text-gray-900 counter" data-target="{{ $totalProject }}">
                        0
                    </h3>

                    <p class="text-sm text-gray-500 mt-2">
                        Project Dipublikasikan
                    </p>

                    <p class="text-xs text-gray-400 mt-1">
                        Project yang telah divalidasi oleh mentor
                    </p>

                </div>


                <div class="bg-gray-50 p-8 rounded-2xl hover:shadow-xl hover:-translate-y-1 transition duration-300">

                    <div class="text-blue-600 text-4xl mb-3">🏫</div>

                    <h3 class="text-4xl font-bold text-gray-900 counter" data-target="{{ $totalKampus }}">
                        0
                    </h3>

                    <p class="text-sm text-gray-500 mt-2">
                        Universitas Terlibat
                    </p>

                    <p class="text-xs text-gray-400 mt-1">
                        Perguruan tinggi yang bekerja sama
                    </p>

                </div>


                <div class="bg-gray-50 p-8 rounded-2xl hover:shadow-xl hover:-translate-y-1 transition duration-300">

                    <div class="text-blue-600 text-4xl mb-3">⚙️</div>

                    <h3 class="text-4xl font-bold text-gray-900 counter" data-target="{{ $totalTeknologi }}">
                        0
                    </h3>

                    <p class="text-sm text-gray-500 mt-2">
                        Teknologi Digunakan
                    </p>

                    <p class="text-xs text-gray-400 mt-1">
                        Framework dan tools yang digunakan
                    </p>

                </div>

            </div>

        </div>

    </section> -->

    <!-- STATISTIK -->
    <!-- <section class="bg-white py-20 border-t border-gray-100">

        <div class="max-w-7xl mx-auto px-6">

            <h2 class="text-3xl font-bold text-center mb-14">
                Statistik Program Magang
            </h2>

            <div class="grid md:grid-cols-4 gap-8 text-center">

                <div class="bg-gray-50 p-8 rounded-2xl hover:shadow-xl hover:-translate-y-1 transition duration-300">

                    <div class="text-blue-600 text-4xl mb-3">🎓</div>

                    <h3 class="text-4xl font-bold text-gray-900 counter" data-target="{{ $totalIntern }}">
                        0
                    </h3>

                    <p class="text-sm text-gray-500 mt-2">
                        Intern Aktif
                    </p>

                </div>


                <div class="bg-gray-50 p-8 rounded-2xl hover:shadow-lg transition">

                    <div class="text-blue-600 text-4xl mb-3">💻</div>

                    <h3 class="text-4xl font-bold text-gray-900 counter" data-target="{{ $totalProject }}">
                        0
                    </h3>

                    <p class="text-sm text-gray-500 mt-2">
                        Project Dipublikasikan
                    </p>

                </div>


                <div class="bg-gray-50 p-8 rounded-2xl hover:shadow-lg transition">

                    <div class="text-blue-600 text-4xl mb-3">🏫</div>

                    <h3 class="text-4xl font-bold text-gray-900 counter" data-target="{{ $totalKampus }}">
                        0
                    </h3>

                    <p class="text-sm text-gray-500 mt-2">
                        Universitas Terlibat
                    </p>

                </div>


                <div class="bg-gray-50 p-8 rounded-2xl hover:shadow-lg transition">

                    <div class="text-blue-600 text-4xl mb-3">⚙️</div>

                    <h3 class="text-4xl font-bold text-gray-900 counter" data-target="{{ $totalTeknologi }}">
                        0
                    </h3>

                    <p class="text-sm text-gray-500 mt-2">
                        Teknologi Digunakan
                    </p>

                </div>

            </div>

        </div>

    </section> -->

    <!-- STATISTIK -->
    <!-- <section class="bg-white py-16">

        <div class="max-w-7xl mx-auto px-6">

            <div class="grid md:grid-cols-4 gap-6 text-center">

                <div class="bg-gray-50 p-8 rounded-xl">
                    <h3 class="text-3xl font-bold text-blue-600">
                    {{ $totalIntern }}
                    </h3>
                    <p class="text-sm text-gray-500">Mahasiswa Magang</p>
                </div>

                <div class="bg-gray-50 p-8 rounded-xl">
                    <h3 class="text-3xl font-bold text-blue-600">
                    {{ $totalProject }}
                    </h3>
                    <p class="text-sm text-gray-500">Project</p>
                </div>

                <div class="bg-gray-50 p-8 rounded-xl">
                    <h3 class="text-3xl font-bold text-blue-600">
                    {{ $totalKampus }}
                    </h3>
                    <p class="text-sm text-gray-500">Universitas</p>
                </div>

                <div class="bg-gray-50 p-8 rounded-xl">
                    <h3 class="text-3xl font-bold text-blue-600">
                    {{ $totalTeknologi }}
                    </h3>
                    <p class="text-sm text-gray-500">Kategori Teknologi</p>
                </div>

            </div>

        </div>

    </section> -->

    <!-- PROJECT TERBARU -->
    <section class="py-20">

        <div class="max-w-7xl mx-auto px-6">

            <h2 class="text-3xl font-bold mb-10">
                Project Terbaru
            </h2>

            <div class="grid md:grid-cols-3 gap-8" data-aos="fade-up">

                @forelse($projects as $project)

                <div
                    class="bg-white rounded-2xl border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition duration-300">

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
                            {{ $tech->tk_nama }}
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

            <a href="{{ route('public.project') }}" class="text-blue-600 font-semibold text-sm hover:underline">

                Lihat Selengkapnya →
            </a>

        </div>

    </section>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-white text-center py-8 mt-auto">

        <p class="text-sm text-gray-500">
            © {{ date('Y') }} Siporma | Dinas Kominfo dan Statistik Provinsi Sumatra Barat
        </p>

    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        AOS.init({
            duration: 1000,
            once: true
        });

    </script>

    <script>
        let started = false;

        window.addEventListener("scroll", () => {

            const stats = document.querySelector("#stats");

            const statsTop = stats.offsetTop - window.innerHeight + 100;

            if (!started && window.scrollY > statsTop) {

                started = true;

                const counters = document.querySelectorAll(".counter");

                counters.forEach(counter => {

                    const updateCount = () => {

                        const target = +counter.getAttribute("data-target");

                        const count = +counter.innerText;

                        const speed = 120;

                        const inc = target / speed;

                        if (count < target) {

                            counter.innerText = Math.ceil(count + inc);

                            setTimeout(updateCount, 40);

                        } else {

                            counter.innerText = target;

                        }

                    };

                    updateCount();

                });

            }

        });

    </script>
</body>

</html>
