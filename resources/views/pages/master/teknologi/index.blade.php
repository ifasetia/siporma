@extends('layouts.app')

@section('title','Master Teknologi')

@section('content')

<div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
    {{-- <h3 class="mb-5 text-lg font-semibold text-gray-800 dark:text-white/90 lg:mb-7">
        Data Teknologi
    </h3> --}}

    <div class="p-5 mb-6 border border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6">
        <div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">
            <div class="flex flex-col items-center w-full gap-6 xl:flex-row">
                <div class="w-25 h-25 overflow-hidden   dark:border-gray-800">
                    {{-- Ubah nama icon jika punya icon khusus teknologi --}}
                    <img src="{{ asset('images/icon/kampus.png') }}" alt="icon" />
                </div>
                <div class="order-3 xl:order-2">
                    <h4 class="mb-2 text-lg font-semibold text-center text-gray-800 dark:text-white/90 xl:text-left">
                        Kelola Master Data Teknologi
                    </h4>
                    <div class="flex flex-col items-center gap-1 text-center xl:flex-row xl:gap-3 xl:text-left">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Team Manager
                        </p>
                        <div class="hidden h-3.5 w-px bg-gray-300 dark:bg-gray-700 xl:block"></div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Dinas Kominfo & Statistik
                        </p>
                    </div>
                </div>
            </div>

            <button id="btnOpen"
                class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow hover:bg-blue-700 transition">
                <x-heroicon-c-plus-circle class="h-5 w-5" />
                <span>Tambah</span>
            </button>
        </div>
    </div>

    <div class="p-5 mb-6 border border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6 w-full">

        <div class="w-full overflow-x-auto">
            <table id="teknologiTable" class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-medium">
                    <tr>
                        <th class="px-6 py-3 text-center w-16">No</th>
                        <th class="px-6 py-3 text-left">Nama Teknologi</th>
                        <th class="px-6 py-3 text-left">Kategori</th>
                        <th class="px-6 py-3 text-center w-44">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100"></tbody>
            </table>
        </div>
    </div>
</div>

@endsection

{{-- MODAL --}}
@include('pages.master.teknologi.add')
@include('pages.master.teknologi.edit')

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        if (!window.$) {
            console.error('jQuery NOT loaded');
            return;
        }

        window.table = $('#teknologiTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('teknologi.datatables') }}",
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    width: '50px',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },
                {
                    data: 'tk_nama',
                    name: 'tk_nama',
                    width: '350px'
                },
                {
                    data: 'tk_kategori',
                    name: 'tk_kategori',
                    width: '350px'
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

        // Fungsi Tutup Modal Tambah (dari perbaikan sebelumnya)
        $(document).on('click', '.modal-add-close-btn', function () {
            $('#eventModal').addClass('hidden');
            $('body').removeClass('overflow-hidden');
            if ($('#submitFormTeknologi').length) {
                $('#submitFormTeknologi')[0].reset();
            }
            $('.error').text('');
            $('.input-field').removeClass('border-red-500');
        });

    });

</script>
@endpush
