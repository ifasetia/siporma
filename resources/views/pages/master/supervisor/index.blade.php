@extends('layouts.app')

@section('title','Master Supervisor')

@section('content')
<div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
    <div class="p-5 mb-6 border border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6">
        <div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">
            <div class="flex flex-col items-center w-full gap-6 xl:flex-row">
                <div class="w-25 h-25 overflow-hidden dark:border-gray-800">
                    {{-- Gunakan icon kampus sebagai fallback jika icon supervisor belum ada --}}
                    <img src="{{ asset('images/icon/kampus.png') }}" alt="user" />
                </div>
                <div class="order-3 xl:order-2">
                    <h4 class="mb-2 text-lg font-semibold text-center text-gray-800 dark:text-white/90 xl:text-left">
                        Kelola Master Data Supervisor
                    </h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400 text-center xl:text-left">
                        Manajemen data pembimbing lapangan untuk mahasiswa magang.
                    </p>
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
            <table id="supervisorTable" class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-medium">
                    <tr>
                        <th class="px-6 py-3 text-center w-16">No</th>
                        <th class="px-6 py-3 text-left">NIP</th>
                        <th class="px-6 py-3 text-left">Nama Supervisor</th>
                        <th class="px-6 py-3 text-left">Jabatan</th>
                        <th class="px-6 py-3 text-left">Divisi</th>
                        <th class="px-6 py-3 text-center w-28">Status</th>
                        <th class="px-6 py-3 text-center w-44">Aksi</th>
                        
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100"></tbody>
            </table>
        </div>
    </div>
</div>

@include('pages.master.supervisor.add')
@include('pages.master.supervisor.edit')

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    if (typeof $ === 'undefined') {
        console.error('jQuery belum terload!');
        return;
    }

    // =========================
    // DATATABLE
    // =========================
    window.table = $('#supervisorTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "{{ route('supervisor.datatables') }}",
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
            { data: 'sp_nip' },
            { data: 'sp_nama' },
            { data: 'sp_jabatan' },
            { data: 'sp_divisi' },
            { data:'status', orderable:false, searchable:false, className:'text-center' },
            { data: 'aksi', orderable: false, searchable: false, className: 'text-center' },
        ],
    });

    // =========================
    // EDIT BUTTON
    // =========================
    $(document).on('click', '.btn-edit', function () {

        const id = $(this).data('id');

        Swal.fire({
            title: 'Loading...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        $.ajax({
            url: `/supervisor/${id}/edit`,
            type: 'GET',
            success: function (res) {

                Swal.close();

                const data = res.data;
                const form = $('#submitFormEditSupervisor');

                form.attr('action', `/supervisor/${id}/update`);

                form.find('[name="sp_nip"]').val(data.sp_nip);
                form.find('[name="sp_nama"]').val(data.sp_nama);
                form.find('[name="sp_jabatan"]').val(data.sp_jabatan);
                form.find('[name="sp_divisi"]').val(data.sp_divisi);
                form.find('[name="sp_email"]').val(data.sp_email);
                form.find('[name="sp_telepon"]').val(data.sp_telepon);

                $('#eventEditModal').removeClass('hidden');
                $('body').addClass('overflow-hidden');
            }
        });
    });

    // =========================
    // UPDATE BUTTON
    // =========================
    $(document).on('click', '#btnEditSupervisor', function (e) {

        e.preventDefault();

        const $form = $('#submitFormEditSupervisor');
        const url = $form.attr('action');
        const btn = $(this);

        btn.prop('disabled', true).text('Menyimpan...');

        $.ajax({
            url: url,
            method: 'POST',
            data: $form.serialize(),
            success: function (res) {

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: res.message,
                    timer: 1500,
                    showConfirmButton: false
                });

                $('#eventEditModal').addClass('hidden');
                $('body').removeClass('overflow-hidden');
                window.table.ajax.reload(null, false);
            },
            error: function (xhr) {

                btn.prop('disabled', false).text('Simpan');

                if (xhr.status === 422) {

                    const errors = xhr.responseJSON.errors;
                    $('.error').text('');

                    Object.keys(errors).forEach(key => {
                        $(`[data-error="${key}"]`).text(errors[key][0]);
                    });

                } else {
                    Swal.fire('Error', 'Gagal memperbarui data.', 'error');
                }
            },
            complete: function(){
                btn.prop('disabled', false).text('Simpan');
            }
        });
    });

    // =========================
    // TOGGLE STATUS
    // =========================
    $(document).on('click', '.toggle-status', function () {

        const id = $(this).data('id');

        $.ajax({
            url: `/supervisor/${id}/toggle-status`,
            type: 'POST',
            data: {
                _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            success: function () {
                window.table.ajax.reload(null, false);
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                Swal.fire('Error', 'Gagal mengubah status!', 'error');
            }
        });
    });

    // =========================
    // CLOSE MODAL
    // =========================
    $(document).on('click', '.modal-close-btn', function() {
        $('#eventEditModal, #eventModal').addClass('hidden');
        $('body').removeClass('overflow-hidden');
    });

});
</script>
@endpush