<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $project->title }} | Siporma</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-pattern text-gray-800">

    <!-- NAVBAR -->
    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/icon/prov_sumbar.png') }}" class="h-10 w-auto">
                <span class="text-xl font-bold">Siporma<span class="text-blue-600">.</span></span>
            </div>

            <div class="flex gap-6 items-center">

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

    <!-- CONTENT -->
    <section class="py-12">
        <div class="max-w-5xl mx-auto px-6">

            <div class="mb-6">
                <a href="{{ route('public.project') }}" class="group inline-flex items-center gap-2 
          px-4 py-2.5 rounded-xl 
          bg-white/70 backdrop-blur-md
          border border-white/40
          text-sm text-gray-600 
          shadow-sm hover:shadow-md
          transition-all duration-300">

                    <svg class="w-4 h-4 group-hover:-translate-x-1 transition" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>

                    <span class="group-hover:text-blue-600 transition">
                        Kembali
                    </span>
                </a>
            </div>
            <!-- CARD -->
            <div class="bg-white/70 backdrop-blur-xl 
rounded-3xl p-10 
shadow-[0_20px_60px_rgba(0,0,0,0.08)]
border border-white/40
hover:-translate-y-[2px]
hover:shadow-[0_30px_80px_rgba(0,0,0,0.1)] transition">

                <!-- HEADER -->
                <div class="mb-10">

                    <p class="text-xs uppercase tracking-[0.2em] text-gray-400 mb-2">
                        Detail Project
                    </p>

                    <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-gray-900 leading-tight">
                        {{ $project->title }}
                    </h1>

                    <div class="w-16 h-[3px] bg-blue-600 rounded-full mt-4"></div>

                    <p class="text-gray-500 text-sm mt-4 max-w-md">
                        Informasi lengkap project magang intern
                    </p>

                </div>

                <!-- GRID -->
                <div class="grid md:grid-cols-2 gap-12">

                    <!-- LEFT -->
                    <div class="space-y-6">

                        <div class="p-4 rounded-xl bg-gray-50/70 border border-gray-100">
                            <p class="text-xs uppercase tracking-wide text-gray-400 mb-1">Deskripsi</p>
                            <p class="text-gray-900">
                                {{ $project->description ?? '-' }}
                            </p>
                        </div>

                        <div class="p-4 rounded-xl bg-gray-50/70 border border-gray-100">
                            <p class="text-xs uppercase tracking-wide text-gray-400 mb-1">Mahasiswa</p>
                            <p class="text-gray-900">
                                {{ $project->user->profile->pr_nama ?? '-' }}
                            </p>
                        </div>

                        <div class="p-4 rounded-xl bg-gray-50/70 border border-gray-100">
                            <p class="text-xs uppercase tracking-wide text-gray-400 mb-1">Universitas</p>
                            <p class="text-gray-900">
                                {{ $project->user->profile->kampus->km_nama_kampus ?? '-' }}
                            </p>
                        </div>

                        <!-- FOTO -->
                        <div>
                            <p class="text-xs uppercase tracking-wide text-gray-400 mb-3">
                                Foto Dokumentasi
                            </p>

                            <div class="grid grid-cols-3 gap-3">
                                @foreach($project->photos ?? [] as $photo)
                                <img src="{{ asset('storage/'.$photo->photo) }}" class="rounded-xl object-cover h-24 w-full 
hover:scale-110 hover:shadow-xl
transition-all duration-500 cursor-pointer" onclick="openPreview(this.src)">
                                @endforeach
                            </div>
                        </div>

                    </div>

                    <!-- RIGHT -->
                    <div class="space-y-6">

                        <!-- STATUS -->
                        <div class="p-4 rounded-xl bg-gray-50/70 border border-gray-100">

                            <p class="text-xs uppercase tracking-wide text-gray-400 mb-2">
                                Status
                            </p>

                            <span class="inline-flex items-center gap-2 
        px-3 py-1.5 rounded-full text-xs font-medium
        bg-green-50 text-green-600 border border-green-100 shadow-sm">

                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>

                                {{ $project->masterStatus->sp_nama_status ?? '-' }}

                            </span>

                        </div>

                        <!-- TEKNOLOGI -->
                        <div>
                            <p class="text-sm text-gray-500 mb-2">Teknologi</p>

                            <div class="flex flex-wrap gap-2">
                                @foreach($project->teknologis as $tech)
                                <span class="px-3 py-1.5 text-xs font-medium 
                                bg-blue-50 text-blue-600 
                                rounded-full border border-blue-100
                                hover:bg-blue-100 hover:-translate-y-[1px] hover:shadow-sm
transition-all duration-300">
                                    {{ $tech->tk_nama }}
                                </span>
                                @endforeach
                            </div>
                        </div>

                        <!-- FILE -->
                        <div>
                            <p class="text-sm text-gray-500 mb-2">File</p>

                            @forelse($project->files ?? [] as $file)
                            <div class="flex justify-between items-center 
p-3 rounded-xl 
bg-white border border-gray-100 
shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">

                                <span class="text-sm text-gray-700 truncate">
                                    {{ basename($file->file_path) }}
                                </span>

                                <a href="{{ asset('storage/'.$file->file_path) }}" target="_blank"
                                    class="text-blue-600 text-sm font-medium hover:underline">
                                    Lihat
                                </a>

                            </div>
                            @empty
                            <span class="text-gray-400 text-sm">Tidak ada file</span>
                            @endforelse
                        </div>

                        <!-- KOLABORATOR -->
                        <div>
                            <p class="text-sm text-gray-500">Kolaborator</p>

                            <div class="flex flex-wrap gap-2 mt-2">
                                @forelse($project->collaborators ?? [] as $c)
                                <span class="px-3 py-1 text-xs bg-gray-100 rounded-full">
                                    {{ $c->profile->pr_nama ?? '-' }}
                                </span>
                                @empty
                                <span class="text-gray-400 text-sm">Tidak ada kolaborator</span>
                                @endforelse
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </section>

    <!-- IMAGE PREVIEW MODAL -->
    <div id="imageModal" class="fixed inset-0 bg-black/60 backdrop-blur-md 
            hidden items-center justify-center z-50
            opacity-0 transition duration-300">


        <img id="previewImage" class="max-h-[85vh] max-w-[90vw] rounded-xl shadow-2xl">

    </div>

    <script>
        const modal = document.getElementById('imageModal');
        const preview = document.getElementById('previewImage');

        function openPreview(src) {
            preview.src = src;

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modal.classList.add('opacity-100');
            }, 10);
        }

        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                modal.classList.add('opacity-0');

                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }, 200);
            }
        });

        // klik di luar gambar = close
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        });

    </script>

</body>

</html>
