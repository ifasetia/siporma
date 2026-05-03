<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $project->title }} | Siporma</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800">

    <!-- NAVBAR -->
    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/icon/prov_sumbar.png') }}" class="h-10 w-auto">
                <span class="text-xl font-bold">Siporma<span class="text-blue-600">.</span></span>
            </div>

            <a href="{{ route('public.project') }}" class="text-blue-600 font-medium">
                ← Kembali ke Project
            </a>
        </div>
    </nav>

    <!-- CONTENT -->
    <section class="py-16">
        <div class="max-w-5xl mx-auto px-6">

            <!-- CARD -->
            <div class="bg-white rounded-3xl p-8 shadow-sm border">

                <!-- HEADER -->
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-900">
                        Detail Project
                    </h1>
                    <p class="text-gray-500 text-sm">
                        Informasi lengkap project mahasiswa
                    </p>
                </div>

                <!-- GRID -->
                <div class="grid md:grid-cols-2 gap-10">

                    <!-- LEFT -->
                    <div class="space-y-6">

                        <div>
                            <p class="text-sm text-gray-500">Judul Project</p>
                            <p class="font-semibold text-gray-900">
                                {{ $project->title }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Deskripsi</p>
                            <p class="text-gray-700 leading-relaxed">
                                {{ $project->description ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Mahasiswa</p>
                            <p class="font-medium">
                                {{ $project->user->profile->pr_nama ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Universitas</p>
                            <p class="font-medium">
                                {{ $project->user->profile->kampus->km_nama_kampus ?? '-' }}
                            </p>
                        </div>

                        <!-- FOTO -->
                        <div>
                            <p class="text-sm text-gray-500 mb-2">Foto Dokumentasi</p>

                            <div class="grid grid-cols-3 gap-2">
                                @foreach($project->photos ?? [] as $photo)
                                    <img src="{{ asset('storage/'.$photo->photo) }}"
                                         class="rounded-lg object-cover h-24 w-full">
                                @endforeach
                            </div>
                        </div>

                    </div>

                    <!-- RIGHT -->
                    <div class="space-y-6">

                        <!-- STATUS -->
                        <div>
                            <p class="text-sm text-gray-500">Status</p>

                            <span class="inline-block mt-1 px-3 py-1 text-xs rounded-full bg-green-100 text-green-600">
                                {{ $project->masterStatus->sp_nama_status ?? '-' }}
                            </span>
                        </div>

                        <!-- TEKNOLOGI -->
                        <div>
                            <p class="text-sm text-gray-500 mb-2">Teknologi</p>

                            <div class="flex flex-wrap gap-2">
                                @foreach($project->teknologis as $tech)
                                    <span class="bg-blue-100 text-blue-600 px-3 py-1 text-xs rounded-full">
                                        {{ $tech->tk_nama }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <!-- FILE -->
                        <div>
                            <p class="text-sm text-gray-500 mb-2">File</p>

                            @forelse($project->files ?? [] as $file)
                                <div class="flex justify-between items-center p-3 border rounded-xl bg-gray-50">
                                    <span class="text-sm text-gray-700 truncate">
                                        {{ basename($file->file_path) }}
                                    </span>

                                    <a href="{{ asset('storage/'.$file->file_path) }}"
                                       target="_blank"
                                       class="text-blue-600 text-sm hover:underline">
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

                            <ul class="list-disc list-inside text-sm text-gray-700 mt-1">
                                @forelse($project->collaborators ?? [] as $c)
                                    <li>{{ $c->profile->pr_nama ?? '-' }}</li>
                                @empty
                                    <li class="text-gray-400">Tidak ada kolaborator</li>
                                @endforelse
                            </ul>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </section>

</body>
</html>