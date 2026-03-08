<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Analytics | Siporma</title>

    <link rel="icon" type="image/png" href="{{ asset('images/icon/prov_sumbar.png') }}">

    @vite(['resources/css/app.css','resources/js/app.js'])

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>


<body class="antialiased bg-gray-50 text-gray-800 font-sans">


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

                <a href="{{ route('public.analytics') }}" class="text-blue-600 font-semibold">
                    Analytics
                </a>

            </div>


        </div>

    </nav>



    <!-- HERO -->
    <section class="relative pt-16 pb-24 overflow-hidden">

        <div class="max-w-7xl mx-auto px-6 text-center">

            <h1 class="text-5xl font-extrabold text-gray-900 mb-6">
                Statistik Program
                <span class="text-blue-600">Magang</span>
            </h1>

            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Data statistik mahasiswa magang dan project yang telah dipublikasikan oleh Dinas Kominfo dan Statistik.
            </p>

        </div>

    </section>



    <!-- STATISTIC -->
    <section class="py-20 bg-white border-y border-gray-100">

        <div class="max-w-7xl mx-auto px-6">

            <div class="grid md:grid-cols-4 gap-8 text-center">

                <div class="p-8 rounded-3xl bg-gray-50 border hover:shadow-xl transition" data-aos="fade-up">

                    <h3 class="text-4xl font-bold text-blue-600 mb-2">
                        {{ $totalIntern }}
                    </h3>

                    <p class="text-gray-500 text-sm">
                        Mahasiswa Magang
                    </p>

                </div>


                <div class="p-8 rounded-3xl bg-gray-50 border hover:shadow-xl transition" data-aos="fade-up"
                    data-aos-delay="100">

                    <h3 class="text-4xl font-bold text-blue-600 mb-2">
                        {{ $totalProject }}
                    </h3>

                    <p class="text-gray-500 text-sm">
                        Project Publik
                    </p>

                </div>


                <div class="p-8 rounded-3xl bg-gray-50 border hover:shadow-xl transition" data-aos="fade-up"
                    data-aos-delay="200">

                    <h3 class="text-4xl font-bold text-blue-600 mb-2">
                        {{ $totalKampus }}
                    </h3>

                    <p class="text-gray-500 text-sm">
                        Universitas
                    </p>

                </div>


                <div class="p-8 rounded-3xl bg-gray-50 border hover:shadow-xl transition" data-aos="fade-up"
                    data-aos-delay="300">

                    <h3 class="text-4xl font-bold text-blue-600 mb-2">
                        {{ $totalTeknologi }}
                    </h3>

                    <p class="text-gray-500 text-sm">
                        Teknologi Digunakan
                    </p>

                </div>

            </div>

        </div>

    </section>



    <!-- CHART -->
    <section class="py-24 bg-gray-50">

        <div class="max-w-7xl mx-auto px-6">

            <div class="text-center mb-16">

                <h2 class="text-3xl font-bold text-gray-900 mb-4">
                    Visualisasi Data
                </h2>

                <div class="w-20 h-1.5 bg-blue-600 mx-auto rounded-full"></div>

            </div>


            <div class="grid md:grid-cols-2 gap-10">

                <div class="bg-white p-8 rounded-3xl border shadow-sm" data-aos="fade-up">
                    <h3 class="font-semibold mb-6 text-lg">
                        Intern per Kampus
                    </h3>
                    <canvas id="kampusChart"></canvas>
                </div>


                <div class="bg-white p-8 rounded-3xl border shadow-sm" data-aos="fade-up">
                    <h3 class="font-semibold mb-6 text-lg">
                        Intern per Jurusan
                    </h3>
                    <canvas id="jurusanChart"></canvas>
                </div>


                <div class="bg-white p-8 rounded-3xl border shadow-sm" data-aos="fade-up">
                    <h3 class="font-semibold mb-6 text-lg">
                        Teknologi Project
                    </h3>
                    <canvas id="techChart"></canvas>
                </div>


                <div class="bg-white p-8 rounded-3xl border shadow-sm" data-aos="fade-up">
                    <h3 class="font-semibold mb-6 text-lg">
                        Kategori Teknologi
                    </h3>
                    <canvas id="kategoriTechChart"></canvas>
                </div>

            </div>

        </div>

    </section>



    <!-- FOOTER -->
    <footer class="bg-gray-900 py-12 text-white">

        <div class="max-w-7xl mx-auto px-6 text-center border-t border-gray-800 pt-8">

            <p class="text-sm text-gray-500">
                © {{ date('Y') }} Siporma | Dinas Kominfo dan Statistik
            </p>

        </div>

    </footer>



    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        AOS.init({
            duration: 1000,
            once: true
        });

    </script>



    <script>
        const techLabels = @json($techProject->pluck('tk_nama'));
        const techData = @json($techProject->pluck('total'));

        new Chart(document.getElementById('techChart'), {

            type: 'pie',

            data: {
                labels: techLabels,
                datasets: [{
                    data: techData
                }]
            }

        });


        const catLabels = @json($techCategory->pluck('tk_kategori'));
        const catData = @json($techCategory->pluck('total'));

        new Chart(document.getElementById('kategoriTechChart'), {

            type: 'doughnut',

            data: {
                labels: catLabels,
                datasets: [{
                    data: catData
                }]
            }

        });

        const kampusLabels = @json($internPerKampus->pluck('km_nama_kampus'));
        const kampusData = @json($internPerKampus->pluck('total'));

        new Chart(document.getElementById('kampusChart'),{
        type:'bar',
        data:{
        labels:kampusLabels,
        datasets:[{
        label:'Intern',
        data:kampusData,
        backgroundColor:'#3b82f6'
        }]
        }
        });


        const jurusanLabels = @json($internPerJurusan->pluck('js_nama'));
        const jurusanData = @json($internPerJurusan->pluck('total'));

        new Chart(document.getElementById('jurusanChart'),{
        type:'bar',
        data:{
        labels:jurusanLabels,
        datasets:[{
        label:'Intern',
        data:jurusanData,
        backgroundColor:'#6366f1'
        }]
        }
        });
    </script>


</body>

</html>
