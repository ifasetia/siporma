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

            <form id="submitFormEditKampus" class="flex flex-col gap-6" action="" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!-- Header -->
                <div>
                    <h5 id="eventEditModalLabel" class="font-semibold text-gray-800 text-xl dark:text-white">
                        Edit Data Kampus Mahasiswa
                    </h5>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Silahkan isi form berikut untuk mengedit data kampus mahasiswa.
                    </p>
                </div>

                <!-- Nama Kampus -->
                <div>
                    <label class="block text-sm font-medium mb-1">Nama Kampus</label>
                    <input id="event-title" type="text"
                        class="form-input input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none fokus:border-none"
                        placeholder="Inputkan nama kampus..." name="km_nama_kampus">
                    <span class="text-red-500 text-xs error" data-error="km_nama_kampus"></span>
                </div>
                <!-- Nama Kampus -->
                <div>
                    <label class="block text-sm font-medium mb-1">Kode Kampus</label>
                    <input id="event-code" type="text"
                        class="form-input input-field h-11 w-full rounded-lg border border-gray-300  px-4 text-sm focus:ring-2 focus:outline-none "
                        placeholder="Inputkan kode kampus..." name="km_kode_kampus">
                    <span class="text-red-500 text-xs error" data-error="km_kode_kampus"></span>
                </div>
                <!-- Email Kampus -->
                <div>
                    <label class="block text-sm font-medium mb-1">Email Kampus</label>
                    <input id="event-email" type="email"
                        class="form-input input-field h-11 w-full rounded-lg border border-gray-300  px-4 text-sm focus:ring-2 focus:outline-none "
                        placeholder="Inputkan email kampus..." name="km_email_kampus">
                    <span class="text-red-500 text-xs error" data-error="km_email_kampus"></span>
                </div>
                <!-- Alamat Kampus -->
                <div>
                    <label class="block text-sm font-medium mb-1">Alamat Kampus</label>
                    <textarea id="event-address"
                        class="form-input input-field h-24 w-full rounded-lg border border-gray-300  px-4 py-2 text-sm focus:ring-2 focus:outline-none "
                        placeholder="Inputkan alamat kampus..." name="km_alamat_kampus"></textarea>
                    <span class="text-red-500 text-xs error" data-error="km_alamat_kampus"></span>
                </div>
                <!-- NoT Kampus -->
                <div>
                    <label class="block text-sm font-medium mb-1">Telepon Kampus</label>
                    <input id="event-phone" type="number"
                        class="form-input input-field h-11 w-full rounded-lg border border-gray-300  px-4 text-sm focus:ring-2 focus:outline-none "
                        placeholder="Inputkan no. telepon kampus..." name="km_telepon">
                    <span class="text-red-500 text-xs error" data-error="km_telepon"></span>
                </div>

                <!-- Footer -->
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button"
                        class="modal-close-btn w-24 rounded-lg border px-4 py-2 text-sm bg-red-500 text-white hover:bg-red-600">
                        Tutup
                    </button>

                    <button type="button" id="btnEditKampus"
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

        if (!window.$) {
            console.error('jQuery NOT loaded');
            return;
        }
        // MODAL HANDLER
        const $modalEdit = $('#eventEditModal');
        // OPEN MODAL
        window.openModal = function () {
            $modalEdit.removeClass('hidden');
            $('body').addClass('overflow-hidden');
        };
        // CLOSE MODAL
        function closeModal() {
            $modalEdit.addClass('hidden');
            $('body').removeClass('overflow-hidden');
            resetKampusEditForm();
        }
        // CLOSE BUTTON & OVERLAY
        $(document).on('click', '.modal-close-btn', function () {
            closeModal();
        });
        // ESC KEY CLOSE
        $(document).on('keydown', function (e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
        $('#eventEditModal .modal-dialog').on('click', function (e) {
            e.stopPropagation();
        });

        // SAAT MERAH KLIK HILANKAN MERAHNYA
        $('.input-field').on('input', function () {
            $(this).removeClass('border-red-500 focus:border-red-500');
            $(this).addClass('border-gray-300 focus:border-gray-400');
        });


        function resetKampusEditForm() {
            const form = $('#submitFormEditKampus');
            form[0].reset();
            form.find('input[type=hidden]').val('');
            $('.error').text('');
        }




        /*
        |--------------------------------------------------------------------------
        | ✏️ EDIT DATA KAMPUS - LOAD DATA + FULL SWEETALERT LOADING
        |--------------------------------------------------------------------------
        */

        $(document).on('click', '.btn-edit', function () {
            const id = $(this).data('id');
            /*
            |--------------------------------------------------------------------------
            | SWEETALERT LOADING FETCH DATA
            |--------------------------------------------------------------------------
            */
            Swal.fire({
                title: 'Mengambil data...',
                html: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            /*
            |--------------------------------------------------------------------------
            | AJAX GET DATA
            |--------------------------------------------------------------------------
            */
            $.ajax({
                url: `/kampus/${id}/edit`,
                type: 'GET',
                success: function (res) {
                    Swal.close(); // tutup loading
                    openEditModal(res.data);
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal mengambil data',
                        text: xhr.responseJSON ?.message ||
                            'Terjadi kesalahan server'
                    });
                }
            });
        });


        function openEditModal(data) {
            $modalEdit.removeClass('hidden');
            $('body').addClass('overflow-hidden');
            // Set form action to update route
            const form = $('#submitFormEditKampus');
            form.attr('action', `/kampus/${data.km_id}/update`);
            // Fill form fields with existing data
            form.find('input[name="km_nama_kampus"]').val(data.km_nama_kampus);
            form.find('input[name="km_kode_kampus"]').val(data.km_kode_kampus);
            form.find('input[name="km_email_kampus"]').val(data.km_email);
            form.find('textarea[name="km_alamat_kampus"]').val(data.km_alamat);
            form.find('input[name="km_telepon"]').val(data.km_telepon);
        }


        /*
        |--------------------------------------------------------------------------
        | ✏️ UPDATE DATA KAMPUS
        |--------------------------------------------------------------------------
        */
        $('#btnEditKampus').on('click', function (e) {
            e.preventDefault();
            const form = $('#submitFormEditKampus');
            const url = form.attr('action');
            const btn = $(this);
            $('.error').text('');
            $('.input-field').removeClass('border-red-500');
            btn.prop('disabled', true).text('Mengupdate...');
            Swal.fire({
                title: 'Mengupdate data...',
                text: 'Mohon tunggu sebentar',
                icon: 'info',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => Swal.showLoading()
            });
            $.ajax({
                url: url,
                method: 'POST',
                data: form.serialize(),
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    closeModal();
                    window.table.ajax.reload(null, false);
                },
                error: function (xhr) {
                    Swal.close();
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        Object.keys(errors).forEach(function (key) {
                            $(`[data-error="${key}"]`).text(errors[key][0]);
                            $(`[name="${key}"]`)
                                .addClass('border-red-500');
                        });
                        return;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Gagal update data'
                    });
                },
                complete: function () {
                    btn.prop('disabled', false).text('Simpan');
                }
            });
        });
    });

</script>
@endpush
