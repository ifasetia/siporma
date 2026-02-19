<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Siporma-app | Sistem Informasi Project Magang</title>
    <link rel="icon" type="image/png" href="{{ asset('images/icon/prov_sumbar.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body class="antialiased bg-gray-50 text-gray-800 font-sans">

    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/icon/prov_sumbar.png') }}" class="h-10 w-auto" alt="Logo">
                <span class="text-xl font-bold text-gray-900 tracking-tight">Siporma<span class="text-blue-600">.</span></span>
            </div>
            <div class="flex gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition shadow-lg shadow-blue-200">Ke Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2.5 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition shadow-lg shadow-blue-200">Masuk ke Sistem</a>
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <header class="relative pt-16 pb-24 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="px-4 py-2 bg-blue-50 text-blue-600 text-sm font-semibold rounded-full mb-6 inline-block">Proyek Dinas Kominfo dan Statistik</span>
                <h1 class="text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight mb-6">
                    Sistem Pengumpulan <br>
                    <span class="text-blue-600">Project Mahasiswa.</span>
                </h1>
                <p class="text-lg text-gray-600 mb-10 leading-relaxed">
                    Siporma-app hadir untuk memudahkan mahasiswa magang di Dinas Kominfo dan Statistik dalam mengelola, memantau, dan mengumpulkan proyek magang secara terstruktur dan transparan.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('login') }}" class="px-8 py-4 bg-blue-600 text-white rounded-2xl font-bold hover:scale-105 transition shadow-xl shadow-blue-200">Mulai Submit Project</a>
                    <a href="#alur" class="px-8 py-4 bg-white text-gray-700 border border-gray-200 rounded-2xl font-bold hover:bg-gray-50 transition">Lihat Alur Kerja</a>
                </div>
            </div>
            <div class="relative">
                <div class="absolute -top-20 -right-20 w-64 h-64 bg-blue-100 rounded-full blur-3xl opacity-50"></div>
                <img src="{{ asset('images/icon/kampus.png') }}" class="relative z-10 w-4/5 mx-auto rounded-3xl" alt="Illustration">
            </div>
        </div>
    </header>

    <section class="py-24 bg-white border-y border-gray-100">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Informasi Magang</h2>
                <div class="w-20 h-1.5 bg-blue-600 mx-auto rounded-full"></div>
            </div>
            <div class="grid md:grid-cols-3 gap-8" data-aos="fade-up">
                <div class="p-8 rounded-3xl bg-gray-50 border border-gray-100 hover:shadow-xl transition">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Kolaborasi Kampus</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Terhubung dengan berbagai Perguruan Tinggi yang bekerja sama dengan Dinas Kominfo dalam program pengembangan SDM.</p>
                </div>
                <div class="p-8 rounded-3xl bg-gray-50 border border-gray-100 hover:shadow-xl transition">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Beragam Pekerjaan</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Tersedia berbagai kategori proyek mulai dari Web Development, Networking, hingga Statistik yang sudah disiapkan Admin.</p>
                </div>
                <div class="p-8 rounded-3xl bg-gray-50 border border-gray-100 hover:shadow-xl transition">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.040L3 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622l-.382-3.040z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Monitoring Terintegrasi</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Proses pengerjaan dipantau langsung oleh mentor dinas guna memastikan kualitas dan progres tercapai tepat waktu.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-12 bg-blue-600">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div data-aos="fade-up">
                <h3 class="text-4xl font-bold text-white mb-2">30+</h3>
                <p class="text-blue-100 text-sm">Universitas Terintegrasi</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="100">
                <h3 class="text-4xl font-bold text-white mb-2">150+</h3>
                <p class="text-blue-100 text-sm">Mahasiswa Magang</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="200">
                <h3 class="text-4xl font-bold text-white mb-2">500+</h3>
                <p class="text-blue-100 text-sm">Project Selesai</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="300">
                <h3 class="text-4xl font-bold text-white mb-2">100%</h3>
                <p class="text-blue-100 text-sm">Online & Transparan</p>
            </div>
        </div>
    </section>

    <section id="alur" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-16">Alur Pengumpulan Project</h2>
            <div class="grid md:grid-cols-4 gap-8 relative" data-aos="fade-up">
                <div class="flex flex-col items-center">
                    <div class="w-16 h-16 bg-blue-600 text-white rounded-full flex items-center justify-center text-xl font-bold mb-6 z-10 shadow-lg shadow-blue-200">1</div>
                    <h4 class="font-bold mb-2">Login Akun</h4>
                    <p class="text-gray-500 text-sm">Masuk menggunakan akun yang telah dibuatkan oleh Admin.</p>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-16 h-16 bg-blue-600 text-white rounded-full flex items-center justify-center text-xl font-bold mb-6 z-10 shadow-lg shadow-blue-200">2</div>
                    <h4 class="font-bold mb-2">Pilih Pekerjaan</h4>
                    <p class="text-gray-500 text-sm">Tentukan proyek yang ditugaskan sesuai dengan keahlian Anda.</p>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-16 h-16 bg-blue-600 text-white rounded-full flex items-center justify-center text-xl font-bold mb-6 z-10 shadow-lg shadow-blue-200">3</div>
                    <h4 class="font-bold mb-2">Unggah Project</h4>
                    <p class="text-gray-500 text-sm">Kirim link GitHub atau file dokumentasi hasil pekerjaan Anda.</p>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-16 h-16 bg-blue-600 text-white rounded-full flex items-center justify-center text-xl font-bold mb-6 z-10 shadow-lg shadow-blue-200">4</div>
                    <h4 class="font-bold mb-2">Penilaian Mentor</h4>
                    <p class="text-gray-500 text-sm">Tunggu proses verifikasi dan penilaian dari mentor dinas.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-white">
        <div class="max-w-3xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Sering Ditanyakan</h2>
                <div class="w-16 h-1 bg-blue-600 mx-auto rounded-full"></div>
            </div>

            <div class="space-y-6">
                <div class="p-6 rounded-2xl bg-gray-50 border border-gray-100" data-aos="fade-up">
                    <h4 class="font-bold text-gray-900 mb-2">Siapa yang bisa masuk ke sistem?</h4>
                    <p class="text-gray-600 text-sm">Hanya mahasiswa yang datanya sudah didaftarkan secara resmi oleh Super Admin Dinas Kominfo.</p>
                </div>

                <div class="p-6 rounded-2xl bg-gray-50 border border-gray-100" data-aos="fade-up">
                    <h4 class="font-bold text-gray-900 mb-2">Bagaimana cara melaporkan kendala sistem?</h4>
                    <p class="text-gray-600 text-sm">Silakan hubungi Mentor masing-masing atau datang langsung ke ruang Admin IT Kominfo.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-gray-900 py-12 text-white">
        <div class="max-w-7xl mx-auto px-6 text-center border-t border-gray-800 pt-8">
            <p class="text-sm text-gray-500">&copy; 2026 Siporma-app | Dinas Kominfo dan Statistik. Dibuat dengan dedikasi mahasiswa magang.</p>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
    AOS.init({
        duration: 1000, // Durasi animasi (1 detik)
        once: true,     // Animasi hanya jalan sekali saat scroll
    });
    </script>

</body>
</html>
