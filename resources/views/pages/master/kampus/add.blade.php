<!-- Modal -->
<div id="eventModal" class="fixed inset-0 z-999999 hidden p-5 overflow-y-auto" role="dialog" aria-modal="true">

    <!-- Overlay -->
    <div class="fixed inset-0 bg-gray-400/50 backdrop-blur-sm"></div>
    <div class="min-h-full flex items-center justify-center">
        <!-- Dialog -->
        <div class="relative w-full max-w-[700px] rounded-3xl bg-white p-6 lg:p-11 ">

            <!-- Close Button -->
            <button type="button"
                class="modal-close-btn absolute top-5 right-5 flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200 dark:bg-white/5">
                ✕
            </button>

            <form id="submitFormKampus" class="flex flex-col gap-6" action="{{ route('kampus-store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <!-- Header -->
                <div>
                    <h5 id="eventModalLabel" class="font-semibold text-gray-800 text-xl dark:text-white">
                        Tambah Data Kampus Mahasiswa
                    </h5>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Silahkan isi form berikut untuk menambahkan data kampus mahasiswa baru.
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

                    <button type="button" id="btnSimpanKampus"
                        class="w-24 bg-brand-500 hover:bg-brand-600 rounded-lg px-4 py-2 text-sm text-white disabled:bg-grey-400">
                        Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- INI LOADING --}}
<div id="loadingOverlay"
     class="fixed inset-0 bg-black/40 hidden items-center justify-center z-999999">
    <div class="bg-white px-6 py-4 rounded-lg shadow-lg flex items-center gap-3">
        <svg class="animate-spin h-10 w-10 text-gray-700"
             xmlns="http://www.w3.org/2000/svg"
             fill="none"
             viewBox="0 0 24 24">
            <circle class="opacity-25"
                    cx="12" cy="12" r="10"
                    stroke="currentColor"
                    stroke-width="4"></circle>
            <path class="opacity-75"
                  fill="currentColor"
                  d="M4 12a8 8 0 018-8v8H4z"></path>
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

        // fungsi untuk tampilkan loading
        function showLoading(){
            $('#loadingOverlay').removeClass('hidden').addClass('flex');
        }
        // fungsi untuk sembunyikan loading
        function hideLoading(){
            $('#loadingOverlay').removeClass('flex').addClass('hidden');
        }

        // MODAL HANDLER
        const $modal = $('#eventModal');
        // OPEN MODAL
        window.openModal = function () {
            $modal.removeClass('hidden');
            $('body').addClass('overflow-hidden');
            resetKampusForm();
        };

        // CLOSE MODAL
        function closeModal() {
            $modal.addClass('hidden');
            $('body').removeClass('overflow-hidden');
            resetKampusForm();
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


        function resetKampusForm(){
            const form = $('#submitFormKampus');
            form[0].reset();
            form.find('input[type=hidden]').val('');
            $('.error').text('');
        }



        // SIMPAN DATA KAMPUS
        $('#btnSimpanKampus').on('click', function (e) {
            e.preventDefault();
            const form = $('#submitFormKampus');
            const url = form.attr('action');
            const data = form.serialize();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const btn = form.find('button[id="btnSimpanKampus"]');
            btn.prop('disabled', true).text('Menyimpan...');
            showLoading();
            $.ajax({
                url: url,
                method: 'POST',
                data: data,
                success: function (response) {
                    if (response.success) {
                        closeModal();
                        resetKampusForm();
                        window.table.ajax.reload(null,false);
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        // reset error text
                        $('.error').text('');
                        // reset border merah dulu
                        $('.input-field')
                            .removeClass('border-red-500 focus:border-red-500');
                        Object.keys(errors).forEach(function (key) {
                            // tampilkan pesan error
                            $(`[data-error="${key}"]`).text(errors[key][0]);
                            // kasih border merah ke input
                            $(`[name="${key}"]`)
                                .addClass('border-red-500 focus:border-red-500');
                        });
                    }  else {
                        alert(xhr.responseJSON?.message || 'Terjadi kesalahan server');
                    }
                },
                complete: function () {
                    btn.prop('disabled', false).text('Simpan');
                    hideLoading();
                }
            });
        });


        $(document).on('click', '.btn-delete', function () {
            const id = $(this).data('id');
            if (!confirm('Yakin mau hapus data ini?')) return;
            $.ajax({
                url: `/kampus/${id}`,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                    alert(res.message);
                    // reload datatable tanpa refresh halaman
                    $('#tableKampus').DataTable().ajax.reload(null, false);
                },
                error: function () {
                    alert('Gagal menghapus data');
                }
            });
        });

    });

</script>
@endpush
