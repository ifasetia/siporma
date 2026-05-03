@forelse($projects as $project)

<div class="bg-white border border-gray-100 rounded-2xl p-6 hover:shadow-xl transition duration-300 hover:-translate-y-1">

    <h2 class="text-lg font-semibold text-gray-900 mb-2">
        {{ $project->title }}
    </h2>

    <p class="text-gray-500 text-sm mb-4 line-clamp-2 leading-relaxed">
        {{ $project->description }}
    </p>

    <div class="text-sm text-gray-400 mb-4">
        <span class="font-medium text-gray-700">
            {{ $project->user->profile->pr_nama ?? '-' }}
        </span>
        <span class="mx-1">•</span>
        {{ $project->user->profile->kampus->km_nama_kampus ?? '-' }}
    </div>

    <div class="flex flex-wrap gap-2 mb-4">
        @foreach($project->teknologis as $tech)
        <span class="text-xs bg-blue-50 text-blue-600 px-3 py-1 rounded-full">
            {{ $tech->tk_nama }}
        </span>
        @endforeach
    </div>

    <a href="{{ route('public.project.detail',$project->id) }}"
       class="inline-flex items-center text-blue-600 text-sm font-semibold hover:underline">

        Lihat Detail →
    </a>

</div>

<!-- <div class="bg-white border border-gray-100 rounded-xl p-6 hover:shadow-lg transition">

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

    <div class="flex flex-wrap gap-2 mb-4">

        @foreach($project->teknologis as $tech)

        <span class="text-xs bg-blue-100 text-blue-600 px-3 py-1 rounded-full">
            {{ $tech->tk_nama }}
        </span>

        @endforeach

    </div>

    <a href="{{ route('public.project.detail',$project->id) }}"
        class="text-blue-600 text-sm font-semibold hover:underline">

        Lihat Detail →

    </a>

</div> -->

@empty

<div class="text-center text-gray-500 py-20">

    Belum ada project yang dipublikasikan

</div>

@endforelse

@if ($projects->hasPages())
<div class="mt-10 flex justify-center">
    {{ $projects->links() }}
</div>
@endif
