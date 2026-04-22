@extends('layouts.app')

@section('title', 'Analytics')

@section('content')

@php
    $menunggu = $statusProject->where('sp_nama_status', 'Menunggu Validasi')->first()->total ?? 0;
    $revisi = $statusProject->where('sp_nama_status', 'Revisi')->first()->total ?? 0;
    $divalidasi = $statusProject->where('sp_nama_status', 'Divalidasi (Public)')->first()->total ?? 0;
@endphp

<!-- HEADER -->
<div class="mb-10">
    <h1 class="text-3xl font-bold text-gray-900">
        Statistik Program Magang
    </h1>
    <p class="text-gray-500 mt-2">
        Data statistik mahasiswa dan project dalam sistem
    </p>
</div>

<!-- STATISTIK -->
<div class="grid md:grid-cols-4 gap-6 mb-10">

    <div class="bg-white p-6 rounded-2xl shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center">👤</div>
        <div>
            <p class="text-sm text-gray-500">Total Intern</p>
            <h3 class="text-2xl font-bold">{{ $totalIntern }}</h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center">🧑‍💼</div>
        <div>
            <p class="text-sm text-gray-500">Total Admin</p>
            <h3 class="text-2xl font-bold">{{ $totalAdmin }}</h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center">👥</div>
        <div>
            <p class="text-sm text-gray-500">Total Users</p>
            <h3 class="text-2xl font-bold">{{ $totalUsers }}</h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center">🏫</div>
        <div>
            <p class="text-sm text-gray-500">Total Kampus</p>
            <h3 class="text-2xl font-bold">{{ $totalKampus }}</h3>
        </div>
    </div>

</div>

<!-- STATUS -->
<div class="mb-12">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Status Project</h2>

    <div class="grid md:grid-cols-3 gap-6">

        <div class="bg-white p-6 rounded-2xl shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-yellow-100 text-yellow-500 rounded-xl flex items-center justify-center">⏳</div>
            <div>
                <p class="text-sm text-gray-500">Menunggu Validasi</p>
                <h3 class="text-2xl font-bold text-yellow-500">{{ $menunggu }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-red-100 text-red-500 rounded-xl flex items-center justify-center">🔁</div>
            <div>
                <p class="text-sm text-gray-500">Revisi</p>
                <h3 class="text-2xl font-bold text-red-500">{{ $revisi }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-green-100 text-green-500 rounded-xl flex items-center justify-center">✅</div>
            <div>
                <p class="text-sm text-gray-500">Divalidasi</p>
                <h3 class="text-2xl font-bold text-green-500">{{ $divalidasi }}</h3>
            </div>
        </div>

    </div>
</div>

<!-- CHART -->
<div>
    <h2 class="text-lg font-semibold text-gray-800 mb-6">Visualisasi Data</h2>

    <div class="grid md:grid-cols-2 gap-6">

        <div class="bg-white p-6 rounded-2xl shadow-sm">
            <h3 class="font-medium mb-4">Intern per Kampus</h3>
            <div class="h-64">
                <canvas id="kampusChart"></canvas>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm">
            <h3 class="font-medium mb-4">Intern per Jurusan</h3>
            <div class="h-64">
                <canvas id="jurusanChart"></canvas>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm">
            <h3 class="font-medium mb-4">Teknologi Project</h3>
            <div class="h-64 flex items-center justify-center">
                <canvas id="techChart"></canvas>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm">
            <h3 class="font-medium mb-4">Kategori Teknologi</h3>
            <div class="h-64 flex items-center justify-center">
                <canvas id="kategoriTechChart"></canvas>
            </div>
        </div>

    </div>
</div>

<!-- SCRIPT -->
<script>
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

const techLabels = @json($techProject->pluck('tk_nama'));
const techData = @json($techProject->pluck('total'));

new Chart(document.getElementById('techChart'), {
    type: 'pie',
    data: {
        labels: techLabels,
        datasets: [{ data: techData }]
    },
    options: {
        plugins: {
            legend: { position: 'right' }
        }
    }
});

const catLabels = @json($techCategory->pluck('tk_kategori'));
const catData = @json($techCategory->pluck('total'));

new Chart(document.getElementById('kategoriTechChart'), {
    type: 'doughnut',
    data: {
        labels: catLabels,
        datasets: [{ data: catData }]
    },
    options: {
        plugins: {
            legend: { position: 'right' }
        }
    }
});
</script>

@endsection