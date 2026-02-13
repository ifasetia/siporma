<div id="eventModal" class="fixed inset-0 z-999999 hidden p-5 overflow-y-auto" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-400/50 backdrop-blur-sm"></div>
    <div class="min-h-full flex items-center justify-center">
        <div class="modal-dialog relative w-full max-w-[700px] rounded-3xl bg-white p-6 lg:p-11 ">
            <button type="button" class="modal-close-btn absolute top-5 right-5 flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200 dark:bg-white/5">
                ✕
            </button>

            <form id="submitFormPekerjaan" class="flex flex-col gap-6" action="{{ route('pekerjaan.store') }}" method="POST">
                @csrf
                <div>
                    <h5 id="eventModalLabel" class="font-semibold text-gray-800 text-xl dark:text-white">
                        Tambah Data Pekerjaan
                    </h5>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Silahkan isi form berikut untuk menambahkan data tipe pekerjaan baru.
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Kode Tipe Pekerjaan</label>
                    <input type="text" name="pk_kode_tipe_pekerjaan" class="form-input input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none" placeholder="Inputkan kode...">
                    <span class="text-red-500 text-xs error" data-error="pk_kode_tipe_pekerjaan"></span>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Nama Pekerjaan</label>
                    <input type="text" name="pk_nama_pekerjaan" class="form-input input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none" placeholder="Inputkan nama...">
                    <span class="text-red-500 text-xs error" data-error="pk_nama_pekerjaan"></span>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Level Pekerjaan</label>
                    <select name="pk_level_pekerjaan" class="h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none">
                        <option value="">-- Pilih Level --</option>
                        <option value="Easy">Easy</option>
                        <option value="Medium">Medium</option>
                        <option value="Hard">Hard</option>
                    </select>
                    <span class="text-red-500 text-xs error" data-error="pk_level_pekerjaan"></span>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Estimasi Durasi (Hari)</label>
                    <input type="number" name="pk_estimasi_durasi_hari" class="form-input input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none">
                    <span class="text-red-500 text-xs error" data-error="pk_estimasi_durasi_hari"></span>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Deskripsi Pekerjaan</label>
                    <textarea name="pk_deskripsi_pekerjaan" class="form-input input-field h-24 w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:ring-2 focus:outline-none"></textarea>
                    <span class="text-red-500 text-xs error" data-error="pk_deskripsi_pekerjaan"></span>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Skill yang Dibutuhkan</label>
                    <textarea name="pk_minimal_skill" class="form-input input-field h-24 w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:ring-2 focus:outline-none"></textarea>
                    <span class="text-red-500 text-xs error" data-error="pk_minimal_skill"></span>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" class="modal-close-btn w-24 rounded-lg border px-4 py-2 text-sm bg-red-500 text-white hover:bg-red-600">Tutup</button>
                    <button type="button" id="btnSimpanPekerjaan" class="w-24 bg-brand-500 hover:bg-brand-600 rounded-lg px-4 py-2 text-sm text-white disabled:bg-grey-400">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- LOADING OVERLAY --}}
<div id="loadingOverlay" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-999999">
    <div class="bg-white px-6 py-4 rounded-lg shadow-lg flex items-center gap-3">
        <svg class="animate-spin h-10 w-10 text-gray-700" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
        <span class="text-xl font-medium text-gray-700">Mohon tunggu...</span>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const $modal = $('#eventModal');
        window.openModal = function () {
            $modal.removeClass('hidden');
            $('body').addClass('overflow-hidden');
            $('#submitFormPekerjaan')[0].reset();
            $('.error').text('');
        };
        function closeModal() {
            $modal.addClass('hidden');
            $('body').removeClass('overflow-hidden');
        }
        $(document).on('click', '.modal-close-btn', closeModal);
        $('#btnOpen').on('click', openModal);

        $('#btnSimpanPekerjaan').on('click', function (e) {
            e.preventDefault();
            const btn = $(this);
            const form = $('#submitFormPekerjaan');
            $('.error').text('');
            btn.prop('disabled', true).text('Menyimpan...');

            Swal.fire({
                title: 'Menyimpan data...',
                text: 'Mohon tunggu sebentar',
                icon: 'info',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => Swal.showLoading()
            });

            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                success: function (response) {
                    Swal.fire({ icon: 'success', title: 'Berhasil!', text: response.message, timer: 1500, showConfirmButton: false });
                    closeModal();
                    window.table.ajax.reload(null, false);
                },
                error: function (xhr) {
                    Swal.close();
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        Object.keys(errors).forEach(key => {
                            $(`[data-error="${key}"]`).text(errors[key][0]);
                        });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Oops...', text: 'Terjadi kesalahan server' });
                    }
                },
                complete: () => btn.prop('disabled', false).text('Simpan')
            });
        });
    });
</script>
@endpush
