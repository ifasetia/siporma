@extends('layouts.app')

@section('title','Validasi Proyek')

@section('content')

<div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">

    <div class="p-5 mb-6 border border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6">
        <div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">
            <div class="flex flex-col items-center w-full gap-6 xl:flex-row">
                <div class="w-25 h-25 overflow-hidden dark:border-gray-800">
                    <img src="{{ asset('images/icon/kampus.png') }}" alt="validasi" />
                </div>
                <div class="order-3 xl:order-2">
                    <h4 class="mb-2 text-lg font-semibold text-center text-gray-800 dark:text-white/90 xl:text-left">
                        Validasi Proyek Intern
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
        </div>
    </div>

    <div class="p-5 mb-6 border border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6 w-full">
        <div class="w-full overflow-x-auto">
            <table id="validasiTable" class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-medium">
                    <tr>
                        <th class="px-6 py-3 text-center w-16">No</th>
                        <th class="px-6 py-3 text-left">Nama Intern</th>
                        <th class="px-6 py-3 text-left">Judul Proyek</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-center w-44">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100"></tbody>
            </table>
        </div>
    </div>
</div>

<div id="modalValidasi" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="bg-white dark:bg-gray-900 rounded-2xl w-full max-w-md p-6 relative shadow-lg">
        <button id="closeModalIcon" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 dark:hover:text-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Review & Validasi Proyek</h3>

        <form id="formValidasi">
            @csrf
            <input type="hidden" id="project_id" name="project_id">

            <div class="mb-5">
                <label class="mb-3 block text-sm font-medium text-gray-700 dark:text-gray-300">Ubah Status Proyek</label>
                <select id="status_id" name="status_id" class="w-full rounded-lg border border-gray-300 bg-white py-3 px-4 text-gray-700 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300" required>
                    <option value="">-- Pilih Keputusan --</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status->sp_id }}">{{ $status->sp_nama_status }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" id="btnBatal" class="rounded-lg bg-red-500 px-4 py-2 text-white hover:bg-red-600 transition">Batal</button>
                <button type="submit" id="btnSimpan" class="rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 transition">Simpan Keputusan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // INI KUNCI UTAMANYA BIAR DATATABLES JALAN DI TEMPLATE KAMU
    document.addEventListener('DOMContentLoaded', function () {

        if (!window.$) {
            console.error('jQuery NOT loaded');
            return;
        }

        // 1. Inisialisasi DataTable
        let table = $('#validasiTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('validasi-proyek.datatables') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center'},
                {data: 'intern_name', name: 'intern_name'},
                {data: 'title', name: 'title'},
                {data: 'status', name: 'status', orderable: false, searchable: false},
                {data: 'aksi', name: 'aksi', orderable: false, searchable: false, className: 'text-center'},
            ]
        });

        // 2. Buka Modal saat tombol "Review & Validasi" diklik
        $('body').on('click', '.btn-review', function() {
            let projectId = $(this).data('id');
            $('#project_id').val(projectId);
            $('#status_id').val('');
            $('#modalValidasi').removeClass('hidden');
        });

        // 3. Tutup Modal
        $('#btnBatal, #closeModalIcon').on('click', function() {
            $('#modalValidasi').addClass('hidden');
        });

        // 4. Submit Form Validasi via AJAX
        $('#formValidasi').on('submit', function(e) {
            e.preventDefault();
            let projectId = $('#project_id').val();
            let statusId = $('#status_id').val();
            let token = $("input[name='_token']").val();

            $('#btnSimpan').text('Menyimpan...').prop('disabled', true);

            $.ajax({
                url: `/validasi-proyek/${projectId}/status`,
                type: "PUT",
                data: { _token: token, status_id: statusId },
                success: function(response) {
                    if(response.success) {
                        $('#modalValidasi').addClass('hidden');
                        table.ajax.reload(null, false); // Refresh tabel tanpa reset halaman
                    }
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan saat menyimpan status!');
                },
                complete: function() {
                    $('#btnSimpan').text('Simpan Keputusan').prop('disabled', false);
                }
            });
        });

    });
</script>
@endpush
