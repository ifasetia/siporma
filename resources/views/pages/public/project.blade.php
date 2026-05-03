<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Katalog Project | Siporma</title>

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    @vite(['resources/css/app.css','resources/js/app.js'])

</head>

    <body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">

    <!-- NAVBAR -->
    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100">

        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">

            <div class="flex items-center gap-3">
                <img src="{{ asset('images/icon/LOGO.png') }}" class="h-10">
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

    <section class="relative h-[350px] flex items-end pb-10">

        <!-- BACKGROUND -->
        <div class="absolute inset-0">
            <img src="{{ asset('images/bg/diskominfotik sumbar.jpg') }}" 
            class="w-full h-full  object-cover object-[60%_60%]">
        </div>

        <!-- OVERLAY -->
        <div class="absolute inset-0 bg-black/60"></div>

        <!-- CONTENT -->
        <div class="relative max-w-7xl mx-auto px-6 text-white -translate-y-14">

           <p class="text-base uppercase text-blue-300 tracking-widest font-semibold">
                Katalog
           </p>

            <h1 class="text-4xl md:text-5xl font-bold leading-tight">
                Project Magang Intern
            </h1>

            <p class="text-gray-200 mt-3 max-w-xl">
                Menampilkan seluruh project mahasiswa magang yang telah divalidasi oleh Dinas Kominfo dan Statistik Provinsi Sumbar.
            </p>

        </div>

    </section>
    

   <!-- 🔥 WRAPPER PATTERN -->
<div class="bg-pattern pt-8 pb-20 bg-repeat bg-center">

    <!-- SEARCH -->
    <div class="max-w-xl mx-auto -mt-10 mb-12 px-6 relative z-10">

        <div class="bg-white border border-gray-200 rounded-2xl shadow-md px-5 py-3 flex items-center gap-3 focus-within:ring-2 focus-within:ring-blue-500">

            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-width="2" d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z"/>
            </svg>

            <input id="search" type="text"
                placeholder="Cari project, mahasiswa, atau kampus..."
                class="w-full bg-transparent text-sm focus:outline-none">

        </div>

    </div>

    <!-- LIST -->
    <section class="pb-10">
        <div id="projectList" class="max-w-5xl mx-auto px-6 space-y-6">
            @include('pages.public.components.project-list')
        </div>
    </section>

</div>


    <!-- FOOTER -->
       <footer class="bg-gray-900 text-white text-center py-8 mt-auto">
        
            <p class="text-sm text-gray-500">
                © {{ date('Y') }} Siporma | Dinas Kominfo dan Statistik Provinsi Sumatra Barat
            </p>

    </footer>

</body>

</html>

<script>
    document.addEventListener("DOMContentLoaded", function () {

        let search = document.getElementById('search')

        function loadProjects(url = null) {

            url = url ||
                `/public/project?search=${search.value}`

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
        // teknologi.addEventListener('change', () => loadProjects())
        // kampus.addEventListener('change', () => loadProjects())
        // sort.addEventListener('change', () => loadProjects())

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


