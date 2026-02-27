@extends('layouts.app')

@section('title','Data Interns')

@section('content')

<div class="rounded-2xl border border-gray-200 bg-white p-5 lg:p-6">

    {{-- HEADER --}}
    <div class="p-5 mb-6 border border-gray-200 rounded-2xl lg:p-6">
        <div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">

            <div class="flex flex-col items-center w-full gap-6 xl:flex-row">
                <div class="w-25 h-25 overflow-hidden">
                    <img src="{{ asset('images/icon/kampus.png') }}" alt="intern" />
                </div>

                <div>
                    <h4 class="mb-2 text-lg font-semibold text-gray-800">
                        Kelola data interns
                    </h4>

                    <div class="flex items-center gap-3 text-sm text-gray-500">
                        <span>Team Manager</span>
                        <span class="hidden xl:block h-3.5 w-px bg-gray-300"></span>
                        <span>Arizona, United States</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- TABLE --}}
    <div class="p-5 border border-gray-200 rounded-2xl lg:p-6">

        <div class="w-full overflow-x-auto">
            <table id="internTable" class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">

                <thead class="bg-gray-50 text-xs uppercase font-medium text-gray-600">
                    <tr>
                        <th class="px-6 py-3 text-center w-16">No</th>
                        <th class="px-6 py-3 text-left">Nama</th>
                        <th class="px-6 py-3 text-left">Email</th>
                        <th class="px-6 py-3 text-left">Kampus</th>
                        <th class="px-6 py-3 text-left">Jurusan</th>
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
@include('pages.data-intern.edit')
@include('pages.data-intern.detail')


@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        if (!window.$) {
            console.error('jQuery NOT loaded');
            return;
        }

            window.table = $('#internTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: false,
                scrollX: true,
                ajax: "{{ route('data-intern.datatables') }}",

                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        width: '50px'
                    },
                    {
                        data: 'pr_nama',
                        name: 'pr_nama'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'pr_kampus',
                        name: 'pr_kampus'
                    },
                    {
                        data: 'pr_jurusan',
                        name: 'pr_jurusan'
                    },


                    {
                        data: 'status',
                        orderable: false,
                        searchable: false
                    },


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

            // $(document).on('click', '.btn-detail', function () {

            //     const id = $(this).data('id');

            //     window.location.href = `/data-intern/${id}/detail`;

            // });

            // $(document).on('click', '.btn-edit', function () {

            //     const id = $(this).data('id');
            //     alert(id);

            //     // window.location.href = `/data-intern/${id}/edit`;

            // });

            // $(document).on('click', '.btn-delete', function () {

            //     const id = $(this).data('id');

            //     Swal.fire({
            //         icon: 'warning',
            //         title: 'Yakin hapus?',
            //         text: 'Data tidak bisa dikembalikan',
            //         showCancelButton: true,
            //         confirmButtonText: 'Ya, hapus',
            //         cancelButtonText: 'Batal',
            //         confirmButtonColor: '#dc2626'
            //     }).then((result) => {

            //         if (result.isConfirmed) {

            //             $.ajax({
            //                 url: `/data-intern/${id}`,
            //                 type: 'DELETE',
            //                 data: {
            //                     _token: $('meta[name="csrf-token"]').attr('content')
            //                 },
            //                 success: function (res) {

            //                     Swal.fire({
            //                         icon: 'success',
            //                         title: 'Berhasil',
            //                         text: res.message,
            //                         timer: 1200,
            //                         showConfirmButton: false
            //                     });

            //                     window.table.ajax.reload(null, false);
            //                 },
            //                 error: function () {
            //                     Swal.fire('Gagal', 'Terjadi kesalahan', 'error');
            //                 }
            //             });

            //         }

            //     });

            // });

            // $(document).on('click', '.toggle-status', function () {

            //     const id = $(this).data('id');
            //     const name = $(this).data('name');
            //     const status = $(this).data('status');

            //     const nextStatus = status === 'Aktif' ? 'Nonaktif' : 'Aktif';

            //     Swal.fire({
            //         icon: 'question',
            //         title: 'Konfirmasi',
            //         html: `Anda yakin ingin <b>${nextStatus === 'Aktif' ? 'mengaktifkan' : 'menonaktifkan'}</b> akun <b>${name}</b>?`,
            //         showCancelButton: true,
            //         confirmButtonText: 'Ya, lanjutkan',
            //         cancelButtonText: 'Batal',
            //         confirmButtonColor: nextStatus === 'Aktif' ? '#16a34a' : '#dc2626'
            //     }).then((result) => {

            //         if (result.isConfirmed) {

            //             $.post(`/data-intern/${id}/toggle-status`, {
            //                 _token: $('meta[name="csrf-token"]').attr('content')
            //             }, function () {

            //                 Swal.fire({
            //                     icon: 'success',
            //                     title: 'Berhasil',
            //                     text: `Status akun ${name} berhasil diubah`,
            //                     timer: 1200,
            //                     showConfirmButton: false
            //                 });

            //                 window.table.ajax.reload(null, false);
            //             });

            //         }

            //     });

            // });


        });

    </script>
@endpush
