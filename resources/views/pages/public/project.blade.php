<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Katalog Project | Siporma</title>

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    @vite(['resources/css/app.css','resources/js/app.js'])

</head>

<body class="bg-gray-50 text-gray-800">

    <!-- NAVBAR -->
    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100">

        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">

            <div class="flex items-center gap-3">
                <img src="{{ asset('images/icon/prov_sumbar.png') }}" class="h-10">
                <span class="text-xl font-bold">
                    Siporma<span class="text-blue-600">.</span>
                </span>
            </div>

            <div class="flex gap-4">

                <a href="{{ route('public.dashboard') }}" class="text-gray-600 hover:text-blue-600 font-medium">
                    Dashboard
                </a>

                <a href="{{ route('public.project') }}" class="text-blue-600 font-semibold">
                    Project
                </a>

                <a href="{{ route('public.analytics') }}" class="text-gray-600 hover:text-blue-600 font-medium">
                    Analytics
                </a>

            </div>

        </div>

    </nav>


    <!-- HEADER -->
    <section class="py-16">

        <div class="max-w-5xl mx-auto px-6 text-center">

            <h1 class="text-4xl font-bold mb-4">
                Katalog Project Mahasiswa Magang
            </h1>

            <p class="text-gray-600">
                Menampilkan seluruh project mahasiswa magang yang telah divalidasi oleh
                Dinas Kominfo dan Statistik.
            </p>

        </div>

    </section>

    <!-- FILTER -->
    <div class="max-w-5xl mx-auto px-6 flex flex-wrap gap-4 mb-10">

        <input id="search" type="text" placeholder="Cari project, mahasiswa, atau kampus..."
            class="border border-gray-200 rounded-xl px-4 py-2 w-80">

        <select id="teknologi" class="border border-gray-200 rounded-xl px-4 py-2">

            <option value="">Semua Teknologi</option>

            @foreach($teknologis as $tech)
            <option value="{{ $tech->id }}">
                {{ $tech->tk_nama }}
            </option>
            @endforeach

        </select>

        <select id="kampus" class="border border-gray-200 rounded-xl px-4 py-2">

            <option value="">Semua Kampus</option>

            @foreach($kampus as $k)
            <option value="{{ $k->id }}">
                {{ $k->km_nama_kampus }}
            </option>
            @endforeach

        </select>


        <select id="sort" class="border border-gray-200 rounded-xl px-4 py-2">

            <option value="latest">Terbaru</option>
            <option value="popular">Populer</option>

        </select>

    </div>


    <!-- SEARCH -->
    <!-- <div class="max-w-5xl mx-auto px-6 mb-10">

        <form method="GET" action="{{ route('public.project') }}" class="flex gap-4">

            <input type="text" name="search" placeholder="Cari project..."
                class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
                value="{{ request('search') }}">

            <button class="bg-blue-600 text-white px-6 py-2 rounded-xl hover:bg-blue-700">

                Cari

            </button>

        </form>

    </div> -->


    <!-- LIST PROJECT -->
    <section class="pb-20">

        <div id="projectList" class="max-w-5xl mx-auto px-6 space-y-6">

            @include('pages.public.components.project-list')

        </div>

        <!-- <div id="projectList" class="max-w-5xl mx-auto px-6 space-y-6">

            @forelse($projects as $project)

            <div class="bg-white border border-gray-100 rounded-xl p-6 hover:shadow-lg transition">

                <h2 class="text-xl font-semibold mb-2">
                    {{ $project->title }}
                </h2>

                <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                    {{ $project->description }}
                </p>

                <div class="text-sm text-gray-500 mb-3">

                    <span class="font-medium text-gray-700">
                        {{ $project->user->profile->pr_nama ?? '-' }}
                    </span>

                    —

                    {{ $project->user->profile->kampus->km_nama_kampus ?? '-' }}

                </div>


                TEKNOLOGI
                <div class="flex flex-wrap gap-2 mb-4">

                    @foreach($project->teknologis as $tech)

                    <span class="text-xs bg-blue-100 text-blue-600 px-3 py-1 rounded-full">
                        {{ $tech->nama }}
                    </span>

                    @endforeach

                </div>


                BUTTON
                <a href="{{ route('public.project.detail',$project->id) }}"
                    class="text-blue-600 text-sm font-semibold hover:underline">

                    Lihat Detail →

                </a>

            </div>

            @empty

            <div class="text-center text-gray-500 py-20">

                Belum ada project yang dipublikasikan

            </div>

            @endforelse


            PAGINATION
            <div class="mt-12">

                {{ $projects->links() }}

            </div>

        </div> -->

    </section>


    <!-- FOOTER -->
    <footer class="bg-gray-900 text-white text-center py-8">

        <p class="text-sm text-gray-400">
            © {{ date('Y') }} Siporma - Sistem Informasi Project Magang
        </p>

    </footer>

</body>

</html>

<script>
    document.addEventListener("DOMContentLoaded", function () {

        let search = document.getElementById('search')
        let teknologi = document.getElementById('teknologi')
        let kampus = document.getElementById('kampus')
        let sort = document.getElementById('sort')

        function loadProjects(url = null) {

            url = url ||
                `/public/project?search=${search.value}&teknologi=${teknologi.value}&kampus=${kampus.value}&sort=${sort.value}`

            fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.text())
                .then(html => {
                    document.getElementById('projectList').innerHTML = html
                })
        }

        // 🔍 SEARCH & FILTER
        search.addEventListener('keyup', () => loadProjects())
        teknologi.addEventListener('change', () => loadProjects())
        kampus.addEventListener('change', () => loadProjects())
        sort.addEventListener('change', () => loadProjects())

        // 🔥 PAGINATION AJAX
        document.addEventListener("click", function (e) {
            let link = e.target.closest(".pagination a")

            if (link) {
                e.preventDefault()

                let url = link.getAttribute("href")

                loadProjects(url)
            }
        })

    })

</script>

<!-- <script>
    document.addEventListener("DOMContentLoaded", function () {

        let search = document.getElementById('search')
        let teknologi = document.getElementById('teknologi')
        let kampus = document.getElementById('kampus')
        let sort = document.getElementById('sort')

        function loadProjects() {

            let url =
                `/public/project?search=${search.value}&teknologi=${teknologi.value}&kampus=${kampus.value}&sort=${sort.value}`

            fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.text())
                .then(html => {

                    document.getElementById('projectList').innerHTML = html

                })

        }

        search.addEventListener('keyup', loadProjects)
        teknologi.addEventListener('change', loadProjects)
        kampus.addEventListener('change', loadProjects)
        sort.addEventListener('change', loadProjects)

    })

</script> -->
