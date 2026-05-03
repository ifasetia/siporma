<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Analytics | Siporma</title>

    <link rel="icon" type="image/png" href="{{ asset('images/icon/LOGO.png') }}">

    @vite(['resources/css/app.css','resources/js/app.js'])

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>


<body class="antialiased bg-gray-50 text-gray-800 font-sans">


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

    <section class="relative h-[350px] flex items-end pb-10">

        <!-- BACKGROUND -->
        <div class="absolute inset-0">
            <img src="{{ asset('images/bg/analitik1.jpg') }}" 
            class="w-full h-full  object-cover object-[60%_60%]">
        </div>

        <!-- OVERLAY -->
        <div class="absolute inset-0 bg-black/60"></div>

        <!-- CONTENT -->
        <div class="relative max-w-7xl mx-auto px-6 text-white">

        <div class="max-w-7xl mx-auto px-6 text-center">

            <h1 class="text-5xl font-extrabold text-white-900 mb-6">
                Statistik Program
                <span class="text-blue-300">Magang</span>
            </h1>

            <p class="text-lg text-white-600 max-w-2xl mx-auto">
                Data statistik mahasiswa magang dan project yang telah dipublikasikan oleh Dinas Kominfo dan Statistik.
            </p>

        </div>
    </section>



    {{-- <!-- HERO -->
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

    </section> --}}



    <!-- STATISTIC -->
    <section class="py-20 bg-white border-y border-gray-100">

        <div class="max-w-7xl mx-auto px-6">

            <div class="grid md:grid-cols-4 gap-6">

            <!-- INTERN -->
            <div class="bg-gradient-to-br from-white to-gray-50 p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-lg transition duration-300 flex items-center justify-center gap-4 text-center">
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center text-xl">
                    👤
                </div>
                <div>
                    <p class="text-gray-500 text-sm ">Total Intern</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalIntern }}</h3>
                    <p class="text-xs text-gray-400">Mahasiswa magang aktif</p>
                </div>
            </div>

            <!-- PROJECT -->
            <div class="bg-gradient-to-br from-white to-gray-50 p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-lg transition duration-300 flex items-center justify-center gap-4 text-center">
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center text-xl">
                    📁
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Project Publik</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalProject }}</h3>
                    <p class="text-xs text-gray-400">Project dipublikasikan</p>
                </div>
            </div>

            <!-- KAMPUS -->
            <div class="bg-gradient-to-br from-white to-gray-50 p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-lg transition duration-300 flex items-center justify-center gap-4 text-center">
                <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center text-xl">
                    🏫
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Universitas</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalKampus }}</h3>
                    <p class="text-xs text-gray-400">Universitas terlibat</p>
                </div>
            </div>

            <!-- TEKNOLOGI -->
            <div class="bg-gradient-to-br from-white to-gray-50 p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-lg transition duration-300 flex items-center justify-center gap-4 text-center">
                <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center text-xl">
                    💻
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Teknologi</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalTeknologi }}</h3>
                    <p class="text-xs text-gray-400">Teknologi digunakan</p>
                </div>
            </div>

        </div>

            <!-- <div class="grid md:grid-cols-4 gap-8 text-center">

                <div class="p-8 rounded-3xl bg-gray-50 border hover:shadow-xl transition" data-aos="fade-up">

                    <h3 class="text-4xl font-bold text-blue-600 mb-2">
                        {{ $totalIntern }}
                    </h3>

                    <p class="text-gray-500 text-sm">
                        Total Intern
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

            </div> -->

        </div>

    </section>


    <!-- STATUS PROJECT -->
    <section class="py-12 bg-gray-50">

        <div class="max-w-7xl mx-auto px-6">

            <h2 class="text-center text-xl font-semibold text-gray-800 mb-8">
                Status Project
            </h2>

            <div class="grid md:grid-cols-3 gap-6">

                <!-- MENUNGGU -->
                <div class="bg-gradient-to-br from-white to-gray-50 p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-lg transition duration-300 flex items-center justify-center gap-4 text-center">
                    <div class="w-12 h-12 bg-yellow-100 text-yellow-500 rounded-xl flex items-center justify-center text-xl">
                        ⏳
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Menunggu Validasi</p>
                        <h3 class="text-2xl font-bold text-yellow-500">{{ $menunggu }}</h3>
                        <p class="text-xs text-gray-400">Project menunggu mentor</p>
                    </div>
                </div>

                <!-- REVISI -->
                <div class="bg-gradient-to-br from-white to-gray-50 p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-lg transition duration-300 flex items-center justify-center gap-4 text-center">
                    <div class="w-12 h-12 bg-red-100 text-red-500 rounded-xl flex items-center justify-center text-xl">
                        🔁
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Revisi</p>
                        <h3 class="text-2xl font-bold text-red-500">{{ $revisi }}</h3>
                        <p class="text-xs text-gray-400">Perlu perbaikan</p>
                    </div>
                </div>

                <!-- DIVALIDASI -->
                <div class="bg-gradient-to-br from-white to-gray-50 p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-lg transition duration-300 flex items-center justify-center gap-4 text-center">
                    <div class="w-12 h-12 bg-green-100 text-green-500 rounded-xl flex items-center justify-center text-xl">
                        ✅
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Divalidasi</p>
                        <h3 class="text-2xl font-bold text-green-500">{{ $divalidasi }}</h3>
                        <p class="text-xs text-gray-400">Project selesai</p>
                    </div>
                </div>

            </div>

        </div>

    </section>

    <!-- CHART -->
<section class="py-20 bg-gray-50">

    <div class="max-w-7xl mx-auto px-6">

    <div class="pt-8 pb-20 bg-repeat bg-center"
        style="background-image: url('{{ asset('images/bg/heksagonal1.jpeg') }}')">


        <!-- TITLE -->
        <div class="text-center mb-14">
            <h2 class="text-3xl font-bold text-gray-900 mb-3">
                Visualisasi Data
            </h2>
            <div class="w-20 h-1.5 bg-blue-600 mx-auto rounded-full"></div>
        </div>

        <!-- GRID -->
        <div class="grid md:grid-cols-2 gap-8">

            <!-- 1 -->
            <div class="bg-gradient-to-br from-white to-gray-50 p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-lg transition duration-300">
                <h3 class="font-semibold text-gray-800 mb-4">
                    Intern per Kampus
                </h3>
                <div class="h-64">
                    <canvas id="kampusChart"></canvas>
                </div>
            </div>

            <!-- 2 -->
            <div class="bg-gradient-to-br from-white to-gray-50 p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-lg transition duration-300">
                <h3 class="font-semibold text-gray-800 mb-4">
                    Intern per Jurusan
                </h3>
                <div class="h-64">
                    <canvas id="jurusanChart"></canvas>
                </div>
            </div>

            <!-- 3 -->
            <div class="bg-gradient-to-br from-white to-gray-50 p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-lg transition duration-300">
                <h3 class="font-semibold text-gray-800 mb-4">
                    Teknologi Project
                </h3>
                <div class="h-64 flex items-center justify-center">
                    <canvas id="techChart"></canvas>
                </div>
            </div>

            <!-- 4 -->
            <div class="bg-gradient-to-br from-white to-gray-50 p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-lg transition duration-300">
                <h3 class="font-semibold text-gray-800 mb-4">
                    Kategori Teknologi
                </h3>
                <div class="h-64 flex items-center justify-center">
                    <canvas id="kategoriTechChart"></canvas>
                </div>
            </div>

        </div>

    </div>

</section>



    <div class="pb-10"></div>
    <!-- FOOTER -->
    <footer class="bg-gray-900 text-white text-center py-6 mt-20">

        © {{ date('Y') }} Siporma | Diskominfotik Sumbar

    </footer>



    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        AOS.init({
            duration: 1000,
            once: true
        });

    </script>

    <script>
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = '#6b7280'; // abu soft

    const gridStyle = {
        color: 'rgba(0,0,0,0.03)', // 🔥 garis tipis banget
        drawBorder: false
    };

    const ticksStyle = {
        color: '#9ca3af'
    };

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
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right' // 🔥 INI KUNCINYA
                }
            }
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
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right' // 🔥 PINDAH KE SAMPING
                }
            }
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
