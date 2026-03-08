@extends('layouts.app')

@section('title', 'Analytics')

@section('content')

    <div class="rounded-2xl border border-gray-200 bg-white p-5 lg:p-6">
        <h3 class="text-xl font-semibold text-gray-800">
            Analytics Dashboard
        </h3>

        <p class="text-gray-500 mt-2">
            Statistik sistem akan tampil disini.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        <div class="bg-white p-6 rounded-xl border shadow-sm">
            <p class="text-gray-500 text-sm">Total Intern</p>
            <h2 class="text-3xl font-bold text-indigo-600">{{ $totalIntern }}</h2>
        </div>

        <div class="bg-white p-6 rounded-xl border shadow-sm">
            <p class="text-gray-500 text-sm">Total Admin</p>
            <h2 class="text-3xl font-bold text-green-600">{{ $totalAdmin }}</h2>
        </div>

        <div class="bg-white p-6 rounded-xl border shadow-sm">
            <p class="text-gray-500 text-sm">Total Users</p>
            <h2 class="text-3xl font-bold text-blue-600">{{ $totalUsers }}</h2>
        </div>

        <div class="bg-white p-6 rounded-xl border shadow-sm">
            <p class="text-gray-500 text-sm">Total Kampus</p>
            <h2 class="text-3xl font-bold text-purple-600">{{ $totalKampus }}</h2>
        </div>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

        <div class="bg-white p-6 rounded-xl border">
            <h3 class="font-semibold mb-4">Intern per Kampus</h3>
            <canvas id="kampusChart"></canvas>
        </div>

        <div class="bg-white p-6 rounded-xl border">
            <h3 class="font-semibold mb-4">Intern per Jurusan</h3>
            <canvas id="jurusanChart"></canvas>
        </div>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

        <div class="bg-white p-6 rounded-xl border">
            <h3 class="font-semibold mb-4">Teknologi Project</h3>
            <canvas id="techChart"></canvas>
        </div>

        <div class="bg-white p-6 rounded-xl border">
            <h3 class="font-semibold mb-4">Kategori Teknologi</h3>
            <canvas id="kategoriTechChart"></canvas>
        </div>

    </div>



    <script>
        const jurusanLabels = @json($internPerJurusan->pluck('js_nama'));
        const jurusanData = @json($internPerJurusan->pluck('total'));

        const jurusanCtx = document.getElementById('jurusanChart');

        new Chart(jurusanCtx, {
            type: 'bar',
            data: {
                labels: jurusanLabels,
                datasets: [{
                    label: 'Jumlah Intern',
                    data: jurusanData,
                    borderWidth: 1
                }]
            }
        });
    </script>

    <script>
        const kampusLabels = @json($internPerKampus->pluck('km_nama_kampus'));
        const kampusData = @json($internPerKampus->pluck('total'));

        new Chart(document.getElementById('kampusChart'), {
            type: 'bar',
            data: {
                labels: kampusLabels,
                datasets: [{
                    label: 'Intern',
                    data: kampusData,
                    backgroundColor: '#6366f1'
                }]
            }
        });
    </script>

    <script>
        const jurusanLabels = @json($internPerJurusan->pluck('js_nama'));
        const jurusanData = @json($internPerJurusan->pluck('total'));

        new Chart(document.getElementById('jurusanChart'), {
            type: 'bar',
            data: {
                labels: jurusanLabels,
                datasets: [{
                    label: 'Intern',
                    data: jurusanData,
                    backgroundColor: '#10b981'
                }]
            }
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
    </script>

    <script>
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
    </script>

    </>


@endsection
