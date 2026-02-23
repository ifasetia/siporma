<div id="eventEditModal" class="fixed inset-0 z-999999 hidden p-5 overflow-y-auto" role="dialog" aria-modal="true">

    <div class="fixed inset-0 bg-gray-400/50 backdrop-blur-sm"></div>
    <div class="min-h-full flex items-center justify-center">
        <div class="modal-dialog relative w-full max-w-[700px] rounded-3xl bg-white p-6 lg:p-11 ">

            <button type="button"
                class="modal-close-btn absolute top-5 right-5 flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200 dark:bg-white/5">
                ✕
            </button>

            <form id="submitFormEditJurusan" class="flex flex-col gap-6" action="" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div>
                    <h5 id="eventEditModalLabel" class="font-semibold text-gray-800 text-xl dark:text-white">
                        Edit Data Jurusan Mahasiswa
                    </h5>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Silahkan isi form berikut untuk mengedit data jurusan mahasiswa.
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Nama Jurusan</label>
                    <input id="event-title" type="text"
                        class="form-input input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none"
                        placeholder="Inputkan nama jurusan..." name="js_nama">
                    <span class="text-red-500 text-xs error" data-error="js_nama"></span>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Kode Jurusan</label>
                    <input id="event-code" type="text"
                        class="form-input input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none"
                        placeholder="Inputkan kode jurusan..." name="js_kode">
                    <span class="text-red-500 text-xs error" data-error="js_kode"></span>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button"
                        class="modal-close-btn w-24 rounded-lg border px-4 py-2 text-sm bg-red-500 text-white hover:bg-red-600">
                        Tutup
                    </button>

                    <button type="button" id="btnEditJurusan"
                        class="w-24 bg-brand-500 hover:bg-brand-600 rounded-lg px-4 py-2 text-sm text-white disabled:bg-grey-400">
                        Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        if (!window.$) {
            console.error('jQuery NOT loaded');
            return;
        }

        const $modalEdit = $('#eventEditModal');
        let currentEditId = null; // Menyimpan ID yang sedang diedit dengan aman

        // CLOSE MODAL
        function closeModal() {
            $modalEdit.addClass('hidden');
            $('body').removeClass('overflow-hidden');
            $('#submitFormEditJurusan')[0].reset();
            $('.error').text('');
            $('.input-field').removeClass('border-red-500 focus:border-red-500');
        }

        $(document).on('click', '.modal-close-btn', function () {
            closeModal();
        });

        $(document).on('keydown', function (e) {
            if (e.key === 'Escape' && !$modalEdit.hasClass('hidden')) {
                closeModal();
            }
        });

        $('.input-field').on('input', function () {
            $(this).removeClass('border-red-500 focus:border-red-500');
            $(this).addClass('border-gray-300 focus:border-gray-400');
        });

        /*
        |--------------------------------------------------------------------------
        | ✏️ EDIT DATA JURUSAN - LOAD DATA
        |--------------------------------------------------------------------------
        */
        $(document).on('click', '.btn-edit', function () {
            currentEditId = $(this).data('id'); // Ambil ID langsung dari tombol

            Swal.fire({
                title: 'Mengambil data...',
                html: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => Swal.showLoading()
            });

            $.ajax({
                url: `/jurusan/${currentEditId}/edit`,
                type: 'GET',
                dataType: 'json',
                success: function (res) {
                    Swal.close();
                    const data = res.data;

                    // Buka Modal
                    $modalEdit.removeClass('hidden');
                    $('body').addClass('overflow-hidden');

                    // Set action form menggunakan ID yang sudah dikunci
                    const form = $('#submitFormEditJurusan');
                    form.attr('action', `/jurusan/${currentEditId}/update`);

                    // Isi form
                    form.find('input[name="js_nama"]').val(data.js_nama);
                    form.find('input[name="js_kode"]').val(data.js_kode);
                },
                error: function (xhr) {
                    Swal.fire('Error', 'Gagal mengambil data dari server', 'error');
                }
            });
        });

        /*
        |--------------------------------------------------------------------------
        | ✏️ UPDATE DATA JURUSAN - SIMPAN PERUBAHAN
        |--------------------------------------------------------------------------
        */
        $('#btnEditJurusan').on('click', function (e) {
            e.preventDefault();
            const form = $('#submitFormEditJurusan');
            const url = form.attr('action');
            const btn = $(this);

            $('.error').text('');
            $('.input-field').removeClass('border-red-500');
            btn.prop('disabled', true).text('Mengupdate...');

            $.ajax({
                url: url,
                method: 'POST', // Laravel membaca PUT lewat form
                data: form.serialize(),
                dataType: 'json', // PENTING: Untuk lolos cek expectsJson() di controller
                headers: {
                    'Accept': 'application/json' // PENTING: Untuk lolos cek expectsJson() di controller
                },
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    closeModal();
                    if (window.table) window.table.ajax.reload(null, false);
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        Object.keys(errors).forEach(function (key) {
                            $(`[data-error="${key}"]`).text(errors[key][0]);
                            $(`input[name="${key}"]`).addClass('border-red-500 focus:border-red-500');
                        });
                    } else {
                        Swal.fire('Oops...', 'Gagal update data. Terjadi kesalahan server.', 'error');
                    }
                },
                complete: function () {
                    btn.prop('disabled', false).text('Simpan');
                }
            });
        });
    });
</script>
@endpush
