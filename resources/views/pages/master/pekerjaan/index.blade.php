@extends('layouts.app')

@section('title','Master Pekerjaan')

@section('content')

<div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
    <div class="p-5 mb-6 border border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6">
        <div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">
            <div class="flex flex-col items-center w-full gap-6 xl:flex-row">
                <div class="w-25 h-25 overflow-hidden dark:border-gray-800">
                    <img src="{{ asset('images/icon/kampus.png') }}" alt="user" />
                </div>
                <div class="order-3 xl:order-2">
                    <h4 class="mb-2 text-lg font-semibold text-center text-gray-800 dark:text-white/90 xl:text-left">
                        Kelola master tipe pekerjaan
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

            <button id="btnOpen"
                class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow hover:bg-blue-700 transition">
                <x-heroicon-c-plus-circle class="h-5 w-5" />
                <span>Tambah</span>
            </button>
        </div>
    </div>

    <div class="p-5 mb-6 border border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6 w-full">
        <div class="w-full overflow-x-auto">
            <table id="pekerjaanTable" class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-medium">
                    <tr>
                        <th class="px-6 py-3 text-center w-16">No</th>
                        <th class="px-6 py-3 text-left">Nama Pekerjaan</th>
                        <th class="px-6 py-3 text-left">Level</th>
                        <th class="px-6 py-3 text-left">Deskripsi</th>
                        <th class="px-6 py-3 text-left">Skill</th>
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
@include('pages.master.pekerjaan.add')
@include('pages.master.pekerjaan.edit')

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (!window.$) return;

        // 1. Inisialisasi DataTable (Cukup sekali saja)
        window.table = $('#pekerjaanTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('pekerjaan.datatables') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                { data: 'pk_nama_pekerjaan', name: 'pk_nama_pekerjaan' },
                { data: 'pk_level_pekerjaan', name: 'pk_level_pekerjaan' },
                { data: 'pk_deskripsi_pekerjaan', name: 'pk_deskripsi_pekerjaan' },
                { data: 'pk_minimal_skill', name: 'pk_minimal_skill' },
                { data: 'aksi', name: 'aksi', orderable: false, searchable: false, className: 'text-center' },
            ],
        });

        // 2. FUNGSI TOMBOL EDIT (Load Data ke Modal)
        // Gunakan .off('click') agar event tidak terdaftar dua kali (penyebab auto-save)
        $(document).off('click', '.btn-edit').on('click', '.btn-edit', function () {
            const id = $(this).data('id');
            Swal.fire({ title: 'Mengambil data...', allowOutsideClick: false, showConfirmButton: false, didOpen: () => Swal.showLoading() });

            $.ajax({
                url: `/pekerjaan/${id}/edit`,
                type: 'GET',
                success: function (res) {
                    Swal.close();
                    const data = res.data;
                    const form = $('#submitFormEditPekerjaan');

                    // Set URL Update secara dinamis
                    form.attr('action', `/pekerjaan/${id}/update`);

                    // ISI SEMUA FIELD
                    form.find('[name="pk_kode_tipe_pekerjaan"]').val(data.pk_kode_tipe_pekerjaan);
                    form.find('[name="pk_nama_pekerjaan"]').val(data.pk_nama_pekerjaan);
                    form.find('[name="pk_level_pekerjaan"]').val(data.pk_level_pekerjaan);
                    form.find('[name="pk_estimasi_durasi_hari"]').val(data.pk_estimasi_durasi_hari);
                    form.find('[name="pk_deskripsi_pekerjaan"]').val(data.pk_deskripsi_pekerjaan);
                    form.find('[name="pk_minimal_skill"]').val(data.pk_minimal_skill);

                    $('#eventEditModal').removeClass('hidden');
                    $('body').addClass('overflow-hidden');
                },
                error: function () {
                    Swal.fire('Error', 'Gagal mengambil data', 'error');
                }
            });
        });

        // 3. FUNGSI TOMBOL SIMPAN UPDATE
        $(document).off('click', '#btnUpdatePekerjaan').on('click', '#btnUpdatePekerjaan', function (e) {
            e.preventDefault();
            const form = $('#submitFormEditPekerjaan');
            const btn = $(this);

            btn.prop('disabled', true).text('Menyimpan...');

            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                success: function (res) {
                    Swal.fire({ icon: 'success', title: 'Berhasil!', text: res.message, timer: 1500, showConfirmButton: false });
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
                        Swal.fire('Error', 'Gagal memperbarui data', 'error');
                    }
                },
                complete: () => btn.prop('disabled', false).text('Simpan')
            });
        });

        // 4. FUNGSI TOMBOL TUTUP MODAL
        $(document).on('click', '.modal-close-btn', function() {
            $('#eventEditModal').addClass('hidden');
            $('#eventModal').addClass('hidden'); // Tutup modal add juga jika ada
            $('body').removeClass('overflow-hidden');
        });

        // 5. FUNGSI TOMBOL HAPUS
        $(document).off('click', '.btn-delete').on('click', '.btn-delete', function () {
            const id = $(this).data('id');
            const token = $('meta[name="csrf-token"]').attr('content');

            Swal.fire({
                title: 'Yakin hapus data?',
                text: "Data tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'bg-red-500 text-white px-4 py-2 rounded-lg mx-2',
                    cancelButton: 'bg-gray-400 text-white px-4 py-2 rounded-lg mx-2'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/pekerjaan/${id}/delete`,
                        type: 'DELETE',
                        data: { _token: token },
                        success: function (res) {
                            Swal.fire('Terhapus!', res.message, 'success');
                            window.table.ajax.reload(null, false);
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
