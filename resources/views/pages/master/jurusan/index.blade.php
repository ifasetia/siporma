@extends('layouts.app')

@section('title','Master Jurusan')

@section('content')
<div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
    <div class="p-5 mb-6 border border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6">
        <div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">
            <div class="flex flex-col items-center w-full gap-6 xl:flex-row">
                <div class="w-25 h-25 overflow-hidden">
                    <img src="{{ asset('images/icon/jurusan.png') }}" alt="jurusan"
                        onerror="this.src='https://ui-avatars.com/api/?name=Jurusan&background=0D8ABC&color=fff'">
                </div>
                <div class="order-3 xl:order-2">
                    <h4 class="mb-2 text-lg font-semibold text-center text-gray-800 dark:text-white/90 xl:text-left">
                        Kelola Master Data Jurusan
                    </h4>
                    <div class="flex flex-col items-center gap-1 text-center xl:flex-row xl:gap-3 xl:text-left">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Team Manager</p>
                        <div class="hidden h-3.5 w-px bg-gray-300 dark:bg-gray-700 xl:block"></div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Dinas Kominfo & Statistik</p>
                    </div>
                </div>
            </div>

            <button id="btnOpen" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow hover:bg-blue-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Tambah</span>
            </button>
        </div>
    </div>

    <div class="p-5 mb-6 border border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6 w-full">
        <div class="w-full overflow-x-auto">
            <table id="jurusanTable" class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-medium">
                    <tr>
                        <th class="px-6 py-3 text-center w-16">No</th>
                        <th class="px-6 py-3 text-left">Nama Jurusan</th>
                        <th class="px-6 py-3 text-left">Kode Jurusan</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100"></tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL --}}
@include('pages.master.jurusan.add')
@include('pages.master.jurusan.edit')

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (!window.$) return;

        // 1. Inisialisasi DataTable
        window.table = $('#jurusanTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('jurusan.datatables') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                { data: 'js_nama', name: 'js_nama' },
                { data: 'js_kode', name: 'js_kode' },
                { data: 'aksi', name: 'aksi', orderable: false, searchable: false, className: 'text-center' },
            ],
        });

        // 2. Fungsi Tutup Modal Gabungan (Handel ID #eventModal & #eventEditModal)
        window.allCloseModal = function() {
            $('#eventModal, #eventEditModal').addClass('hidden');
            $('body').removeClass('overflow-hidden');

            // Reset Form Tambah (ID form harus sesuai dengan di add.blade.php)
            if ($('#submitFormJurusan').length) {
                $('#submitFormJurusan')[0].reset();
            }
            // Reset Form Edit
            if ($('#submitFormEditJurusan').length) {
                $('#submitFormEditJurusan')[0].reset();
            }

            $('.error').text('');
            $('.input-field').removeClass('border-red-500');
        };

        // 4. Tombol Buka Modal Tambah
        $('#btnOpen').on('click', function() {
            $('#eventModal').removeClass('hidden');
            $('body').addClass('overflow-hidden');
        });

        $(document).on('click', '.modal-add-close-btn', function () {
            $('#eventModal').addClass('hidden');
            $('body').removeClass('overflow-hidden');
            if ($('#submitFormJurusan').length) {
                $('#submitFormJurusan')[0].reset();
            }
            $('.error').text('');
            $('.input-field').removeClass('border-red-500');
        });

        // 5. Tombol Edit (Ambil data AJAX)
        $(document).on('click', '.btn-edit', function () {
            const id = $(this).data('id');
            Swal.fire({ title: 'Loading...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

            $.ajax({
                url: `/jurusan/${id}/edit`,
                type: 'GET',
                success: function (res) {
                    Swal.close();
                    const data = res.data;
                    const $f = $('#submitFormEditJurusan');

                    // Isi data & ganti action URL menggunakan js_id
                    $f.attr('action', `/jurusan/${data.js_id}/update`);
                    $f.find('input[name="js_nama"]').val(data.js_nama);
                    $f.find('input[name="js_kode"]').val(data.js_kode);

                    $('#eventEditModal').removeClass('hidden');
                    $('body').addClass('overflow-hidden');
                },
                error: function () { Swal.fire({ icon: 'error', title: 'Gagal', text: 'Data tidak ditemukan' }); }
            });
        });

        // 6. Simpan Perubahan (Tombol Simpan di Modal Edit)
        // Pastikan ID ini SAMA PERSIS dengan id="btnEditJurusan" di file edit.blade.php
        $(document).on('click', '#btnEditJurusan', function (e) {
            e.preventDefault();
            console.log("Tombol Simpan diklik!"); // Cek di F12 Console

            const form = $('#submitFormEditJurusan');
            const url = form.attr('action');
            const btn = $(this);

            // Validasi URL biar nggak kirim ke alamat kosong
            if (!url || url === "") {
                Swal.fire({ icon: 'error', title: 'Waduh!', text: 'Alamat pengiriman data tidak ditemukan (URL kosong)' });
                return;
            }

            $.ajax({
                url: url,
                method: 'POST', // Laravel baca @method('PUT') di form
                data: form.serialize(),
                beforeSend: function() {
                    btn.prop('disabled', true).text('Menyimpan...');
                },
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    allCloseModal(); // Fungsi tutup global kita tadi
                    window.table.ajax.reload(null, false); // Refresh tabel
                },
                error: function (xhr) {
                    btn.prop('disabled', false).text('Simpan');
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        Object.keys(errors).forEach(key => {
                            $(`[data-error="${key}"]`).text(errors[key][0]);
                            $(`[name="${key}"]`).addClass('border-red-500');
                        });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Gagal!', text: 'Terjadi kesalahan sistem' });
                    }
                },
                complete: function() {
                    btn.prop('disabled', false).text('Simpan');
                }
            });
        });

        /*
        |--------------------------------------------------------------------------
        | ➕ SIMPAN DATA JURUSAN BARU (ADD)
        |--------------------------------------------------------------------------
        */
        // Pastikan ID tombol di file add.blade.php adalah id="btnSaveJurusan"
        $(document).on('click', '#btnSaveJurusan', function (e) {
            e.preventDefault();

            const form = $('#submitFormJurusan'); // Pastikan ID form tambah sudah benar
            const btn = $(this);
            const url = "{{ route('jurusan.store') }}"; // Sesuaikan dengan route store kamu

            // Bersihkan error lama
            $('.error').text('');
            $('.input-field').removeClass('border-red-500');

            $.ajax({
                url: url,
                method: 'POST',
                data: form.serialize(),
                beforeSend: function() {
                    btn.prop('disabled', true).text('Menyimpan...');
                },
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    allCloseModal(); // Tutup modal pakai fungsi global kita
                    window.table.ajax.reload(null, false); // Refresh datatable
                },
                error: function (xhr) {
                    btn.prop('disabled', false).text('Simpan');
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        Object.keys(errors).forEach(key => {
                            // Cari span error berdasarkan data-error atau class
                            $(`[data-error="${key}"]`).text(errors[key][0]);
                            $(`input[name="${key}"]`).addClass('border-red-500');
                        });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Gagal!', text: 'Terjadi kesalahan sistem saat menambah data' });
                    }
                },
                complete: function() {
                    btn.prop('disabled', false).text('Simpan');
                }
            });
        });

        /*
        |--------------------------------------------------------------------------
        | 🗑️ DELETE DATA JURUSAN
        |--------------------------------------------------------------------------
        */
        $(document).on('click', '.btn-delete', function () {
            const id = $(this).data('id');
            const token = $('meta[name="csrf-token"]').attr('content');

            Swal.fire({
                title: 'Yakin hapus data?',
                text: "Data tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg',
                    cancelButton: 'bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg ml-2'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({ title: 'Menghapus data...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

                    $.ajax({
                        url: `/jurusan/${id}`,
                        type: 'DELETE',
                        data: { _token: token },
                        success: function (res) {
                            Swal.fire({ icon: 'success', title: 'Berhasil!', text: res.message, timer: 1500, showConfirmButton: false });
                            window.table.ajax.reload(null, false);
                        },
                        error: function (xhr) {
                            let msg = 'Gagal menghapus data';
                            if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                            Swal.fire({ icon: 'error', title: 'Oops...', text: msg });
                        }
                    });
                }
            });
        });

        // 7. Tutup dengan ESC
        $(document).on('keydown', function (e) {
            if (e.key === 'Escape') allCloseModal();
        });
    });
</script>
@endpush
