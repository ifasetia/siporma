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


<body class="min-h-screen flex flex-col antialiased bg-transparent text-gray-800 font-sans">


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



    <div class="flex-1">
        <!-- HERO -->
        <section class="relative h-[350px] flex items-end pb-10">

            <!-- BACKGROUND -->
            <div class="absolute inset-0">
                <img src="{{ asset('images/bg/diskominfotik sumbar.jpg') }}"
                    class="w-full h-full object-cover object-[60%_60%]">
            </div>

            <!-- OVERLAY -->
            <div class="absolute inset-0 bg-black/60"></div>

            <!-- CONTENT -->
            <div class="relative max-w-7xl mx-auto px-6 text-white -translate-y-14">

                <p class="text-base uppercase text-blue-300 tracking-widest font-semibold">
                    Analytics
                </p>

                <h1 class="text-4xl md:text-5xl font-bold leading-tight">
                    Statistik Program Magang
                </h1>

                <p class="text-gray-200 mt-3 max-w-xl">
                    Data statistik mahasiswa magang dan project yang telah dipublikasikan oleh Dinas Kominfo dan
                    Statistik.
                </p>

            </div>

        </section>



        <div class="bg-pattern -mt-20 pt-16 pb-24 min-h-screen">
            <!-- <div class="bg-pattern min-h-screen"> -->
            <!-- STATISTIC -->
            <section class="py-10">

                <div class="max-w-6xl mx-auto px-6 md:px-10">
                    


                    <!-- ✅ JUDUL -->
                    <div class="text-center mb-14 py-6 rounded-2xl 
                            backdrop-blur-md 
                            bg-transparent/5 
                            border border-white/10 
                            shadow-[0_10px_30px_rgba(0,0,0,0.06)]">
                        <div class="text-center mb-10">
                            <h2 class="text-3xl font-bold text-gray-900 mb-3">
                                Ringkasan Data
                            </h2>
                            <span class="block w-20 h-1.5 bg-blue-600 mx-auto rounded-full"></span>
                            <p class="text-gray-600 text-sm mt-3 max-w-xl mx-auto">
                                Statistik umum program magang berdasarkan data terbaru.
                            </p>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 justify-items-center">

                            <!-- INTERN -->
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

                            <!-- PROJECT -->
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

                                <p class="text-xs text-gray-400 mt-1">
                                    Teknologi digunakan
                                </p>

                            </div>

                        </div>
                        
                    </div>

                </div>

            </section>


            <!-- STATUS PROJECT -->
            <section class="py-1">
                <div class="max-w-6xl mx-auto px-6 md:px-10">
                


                    <!-- 🔥 STATUS (GLASS) -->
                    <div class="text-center mb-14 py-6 rounded-2xl 
                            backdrop-blur-xl 
                            bg-white/5 
                            border border-white/10
                            shadow-lg">

                        <div class="text-center mb-10">

                            <h2 class="text-3xl font-bold text-gray-900 mb-3">
                                Status Project
                            </h2>

                            <span class="block w-20 h-1.5 bg-blue-600 mx-auto rounded-full"></span>

                            <p class="text-gray-600 text-sm mt-3 max-w-xl mx-auto">
                                Ringkasan status validasi project mahasiswa magang berdasarkan progres terbaru.
                            </p>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-6 justify-items-center">

                            <!-- MENUNGGU -->
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
                                <i data-lucide="clock" class="w-6 h-6 text-yellow-500"></i>
                                <div>
                                    <p class="text-gray-500 text-xs font-bold uppercase tracking-wide">Menunggu Validasi</p>
                                    <h3 class="text-2xl font-semibold tracking-tight text-yellow-500">{{ $menunggu }}
                                    </h3>
                                    <p class="text-xs text-gray-400">Project menunggu mentor</p>
                                </div>
                            </div>

                            <!-- REVISI -->
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
                                <i data-lucide="refresh-cw" class="w-6 h-6 text-red-500"></i>
                                <div>
                                    <p class="text-gray-500 text-xs font-bold uppercase tracking-wide">Revisi</p>
                                    <h3 class="text-2xl font-semibold tracking-tight text-red-500">{{ $revisi }}</h3>
                                    <p class="text-xs text-gray-400">Perlu perbaikan</p>
                                </div>
                            </div>

                            <!-- DIVALIDASI -->
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
                                <i data-lucide="check-circle" class="w-6 h-6 text-green-500"></i>
                                <div>
                                    <p class="text-gray-500 text-xs font-bold uppercase tracking-wide">Divalidasi</p>
                                    <h3 class="text-2xl font-semibold tracking-tight text-green-500">{{ $divalidasi }}
                                    </h3>
                                    <p class="text-xs text-gray-400">Project selesai</p>
                                </div>
                            </div>

                        </div>

                    </div>
                    
                </div>
            </section>

            <!-- CHART -->
            <section class="py-10">

                <div class="max-w-6xl mx-auto px-6 md:px-10">
    

                    <!-- TITLE -->
                    <div class="text-center mb-10 py-6 rounded-2xl
                backdrop-blur-xl
                bg-white/20
                border border-white/30
                shadow-xl">

                        <div class="text-center mb-10">
                            <h2 class="text-3xl font-bold text-gray-900 mb-3">
                                Visualisasi Data
                            </h2>

                            <div class="w-20 h-1.5 bg-blue-600 mx-auto rounded-full"></div>

                            <p class="text-gray-600 text-sm mt-3 max-w-xl mx-auto">
                                Grafik distribusi data mahasiswa magang dan teknologi yang digunakan.
                            </p>
                        </div>

                        <!-- GRID -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 justify-items-center">

                            <!-- 1 -->
                            <div class="bg-white/80 backdrop-blur-md 
                p-6 rounded-2xl 
                border border-gray-200/60 
                shadow-[0_10px_30px_rgba(0,0,0,0.06)]
                hover:shadow-2xl 
                hover:-translate-y-2 
                hover:scale-[1.02]
                transition-all duration-500 ease-out
                max-w-[480px] w-full mx-auto">
                                <h3 class="font-semibold text-gray-800 mb-4">
                                    Intern per Kampus
                                </h3>
                                <div class="h-64">
                                    <canvas id="kampusChart"></canvas>
                                </div>
                            </div>

                            <!-- 2 -->
                            <div class="bg-white/80 backdrop-blur-md 
                p-6 rounded-2xl 
                border border-gray-200/60 
                shadow-[0_10px_30px_rgba(0,0,0,0.06)]
                hover:shadow-2xl 
                hover:-translate-y-2 
                hover:scale-[1.02]
                transition-all duration-500 ease-out
                max-w-[480px] w-full mx-auto">
                                <h3 class="font-semibold text-gray-800 mb-4">
                                    Intern per Jurusan
                                </h3>
                                <div class="h-64">
                                    <canvas id="jurusanChart"></canvas>
                                </div>
                            </div>

                            <!-- 3 -->
                            <div class="bg-white/80 backdrop-blur-md 
                p-6 rounded-2xl 
                border border-gray-200/60 
                shadow-[0_10px_30px_rgba(0,0,0,0.06)]
                hover:shadow-2xl 
                hover:-translate-y-2 
                hover:scale-[1.02]
                transition-all duration-500 ease-out
                max-w-[480px] w-full mx-auto">
                                <h3 class="font-semibold text-gray-800 mb-4">
                                    Teknologi Project
                                </h3>
                                <div class="h-64 flex items-center justify-center">
                                    <canvas id="techChart"></canvas>
                                </div>
                            </div>

                            <!-- 4 -->
                            <div class="bg-white/80 backdrop-blur-md 
                p-6 rounded-2xl 
                border border-gray-200/60 
                shadow-[0_10px_30px_rgba(0,0,0,0.06)]
                hover:shadow-2xl 
                hover:-translate-y-2 
                hover:scale-[1.02]
                transition-all duration-500 ease-out
                max-w-[480px] w-full mx-auto">
                                <h3 class="font-semibold text-gray-800 mb-4">
                                    Kategori Teknologi
                                </h3>
                                <div class="h-64 flex items-center justify-center">
                                    <canvas id="kategoriTechChart"></canvas>
                                </div>
                            </div>

                        </div>

                    </div>
                    
                </div>
            </section>

        </div>

    </div>

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
                        position: 'right',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle',
                            padding: 20,
                            color: '#374151',
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#111827',
                        titleColor: '#fff',
                        bodyColor: '#d1d5db',
                        padding: 10,
                        cornerRadius: 8
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
                        position: 'right',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle',
                            padding: 20,
                            color: '#374151',
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#111827',
                        titleColor: '#fff',
                        bodyColor: '#d1d5db',
                        padding: 10,
                        cornerRadius: 8
                    }
                }
            }
        });

        const kampusLabels = @json($internPerKampus->pluck('km_nama_kampus'));
        const kampusData = @json($internPerKampus->pluck('total'));

        new Chart(document.getElementById('kampusChart'), {
            type: 'bar',
            data: {
                labels: kampusLabels,
                datasets: [{
                    label: 'Intern',
                    data: kampusData,
                    backgroundColor: '#3b82f6'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#111827',
                        titleColor: '#fff',
                        bodyColor: '#d1d5db',
                        padding: 10,
                        cornerRadius: 8
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#6b7280'
                        }
                    },
                    y: {
                        grid: {
                            color: '#e5e7eb'
                        },
                        ticks: {
                            color: '#6b7280'
                        }
                    }
                }
            }
        });


        const jurusanLabels = @json($internPerJurusan->pluck('js_nama'));
        const jurusanData = @json($internPerJurusan->pluck('total'));

        new Chart(document.getElementById('jurusanChart'), {
            type: 'bar',
            data: {
                labels: jurusanLabels,
                datasets: [{
                    label: 'Intern',
                    data: jurusanData,
                    backgroundColor: '#6366f1'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#111827',
                        titleColor: '#fff',
                        bodyColor: '#d1d5db',
                        padding: 10,
                        cornerRadius: 8
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#6b7280'
                        }
                    },
                    y: {
                        grid: {
                            color: '#e5e7eb'
                        },
                        ticks: {
                            color: '#6b7280'
                        }
                    }
                }
            }
        });

    </script>


</body>

</html>
