<!-- Modal -->
<div id="eventModal" class="fixed inset-0 z-999999 hidden p-5 overflow-y-auto" role="dialog" aria-modal="true">

    <div class="fixed inset-0 bg-gray-400/50 backdrop-blur-sm"></div>

    <div class="min-h-full flex items-center justify-center">
        <div class="relative w-full max-w-[700px] rounded-3xl bg-white p-6 lg:p-11">

            <button type="button"
                class="modal-close-btn absolute top-5 right-5 flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200">
                ✕
            </button>

            <form id="submitFormIntern" class="flex flex-col gap-6" action="{{ route('data-intern.store') }}" method="POST">
                @csrf

                <!-- Header -->
                <div>
                    <h5 class="font-semibold text-gray-800 text-xl">Tambah Data Intern</h5>
                    <p class="text-sm text-gray-500">Silahkan isi form berikut untuk menambahkan intern.</p>
                </div>

                <!-- Nama -->
                <div>
                    <label class="block text-sm font-medium mb-1">Nama</label>
                    <input type="text" name="pr_nama"
                        class="input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none"
                        placeholder="Inputkan nama intern...">
                    <span class="text-red-500 text-xs error" data-error="pr_nama"></span>
                </div>

                <!-- No HP -->
                <div>
                    <label class="block text-sm font-medium mb-1">No HP</label>
                    <input name="pr_no_hp"
                        class="input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none"
                        placeholder="Inputkan nomor HP...">
                    <span class="text-red-500 text-xs error" data-error="pr_no_hp"></span>
                </div>

                <!-- Alamat -->
                <div>
                    <label class="block text-sm font-medium mb-1">Alamat</label>
                    <textarea name="pr_alamat"
                        class="input-field h-24 w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:ring-2 focus:outline-none"
                        placeholder="Inputkan alamat..."></textarea>
                    <span class="text-red-500 text-xs error" data-error="pr_alamat"></span>
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label class="block text-sm font-medium mb-1">Jenis Kelamin</label>
                    <select name="pr_jenis_kelamin"
                        class="input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none">
                        <option value="">-- Pilih --</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                    <span class="text-red-500 text-xs error" data-error="pr_jenis_kelamin"></span>
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label class="block text-sm font-medium mb-1">Tanggal Lahir</label>
                    <input type="date" name="pr_tanggal_lahir"
                        class="input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none">
                    <span class="text-red-500 text-xs error" data-error="pr_tanggal_lahir"></span>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium mb-1">Status</label>
                    <input name="pr_status"
                        class="input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none"
                        placeholder="Status intern...">
                    <span class="text-red-500 text-xs error" data-error="pr_status"></span>
                </div>

                <!-- NIM -->
                <div>
                    <label class="block text-sm font-medium mb-1">NIM</label>
                    <input name="pr_nim"
                        class="input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none"
                        placeholder="Inputkan NIM...">
                    <span class="text-red-500 text-xs error" data-error="pr_nim"></span>
                </div>

                <!-- Kampus -->
                 <div>
                 <label class="block text-sm font-medium mb-1">Kampus</label>
                <select name="pr_kampus_id"
                class="input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none">

                <option value="">-- Pilih Kampus --</option>

                @foreach($kampus as $k)
                <option value="{{ $k->km_id }}">
                {{ $k->km_nama_kampus }}
                </option>
                @endforeach

                </select>
                 </div>

                <!-- Jurusan -->
                <div>
                    <label class="block text-sm font-medium mb-1">Jurusan</label>
                    <input name="pr_jurusan"
                        class="input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none"
                        placeholder="Inputkan jurusan...">
                    <span class="text-red-500 text-xs error" data-error="pr_jurusan"></span>
                </div>

                <!-- Mulai -->
                <div>
                    <label class="block text-sm font-medium mb-1">Mulai Internship</label>
                    <input type="date" name="pr_internship_start"
                        class="input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none">
                    <span class="text-red-500 text-xs error" data-error="pr_internship_start"></span>
                </div>

                <!-- Selesai -->
                <div>
                    <label class="block text-sm font-medium mb-1">Selesai Internship</label>
                    <input type="date" name="pr_internship_end"
                        class="input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none">
                    <span class="text-red-500 text-xs error" data-error="pr_internship_end"></span>
                </div>

                <!-- Supervisor -->
                <div>
                    <label class="block text-sm font-medium mb-1">Nama Supervisor</label>
                    <input name="pr_supervisor_name"
                        class="input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none"
                        placeholder="Nama supervisor...">
                    <span class="text-red-500 text-xs error" data-error="pr_supervisor_name"></span>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Kontak Supervisor</label>
                    <input name="pr_supervisor_contact"
                        class="input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none"
                        placeholder="Kontak supervisor...">
                    <span class="text-red-500 text-xs error" data-error="pr_supervisor_contact"></span>
                </div>

                <!-- Footer -->
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button"
                        class="modal-close-btn w-24 rounded-lg bg-red-500 text-white px-4 py-2 text-sm hover:bg-red-600">
                        Tutup
                    </button>

                    <button type="button" id="btnSimpanIntern"
                        class="w-24 bg-blue-600 hover:bg-blue-700 rounded-lg px-4 py-2 text-sm text-white">
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

    const $modal = $('#eventModal');

    window.openModal = function () {
        $modal.removeClass('hidden');
        $('body').addClass('overflow-hidden');
        resetInternForm();
    };

    function closeModal() {
        $modal.addClass('hidden');
        $('body').removeClass('overflow-hidden');
        resetInternForm();
    }

    $(document).on('click', '.modal-close-btn', closeModal);

    $('#btnOpen').on('click', openModal);

    function resetInternForm() {
        const form = $('#submitFormIntern');
        form[0].reset();
        $('.error').text('');
        $('.input-field').removeClass('border-red-500');
    }

    $('#btnSimpanIntern').on('click', function (e) {
        e.preventDefault();

        const form = $('#submitFormIntern');
        const url = form.attr('action');
        const data = form.serialize();
        const btn = $(this);

        $('.error').text('');
        btn.prop('disabled', true).text('Menyimpan...');

        Swal.fire({
            title: 'Menyimpan data...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: function (res) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: res.message,
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
                    Object.keys(errors).forEach(key => {
                        $(`[data-error="${key}"]`).text(errors[key][0]);
                        $(`[name="${key}"]`).addClass('border-red-500');
                    });
                    return;
                }
                Swal.fire('Error', 'Terjadi kesalahan', 'error');
            },
            complete: function () {
                btn.prop('disabled', false).text('Simpan');
            }
        });
    });

});
</script>
@endpush
