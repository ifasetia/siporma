@extends('layouts.app')

@section('title','Master kampus')

@section('content')

<div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
    {{-- <h3 class="mb-5 text-lg font-semibold text-gray-800 dark:text-white/90 lg:mb-7">
        Data Kampus
    </h3> --}}

    <div class="p-5 mb-6 border border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6">
        <div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">
            <div class="flex flex-col items-center w-full gap-6 xl:flex-row">
                <div class="w-25 h-25 overflow-hidden   dark:border-gray-800">
                    <img src="{{ asset('images/icon/kampus.png') }}" alt="user" />
                </div>
                <div class="order-3 xl:order-2">
                    <h4 class="mb-2 text-lg font-semibold text-center text-gray-800 dark:text-white/90 xl:text-left">
                        Kelola master data kampus
                    </h4>
                    <div class="flex flex-col items-center gap-1 text-center xl:flex-row xl:gap-3 xl:text-left">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Team Manager
                        </p>
                        <div class="hidden h-3.5 w-px bg-gray-300 dark:bg-gray-700 xl:block"></div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Arizona, United States
                        </p>
                    </div>
                </div>
            </div>

            {{-- <button id="btnOpen"
                class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow hover:bg-blue-700 transition">
                <x-heroicon-c-plus-circle class="h-5 w-5" />
                <span>Tambah</span>
            </button> --}}
            <a href="{{ route('pekerjaan.create') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow hover:bg-blue-700 transition">
                <x-heroicon-c-plus-circle class="h-5 w-5" />
                <span>Tambah</span>
            </a>

        </div>
    </div>

    <div class="p-5 mb-6 border border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6 w-full">
  @if(session('success'))
        <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-700">
            {{ session('success') }}
        </div>
        @endif
        <div class="w-full overflow-x-auto">
            <table id="kampusPekerjaan" class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-medium">
                    <tr>
                        <th class="px-6 py-3 text-center w-16">No</th>
                        <th class="px-6 py-3 text-left">Nama Kampus</th>
                        <th class="px-6 py-3 text-left">Email Kampus</th>
                        <th class="px-6 py-3 text-left">Alamat Kampus</th>
                        <th class="px-6 py-3 text-left">Telepon Kampus</th>
                        <th class="px-6 py-3 text-center w-44">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100"></tbody>
            </table>
        </div>
    </div>
</div>



@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        if (!window.$) {
            console.error('jQuery NOT loaded');
            return;
        }


        window.table = $('#kampusPekerjaan').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('pekerjaan.datatables') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    width: '50px',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },
                {
                    data: 'pk_nama_pekerjaan',
                    name: 'pk_nama_pekerjaan',
                    width: '200px'
                },
                {
                    data: 'pk_level_pekerjaan',
                    name: 'pk_level_pekerjaan',
                    width: '250px'
                },
                {
                    data: 'pk_deskripsi_pekerjaan',
                    name: 'pk_deskripsi_pekerjaan',
                    width: '300px'
                },
                {
                    data: 'pk_minimal_skill',
                    name: 'pk_minimal_skill',
                    width: '150px',
                    className: 'text-center'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    width: '200px',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },
            ],
        });
    });

</script>
@endpush
