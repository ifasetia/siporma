<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $project->title }} | Siporma</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

</head>

<body class="bg-gray-50">

    <div class="max-w-5xl mx-auto px-6 py-20">

        <h1 class="text-4xl font-bold mb-6">
            {{ $project->title }}
        </h1>

        <p class="text-gray-600 mb-10">
            {{ $project->description }}
        </p>

        <div class="mb-6">

            <p class="text-sm text-gray-500">
                Mahasiswa
            </p>

            <p class="font-medium">
                {{ $project->user->profile->pr_nama ?? '-' }}
            </p>

        </div>

        <div class="mb-10">

            <p class="text-sm text-gray-500">
                Universitas
            </p>

            <p class="font-medium">
                {{ $project->user->profile->kampus->km_nama_kampus ?? '-' }}
            </p>

        </div>

        <div class="mb-10">

            <p class="text-sm text-gray-500 mb-3">
                Teknologi
            </p>

            <div class="flex gap-2 flex-wrap">

                @foreach($project->teknologis as $tech)

                <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded text-sm">
                    {{ $tech->nama }}
                </span>

                @endforeach

            </div>

        </div>

        <a href="{{ route('public.project') }}" class="text-blue-600 hover:underline">

            ← Kembali ke katalog

        </a>

    </div>

</body>

</html>
