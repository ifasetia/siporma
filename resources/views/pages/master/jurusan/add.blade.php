<!-- Modal -->
<div id="eventModal" class="fixed inset-0 z-999999 hidden p-5 overflow-y-auto" role="dialog" aria-modal="true">

    <!-- Overlay -->
    <div class="fixed inset-0 bg-gray-400/50 backdrop-blur-sm"></div>
    <div class="min-h-full flex items-center justify-center">
        <!-- Dialog -->
        <div class="relative w-full max-w-[700px] rounded-3xl bg-white p-6 lg:p-11 ">

            <!-- Close Button -->
            <button type="button"
                class="modal-add-close-btn absolute top-5 right-5 flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200 dark:bg-white/5">
                ✕
            </button>
            <form id="submitFormJurusan" class="flex flex-col gap-6" action="{{ route('jurusan.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <!-- Header -->
                <div>
                    <h5 id="eventModalLabel" class="font-semibold text-gray-800 text-xl dark:text-white">
                        Tambah Data Jurusan
                    </h5>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Silahkan isi form berikut untuk menambahkan data jurusan mahasiswa baru.
                    </p>
                </div>

                <!-- Nama Jurusan -->
                <div>
                    <label class="block text-sm font-medium mb-1">Nama Jurusan</label>
                    <input id="event-title" type="text"
                        class="form-input input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none fokus:border-none"
                        placeholder="Inputkan nama jurusan..." name="js_nama">
                    <span class="text-red-500 text-xs error" data-error="js_nama"></span>
                </div>
                <!-- Nama Jurusan-->
                <div>
                    <label class="block text-sm font-medium mb-1">Kode Jurusan</label>
                    <input id="event-code" type="text"
                        class="form-input input-field h-11 w-full rounded-lg border border-gray-300  px-4 text-sm focus:ring-2 focus:outline-none "
                        placeholder="Inputkan kode jurusan..." name="js_kode">
                    <span class="text-red-500 text-xs error" data-error="js_kode"></span>
                </div>
                {{-- <!-- Email Kampus -->
                <div>
                    <label class="block text-sm font-medium mb-1">Email Jurusan</label>
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
                </div> --}}

                <!-- Footer -->
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button"
                        class="modal-add-close-btn w-24 rounded-lg border px-4 py-2 text-sm bg-red-500 text-white hover:bg-red-600">
                        Tutup
                    </button>

                    <button type="button" id="btnSaveJurusan" class="w-24 bg-brand-500 hover:bg-brand-600 rounded-lg px-4 py-2 text-sm text-white disabled:bg-grey-400">
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

{{-- @push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        if (!window.$) {
            console.error('jQuery NOT loaded');
            return;
        }

        // MODAL HANDLER
        const $modal = $('#eventModal');
        // OPEN MODAL
        window.openModal = function () {
            $modal.removeClass('hidden');
            $('body').addClass('overflow-hidden');
            resetJurusanForm();
        };

        // CLOSE MODAL
        function closeModal() {
            $modal.addClass('hidden');
            $('body').removeClass('overflow-hidden');
            resetJurusanForm();
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

        $('#eventModal .modal-dialog').on('click', function (e) {
            e.stopPropagation();
        });

        $('#btnOpen').on('click', openModal);

        // SAAT MERAH KLIK HILANKAN MERAHNYA
        $('.input-field').on('input', function () {
            $(this).removeClass('border-red-500 focus:border-red-500');
            $(this).addClass('border-gray-300 focus:border-gray-400');
        });


        function resetJurusanForm() {
            const form = $('#submitFormKampus');
            form[0].reset();
            form.find('input[type=hidden]').val('');
            $('.error').text('');
        }


        /*
        |--------------------------------------------------------------------------
        | ➕ ADD DATA Jurusan
        |--------------------------------------------------------------------------
        | Flow:
        | 1. Klik tombol simpan
        | 2. Validasi form
        | 3. SweetAlert loading
        | 4. AJAX POST
        | 5. Reload DataTables
        |--------------------------------------------------------------------------
        */
        $('#btnSimpanJurusan').on('click', function (e) {
            e.preventDefault();
            const form = $('#submitFormJurusan');
            const url = form.attr('action');
            const data = form.serialize();
            const btn = $(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // reset error dulu
            $('.error').text('');
            $('.input-field').removeClass('border-red-500 focus:border-red-500');
            btn.prop('disabled', true).text('Menyimpan...');
            // SWEETALERT LOADING
            Swal.fire({
                title: 'Menyimpan data...',
                text: 'Mohon tunggu sebentar',
                icon: 'info',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            $.ajax({
                url: url,
                method: 'POST',
                data: data,
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message || 'Data berhasil disimpan',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        closeModal();
                        resetJurusanForm();
                        window.table.ajax.reload(null, false);
                    }
                },
                error: function (xhr) {
                    Swal.close(); // tutup loading dulu
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        Object.keys(errors).forEach(function (key) {
                            $(`[data-error="${key}"]`).text(errors[key][0]);
                            $(`[name="${key}"]`)
                                .addClass('border-red-500 focus:border-red-500');
                        });
                        return;
                    }
                    let message = 'Terjadi kesalahan server';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: message
                    });
                },
                complete: function () {
                    btn.prop('disabled', false).text('Simpan');
                }
            });
        });



        /*
        |--------------------------------------------------------------------------
        | 🗑️ DELETE DATA JURUSAN
        |--------------------------------------------------------------------------
        | Flow:
        | 1. Klik tombol delete
        | 2. Konfirmasi SweetAlert
        | 3. Loading SweetAlert
        | 4. AJAX DELETE
        | 5. Reload DataTables
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
                if (!result.isConfirmed) return;
                Swal.fire({
                    title: 'Menyimpan data...',
                    text: 'Mohon tunggu sebentar',
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: `/jurusan/${id}`,
                    type: 'DELETE',
                    data: {
                        _token: token
                    },

                    success: function (res) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                        window.table.ajax.reload(null, false);
                    },
                    error: function (xhr) {
                        let message = 'Gagal menghapus data';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: message
                        });
                    }
                });
            });
        });
    });

</script>
@endpush --}}
