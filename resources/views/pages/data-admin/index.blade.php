@extends('layouts.app')

@section('title','Data Admin')

@section('content')

<div class="rounded-2xl border border-gray-200 bg-white p-5 lg:p-6">

    {{-- HEADER --}}
    <div class="p-5 mb-6 border border-gray-200 rounded-2xl lg:p-6">
        <div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">

            <div class="flex flex-col items-center w-full gap-6 xl:flex-row">
                <div class="w-25 h-25 overflow-hidden">
                    <img src="{{ asset('images/icon/kampus.png') }}" alt="admin" />
                </div>

                <div>
                    <h4 class="mb-2 text-lg font-semibold text-gray-800">
                        Kelola data admin
                    </h4>

                    <div class="flex items-center gap-3 text-sm text-gray-500">
                        <span>Team Manager</span>
                        <span class="hidden xl:block h-3.5 w-px bg-gray-300"></span>
                        <span>Arizona, United States</span>
                    </div>
                </div>
            </div>

            {{-- TOMBOL TAMBAH --}}
            {{--<button id="btnOpen"
                class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow hover:bg-blue-700 transition">
                <x-heroicon-c-plus-circle class="h-5 w-5" />
                <span>Tambah</span>
            </button>--}}

        </div>
    </div>

    {{-- TABLE --}}
    <div class="p-5 border border-gray-200 rounded-2xl lg:p-6">

        <div class="w-full overflow-x-auto">
            <table id="adminTable" class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">

                <thead class="bg-gray-50 text-xs uppercase font-medium text-gray-600">
                    <tr>
                        <th class="px-6 py-3 text-center w-16">No</th>
                        <th class="px-6 py-3 text-left">Nama</th>
                        <th class="px-6 py-3 text-left">Email</th>
                        <th class="px-6 py-3 text-left">No HP</th>
                        <th class="px-6 py-3 text-left">Posisi</th>
                        <th class="px-6 py-3 text-center w-28">Status</th>
                        <th class="px-6 py-3 text-center w-28">Detail</th>
                        <th class="px-6 py-3 text-center w-36">Aksi</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-100"></tbody>
            </table>
        </div>

    </div>
</div>

@endsection

{{-- MODAL --}}
@include('pages.data-admin.add')
@include('pages.data-admin.edit')
@include('pages.data-admin.detail')

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    if (!window.$) {
        console.error('jQuery NOT loaded');
        return;
    }

    window.table = $('#adminTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: false,
        scrollX: true,
        ajax: "{{ route('data-admin.datatables') }}",

        columns: [
            {
                data: 'DT_RowIndex',
                orderable: false,
                searchable: false,
                className: 'text-center',
                width: '50px'
            },
            { data: 'pr_nama', name: 'pr_nama' },
            { data: 'email', name: 'email' },
            { data: 'pr_no_hp', name: 'pr_no_hp' },
            { data: 'pr_posisi', name: 'pr_posisi' },


            { data:'status', orderable:false, searchable:false },


            {
                data: 'detail',
                orderable: false,
                searchable: false,
                className: 'text-center'
            },
            {
                data: 'aksi',
                orderable: false,
                searchable: false,
                className: 'text-center'
            }
        ],
    });

    $(document).on('click','.toggle-status',function(){

    const id     = $(this).data('id');
    const name   = $(this).data('name');
    const status = $(this).data('status');

    const nextStatus = status === 'Aktif' ? 'Nonaktif' : 'Aktif';

    Swal.fire({
        icon: 'question',
        title: 'Konfirmasi',
        html: `Anda yakin ingin <b>${nextStatus === 'Aktif' ? 'mengaktifkan' : 'menonaktifkan'}</b> akun <b>${name}</b>?`,
        showCancelButton: true,
        confirmButtonText: 'Ya, lanjutkan',
        cancelButtonText: 'Batal',
        confirmButtonColor: nextStatus === 'Aktif' ? '#16a34a' : '#dc2626'
    }).then((result) => {

        if(result.isConfirmed){

            $.post(`/data-admin/${id}/toggle-status`,{
                _token:$('meta[name="csrf-token"]').attr('content')
            },function(){

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: `Status akun ${name} berhasil diubah`,
                    timer: 1200,
                    showConfirmButton:false
                });

                window.table.ajax.reload(null,false);
            });

        }

    });

});


});
</script>
@endpush

