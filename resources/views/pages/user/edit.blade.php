<!-- Modal -->
<div id="eventEditModal" class="fixed inset-0 z-999999 hidden p-5 overflow-y-auto" role="dialog" aria-modal="true">

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

            <form id="submitFormEditUser" class="flex flex-col gap-6" action="" method="POST"
                enctype="multipart/form-data">
                @csrf
                <!-- Header -->
                <div>
                    <h5 id="eventEditModalLabel" class="font-semibold text-gray-800 text-xl dark:text-white">
                        Edit Data User
                    </h5>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Silahkan isi form berikut untuk mengedit data User
                </div>

                <!-- Nama User -->
                <div>
                    <label class="block text-sm font-medium mb-1">Nama User</label>
                    <input id="event-title" type="text"
                        class="form-input input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none fokus:border-none"
                        placeholder="Inputkan nama User..." name="name">
                    <span class="text-red-500 text-xs error" data-error="name"></span>
                </div>
                {{-- <!-- Nama User -->
                <div>
                    <label class="block text-sm font-medium mb-1">Kode Kampus</label>
                    <input id="event-code" type="text"
                        class="form-input input-field h-11 w-full rounded-lg border border-gray-300  px-4 text-sm focus:ring-2 focus:outline-none "
                        placeholder="Inputkan kode kampus..." name="km_kode_kampus">
                    <span class="text-red-500 text-xs error" data-error="km_kode_kampus"></span>
                </div>
                <!-- Email User --> --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input id="event-email" type="email"
                        class="form-input input-field h-11 w-full rounded-lg border border-gray-300  px-4 text-sm focus:ring-2 focus:outline-none "
                        placeholder="Inputkan email User..." name="email">
                    <span class="text-red-500 text-xs error" data-error="email"></span>
                </div>

            {{-- role --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Role</label>
                    <select name="role"
                        class="form-input input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none">

                        <option value="">-- Pilih Role --</option>
                        <option value="intern">Intern</option>
                        <option value="admin">Admin</option>

                    </select>
                    <span class="text-red-500 text-xs error" data-error="role"></span>
                </div>
                <!-- Alamat User-->
                {{-- <div>
                    <label class="block text-sm font-medium mb-1">Alamat User</label>
                    <textarea id="event-address"
                        class="form-input input-field h-24 w-full rounded-lg border border-gray-300  px-4 py-2 text-sm focus:ring-2 focus:outline-none "
                        placeholder="Inputkan alamat User..." name="km_alamat_kampus"></textarea>
                    <span class="text-red-500 text-xs error" data-error="km_alamat_kampus"></span>
                </div> --}}
                <!-- NoT Kampus -->
                {{-- <div>
                    <label class="block text-sm font-medium mb-1">Telepon Kampus</label>
                    <input id="event-phone" type="number"
                        class="form-input input-field h-11 w-full rounded-lg border border-gray-300  px-4 text-sm focus:ring-2 focus:outline-none "
                        placeholder="Inputkan no. telepon kampus..." name="km_telepon">
                    <span class="text-red-500 text-xs error" data-error="km_telepon"></span>
                </div> --}}

                <!-- Footer -->
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button"
                        class="modal-close-btn w-24 rounded-lg border px-4 py-2 text-sm bg-red-500 text-white hover:bg-red-600">
                        Tutup
                    </button>

                    <button type="button" id="btnEditUser"
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

    const $modalEdit = $('#eventEditModal');

    function closeModal() {
        $modalEdit.addClass('hidden');
        $('body').removeClass('overflow-hidden');
        resetUserEditForm();
    }

    function resetUserEditForm() {
        const form = $('#submitFormEditUser');
        form[0].reset();
        $('.error').text('');
        $('.input-field').removeClass('border-red-500');
    }

    $(document).on('click', '.modal-close-btn', function () {
        closeModal();
    });

    // ==========================
    // EDIT USER (LOAD DATA)
    // ==========================
    $(document).on('click', '.btn-edit', function () {
        const id = $(this).data('id');

        Swal.fire({
            title: 'Mengambil data...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => Swal.showLoading()
        });

        $.ajax({
            url: `/user/${id}/edit`,
            type: 'GET',
            success: function (res) {
                Swal.close();

                const data = res.data;
                const form = $('#submitFormEditUser');

                form.attr('action', `/user/${data.id}/update`);
                form.find('input[name="name"]').val(data.name);
                form.find('input[name="email"]').val(data.email);
                form.find('select[name="role"]').val(data.role);

                $modalEdit.removeClass('hidden');
                $('body').addClass('overflow-hidden');
            },
            error: function (xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal mengambil data',
                    text: xhr.responseJSON?.message || 'Terjadi kesalahan server'
                });
            }
        });
    });

    // ==========================
    // UPDATE USER
    // ==========================
    $('#btnEditUser').on('click', function (e) {
        e.preventDefault();

        const form = $('#submitFormEditUser');
        const url = form.attr('action');
        const btn = $(this);

        $('.error').text('');
        $('.input-field').removeClass('border-red-500');

        btn.prop('disabled', true).text('Menyimpan...');

        Swal.fire({
            title: 'Menyimpan perubahan...',
            text: 'Mohon tunggu sebentar',
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
                        $(`[name="${key}"]`).addClass('border-red-500');
                    });

                    return;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Gagal update data user'
                });
            },
            complete: function () {
                btn.prop('disabled', false).text('Simpan');
            }
        });
    });

    // ==========================
    // DELETE USER
    // ==========================
    $(document).on('click','.btn-delete',function(){

    const id = $(this).data('id');
    const row = $(this).closest('tr');
    const name = row.find('td:eq(1)').text();

    Swal.fire({
        icon:'warning',
        title:'Hapus Permanen',
        html:`Anda yakin ingin menghapus permanen akun <b>${name}</b>?`,
        showCancelButton:true,
        confirmButtonText:'Ya, hapus',
        cancelButtonText:'Batal',
        confirmButtonColor:'#dc2626'
    }).then((res)=>{

        if(res.isConfirmed){

            Swal.fire({
                title:'Menghapus...',
                allowOutsideClick:false,
                showConfirmButton:false,
                didOpen:()=>Swal.showLoading()
            });

            $.post(`/user/${id}/delete`,{
                _token:$('meta[name="csrf-token"]').attr('content')
            },function(resp){

                Swal.fire({
                    icon:'success',
                    title:'Berhasil',
                    text:resp.message,
                    timer:1200,
                    showConfirmButton:false
                });

                window.table.ajax.reload(null,false);

            });

        }

    });

});
});
</script>
