<!-- Modal -->
<div id="eventEditModal" class="fixed inset-0 z-999999 hidden p-5 overflow-y-auto" role="dialog" aria-modal="true">

    <!-- Overlay -->
    <div class="fixed inset-0 bg-gray-400/50 backdrop-blur-sm"></div>
    <div class="min-h-full flex items-center justify-center">
        <!-- Dialog -->
        <div class="modal-dialog relative w-full max-w-[700px] rounded-3xl bg-white p-6 lg:p-11 ">

            <!-- Close Button -->
            <button type="button"
                class="modal-close-btn absolute top-5 right-5 flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200 dark:bg-white/5">
                ✕
            </button>

            <form id="submitFormEditSupervisor" class="flex flex-col gap-6" action="" method="POST"
                enctype="multipart/form-data">
                @csrf
                <!-- Header -->
                <div>
                    <h5 id="eventEditModalLabel" class="font-semibold text-gray-800 text-xl dark:text-white">
                        Edit Data Supervisor Mahasiswa
                    </h5>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Silahkan isi form berikut untuk mengedit data Supervisor mahasiswa.
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">NIP Supervisor</label>
                    <input type="text"
                        class="form-input input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none"
                        placeholder="Inputkan NIP supervisor..." name="sp_nip">
                    <span class="text-red-500 text-xs error" data-error="sp_nip"></span>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Nama Supervisor</label>
                    <input type="text"
                        class="form-input input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none"
                        placeholder="Inputkan nama lengkap..." name="sp_nama">
                    <span class="text-red-500 text-xs error" data-error="sp_nama"></span>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Jabatan</label>
                    <input type="text"
                        class="form-input input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none"
                        placeholder="Contoh: Kepala Seksi / Staff Ahli..." name="sp_jabatan">
                    <span class="text-red-500 text-xs error" data-error="sp_jabatan"></span>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Divisi / Bidang</label>
                    <input type="text"
                        class="form-input input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none"
                        placeholder="Contoh: Teknologi Informasi / Statistik..." name="sp_divisi">
                    <span class="text-red-500 text-xs error" data-error="sp_divisi"></span>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Email Supervisor</label>
                    <input type="email"
                        class="form-input input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none"
                        placeholder="Inputkan email aktif..." name="sp_email">
                    <span class="text-red-500 text-xs error" data-error="sp_email"></span>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Telepon Supervisor</label>
                    <input type="number"
                        class="form-input input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none"
                        placeholder="Contoh: 0812..." name="sp_telepon">
                    <span class="text-red-500 text-xs error" data-error="sp_telepon"></span>
                </div>
                <!-- Footer -->
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button"
                        class="modal-close-btn w-24 rounded-lg border px-4 py-2 text-sm bg-red-500 text-white hover:bg-red-600">
                        Tutup
                    </button>

                    <button type="button" id="btnEditSupervisor"
                        class="w-24 bg-brand-500 hover:bg-brand-600 rounded-lg px-4 py-2 text-sm text-white disabled:bg-grey-400">
                        Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- INI LOADING --}}
<div id="loadingOverlay" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-999999">
    <div class="bg-white px-6 py-4 rounded-lg shadow-lg flex items-center gap-3">
        <svg class="animate-spin h-10 w-10 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
        </svg>
        <span class="text-xl font-medium text-gray-700">
            Mohon tunggu...
        </span>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const $modalEditSp = $('#eventEditModal');

       // Fungsi Tutup (Fokus ke ID yang ada di HTML kamu)
        window.closeSupervisorEdit = function() {
            $('#eventEditModal').addClass('hidden'); // ID modal asli kamu
            $('body').removeClass('overflow-hidden');
            // Hanya reset jika form ada
            if ($('#submitFormEditSupervisor').length) {
                $('#submitFormEditSupervisor')[0].reset();
            }
            $('.error').text('');
            $('.input-field').removeClass('border-red-500');
        };

        // Event Listener (Gunakan class yang ada di HTML kamu: modal-close-btn)
        $(document).on('click', '.modal-close-btn', function (e) {
            e.preventDefault();
            closeSupervisorEdit();
        });
        // 3. Ambil Data (Edit Click)
        $(document).on('click', '.btn-edit', function () {
            const id = $(this).data('id');
            Swal.fire({ title: 'Loading...', didOpen: () => Swal.showLoading() });

            $.ajax({
                url: `/supervisor/${id}/edit`,
                type: 'GET',
                success: function (res) {
                    Swal.close();
                    const data = res.data;
                    const $f = $('#submitFormEditSupervisor');

                    // Gunakan sp_id untuk action URL
                    $f.attr('action', `/supervisor/${data.sp_id}/update`);

                    // Isi Field (Pastikan name di HTML sudah sp_...)
                    $f.find('input[name="sp_nip"]').val(data.sp_nip);
                    $f.find('input[name="sp_nama"]').val(data.sp_nama);
                    $f.find('input[name="sp_jabatan"]').val(data.sp_jabatan);
                    $f.find('input[name="sp_divisi"]').val(data.sp_divisi);
                    $f.find('input[name="sp_email"]').val(data.sp_email);
                    $f.find('input[name="sp_telepon"]').val(data.sp_telepon);

                    $modalEditSp.removeClass('hidden');
                    $('body').addClass('overflow-hidden');
                },
                error: function() {
                    Swal.fire({ icon: 'error', title: 'Gagal!', text: 'Data tidak ditemukan' });
                }
            });
        });

        // 4. Update Data (Simpan Click)
        // Ganti bagian selector klik tombol simpan update menjadi ini:
        $(document).on('click', '#btnEditSupervisor', function (e) {
            e.preventDefault();
            const form = $('#submitFormEditSupervisor');
            const url = form.attr('action');
            const btn = $(this);

            $.ajax({
                url: url,
                method: 'POST', // Laravel membaca @method('PUT') dari form serialize
                data: form.serialize(),
                beforeSend: function() {
                    btn.prop('disabled', true).text('Updating...');
                    $('.error').text('');
                },
                success: function (response) {
                    Swal.fire({ icon: 'success', title: 'Berhasil!', text: response.message, timer: 1500, showConfirmButton: false });
                    closeSupervisorEdit(); // Fungsi tutup yang kamu bilang sudah jalan
                    if (window.table) window.table.ajax.reload(null, false);
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
                        Swal.fire({ icon: 'error', title: 'Oops...', text: 'Gagal update data.' });
                    }
                }
            });
        });
</script>
@endpush
