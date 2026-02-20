<!-- MODAL EDIT INTERN -->
<div id="internEditModal" class="fixed inset-0 z-999999 hidden p-5 overflow-y-auto" role="dialog" aria-modal="true">

    <!-- Overlay -->
    <div class="fixed inset-0 bg-gray-400/50 backdrop-blur-sm"></div>

    <div class="min-h-full flex items-center justify-center">

        <div class="relative w-full max-w-[700px] rounded-3xl bg-white p-6 lg:p-11">

            <!-- Close Button -->
            <button type="button"
                class="modal-close absolute top-5 right-5 flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200">
                ✕
            </button>

            <form id="submitFormEditIntern" class="flex flex-col gap-4" action="" method="POST">
@csrf

            <!-- Header -->
            <div>
                <h5 class="font-semibold text-gray-800 text-xl">Edit Data Intern</h5>
                <p class="text-sm text-gray-500">Silahkan edit data intern berikut.</p>
            </div>


<!-- USER -->
<input type="hidden" name="user_id">

<div>
<label>Nama</label>
<input name="name" class="form-input input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none"
>
<span class="error text-xs text-red-500" data-error="name"></span>
</div>

<div>
<label>Email</label>
<input name="email" class="form-input input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none"
>
<span class="error text-xs text-red-500" data-error="email"></span>
</div>

<!-- PROFILE -->
<div>
<label>No HP</label>
<input name="pr_no_hp" class="form-input input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none">
</div>

<!-- KAMPUS -->
<div>
<label>Kampus</label>
<select name="pr_kampus_id" class="form-input input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none">
<option value="">-- Pilih Kampus --</option>
@foreach($kampus as $k)
<option value="{{ $k->km_id }}">{{ $k->km_nama_kampus }}</option>
@endforeach
</select>
</div>


<div>
<label>Jurusan</label>
<input name="pr_jurusan" class="form-input input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none">
</div>

<div>
<label>NIM</label>
<input name="pr_nim" class="form-input input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none"
>
</div>


<div>
<label>Jenis Kelamin</label>
<select name="pr_jenis_kelamin" class="form-input input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none">
<option value="">Pilih</option>
<option value="Laki-laki">Laki-laki</option>
<option value="Perempuan">Perempuan</option>
</select>
</div>

<div>
<label>Tanggal Lahir</label>
<input type="date" name="pr_tanggal_lahir" class="form-input input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none">
</div>

<div>
<label>Alamat</label>
<textarea name="pr_alamat" class="form-input input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none"></textarea>
</div>


<div>
<label>Mulai Magang</label>
<input type="date" name="pr_internship_start" class="form-input input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none">
</div>

<div>
<label>Selesai Magang</label>
<input type="date" name="pr_internship_end" class="form-input input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none">
</div>

<div>
<label>Nama Supervisor</label>
<input name="pr_supervisor_name" class="form-input input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none">
</div>

<div>
<label>Kontak Supervisor</label>
<input name="pr_supervisor_contact" class="form-input input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none">
</div>

<div>
<label class="block mb-2 text-sm font-medium text-gray-700">
    Status Akun
</label>

<div class="flex items-center gap-4">

    <div id="toggleTrack"
         class="w-14 h-7 bg-red-500 rounded-full relative cursor-pointer transition">

        <div id="toggleDot"
             class="absolute top-1 left-1 w-5 h-5 bg-white rounded-full shadow transition-all duration-200">
        </div>

    </div>

    <span id="statusText"
          class="font-semibold text-red-600">
        Nonaktif
    </span>

    <input type="hidden" name="pr_status" value="nonaktif">
</div>
</div>




                <!-- Footer -->
                <div class="flex justify-end gap-3 pt-4">

                    <button type="button"
                        class="modal-close w-24 rounded-lg bg-red-500 text-white px-4 py-2 text-sm hover:bg-red-600">
                        Tutup
                    </button>

                    <button type="button" id="btnEditIntern"
                        class="w-24 bg-brand-500 hover:bg-brand-600 rounded-lg px-4 py-2 text-sm text-white">
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

    const $modalEdit = $('#internEditModal');

    function closeModal() {
        $modalEdit.addClass('hidden');
        $('body').removeClass('overflow-hidden');
        resetInternEditForm();
    }

    function resetInternEditForm() {
        const form = $('#submitFormEditIntern');
        form[0].reset();
        $('.error').text('');
        $('.input-field').removeClass('border-red-500');
    }

    $(document).on('click', '.modal-close', closeModal);

    // ==========================
    // EDIT INTERN (LOAD DATA)
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
            url: `/data-intern/${id}/edit`,
            type: 'GET',
            success: function (res) {

                Swal.close();

                const data = res.data;
                const profile = data.profile ?? {};

                const form = $('#submitFormEditIntern');
                form.attr('action', `/data-intern/${data.id}/update`);

                form.find('input[name="name"]').val(data.name ?? '');
                form.find('input[name="email"]').val(data.email ?? '');

                form.find('input[name="pr_no_hp"]').val(profile.pr_no_hp ?? '');
                form.find('input[name="pr_nim"]').val(profile.pr_nim ?? '');
                form.find('input[name="pr_jurusan"]').val(profile.pr_jurusan ?? '');
                form.find('textarea[name="pr_alamat"]').val(profile.pr_alamat ?? '');
                form.find('select[name="pr_kampus_id"]').val(profile.pr_kampus_id ?? '');
                form.find('select[name="pr_jenis_kelamin"]').val(profile.pr_jenis_kelamin ?? '');

                form.find('input[name="pr_internship_start"]').val(profile.pr_internship_start ?? '');
                form.find('input[name="pr_internship_end"]').val(profile.pr_internship_end ?? '');
                form.find('input[name="pr_supervisor_name"]').val(profile.pr_supervisor_name ?? '');
                form.find('input[name="pr_supervisor_contact"]').val(profile.pr_supervisor_contact ?? '');

                setStatus(profile.pr_status ?? 'nonaktif');

                $('#internEditModal').removeClass('hidden');
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
    // UPDATE INTERN
    // ==========================
    $('#btnEditIntern').on('click', function (e) {

        e.preventDefault();

        const form = $('#submitFormEditIntern');
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
                    text: 'Gagal update data intern'
                });
            },
            complete: function () {
                btn.prop('disabled', false).text('Simpan');
            }
        });

    });

    const track = $('#toggleTrack');
const dot = $('#toggleDot');
const text = $('#statusText');
const hidden = $('input[name="pr_status"]');
const nameInput = $('input[name="name"]');

function setStatus(status){

    if(status === 'aktif'){
        track.removeClass('bg-red-500').addClass('bg-green-500');
        dot.css('left','30px');
        text.text('Aktif')
            .removeClass('text-red-600')
            .addClass('text-green-600');
        hidden.val('aktif');
    }else{
        track.removeClass('bg-green-500').addClass('bg-red-500');
        dot.css('left','4px');
        text.text('Nonaktif')
            .removeClass('text-green-600')
            .addClass('text-red-600');
        hidden.val('nonaktif');
    }
}

track.on('click', function(){

    const current = hidden.val();
    const next = current === 'aktif' ? 'nonaktif' : 'aktif';
    const internName = nameInput.val();

    Swal.fire({
        icon: 'question',
        title: `Anda yakin?`,
        html: `Anda yakin ingin <b>${next === 'aktif' ? 'mengaktifkan' : 'menonaktifkan'}</b> akun <b>${internName}</b>?`,
        showCancelButton: true,
        confirmButtonText: 'Ya, lanjutkan',
        cancelButtonText: 'Batal',
        confirmButtonColor: next === 'aktif' ? '#16a34a' : '#dc2626'
    }).then((result) => {

        if(result.isConfirmed){
            setStatus(next);
        }

    });

});



});


</script>
@endpush
