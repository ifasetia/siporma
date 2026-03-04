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
                    <input name="name" placeholder="Masukkan nama lengkap"
                        class="form-input input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none">
                    <span class="error text-xs text-red-500" data-error="name"></span>
                </div>

                <div>
                    <label>Email</label>
                    <input name="email" placeholder="contoh@email.com"
                        class="form-input input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none">
                    <span class="error text-xs text-red-500" data-error="email"></span>
                </div>

                <div>
                    <label>No HP</label>
                    <input name="pr_no_hp" placeholder="08xxxxxxxxxx"
                        class="form-input input-field phone-input h-11 w-full rounded-lg border border-gray-300 px-4 text-sm">
                    <span class="error text-xs text-red-500" data-error="pr_no_hp"></span>
                </div>

                <div>
                    <label>Kampus</label>
                    <select name="pr_kampus_id"
                        class="form-input input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm">
                        <option value="">-- Pilih Kampus --</option>
                        @foreach($kampus as $k)
                        <option value="{{ $k->km_id }}">{{ $k->km_nama_kampus }}</option>
                        @endforeach
                    </select>
                    <span class="error text-xs text-red-500" data-error="pr_kampus_id"></span>
                </div>

                <div>
                    <label>Jurusan</label>
                    <select name="pr_jurusan_id"
                        class="form-input input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm">

                        <option value="">-- Pilih Jurusan --</option>

                        @foreach($jurusanList as $j)
                        <option value="{{ $j->js_id }}">
                            {{ $j->js_nama }}
                        </option>
                        @endforeach

                    </select>

                    <span class="error text-xs text-red-500" data-error="pr_jurusan_id"></span>
                </div>
                <div>
                    <label>Pekerjaan</label>
                    <select name="pr_pekerjaan_id"
                        class="form-input input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm">

                        <option value="">-- Pilih Pekerjaan --</option>

                        @foreach($pekerjaan as $p)
                        <option value="{{ $p->pk_id_pekerjaan }}">
                            {{ $p->pk_nama_pekerjaan }}
                        </option>
                        @endforeach

                    </select>

                    <span class="error text-xs text-red-500" data-error="pr_pekerjaan_id"></span>
                </div>

                <div>
                    <label>NIM</label>
                    <input name="pr_nim" placeholder="Masukkan NIM"
                        class="form-input input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm">
                    <span class="error text-xs text-red-500" data-error="pr_nim"></span>
                </div>

                <div>
                    <label>Jenis Kelamin</label>
                    <select name="pr_jenis_kelamin"
                        class="form-input input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm">
                        <option value="">Pilih</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                    <span class="error text-xs text-red-500" data-error="pr_jenis_kelamin"></span>
                </div>

                <div>
                    <label>Tanggal Lahir</label>
                    <input type="text" name="pr_tanggal_lahir"
                        class="form-input input-field date-input h-11 w-full rounded-lg border border-gray-300 px-4 text-sm"
                        placeholder="DD/MM/YYYY">
                    <span class="error text-xs text-red-500" data-error="pr_tanggal_lahir"></span>
                </div>

                <div>
                    <label>Alamat</label>
                    <textarea name="pr_alamat" placeholder="Alamat lengkap"
                        class="form-input input-field h-20 w-full rounded-lg border border-gray-300 px-4 text-sm"></textarea>
                    <span class="error text-xs text-red-500" data-error="pr_alamat"></span>
                </div>

                <div>
                    <label>Mulai Magang</label>
                    <input type="text" name="pr_internship_start"
                        class="form-input input-field date-input h-11 w-full rounded-lg border border-gray-300 px-4 text-sm"
                        placeholder="DD/MM/YYYY">
                    <span class="error text-xs text-red-500" data-error="pr_internship_start"></span>
                </div>

                <div>
                    <label>Selesai Magang</label>
                    <input type="text" name="pr_internship_end"
                        class="form-input input-field date-input h-11 w-full rounded-lg border border-gray-300 px-4 text-sm"
                        placeholder="DD/MM/YYYY">
                    <span class="error text-xs text-red-500" data-error="pr_internship_end"></span>
                </div>

                <div>
                    <label>Supervisor</label>
                    <select name="pr_supervisor_id"
                        class="form-input input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm">

                        <option value="">-- Pilih Supervisor --</option>

                        @foreach($supervisor as $j)
                        <option value="{{ $j->sp_id }}">
                            {{ $j->sp_nama }}
                        </option>
                        @endforeach

                    </select>

                    <span class="error text-xs text-red-500" data-error="pr_supervisor_id"></span>
                </div>


<div>
    <label class="block mb-2 text-sm font-medium text-gray-700">
        Status Akun
    </label>

    <label class="flex items-center gap-4 cursor-pointer relative">

        <!-- Checkbox -->
        <input type="checkbox"
               id="statusToggle"
               class="hidden">

        <!-- Track -->
        <div id="statusTrack"
             class="w-14 h-7 bg-red-500 rounded-full
                    transition-all duration-300 relative">

            <!-- Dot -->
            <div id="statusDot"
                 class="absolute top-1 left-1 w-5 h-5 bg-white rounded-full shadow
                        flex items-center justify-center
                        transition-all duration-300">

                <i id="statusIcon" class="fas fa-lock text-red-500 text-xs"></i>
            </div>
        </div>

        <!-- Text -->
        <span id="statusText"
              class="font-semibold text-red-600 transition-colors duration-300">
            Nonaktif
        </span>

        <!-- Hidden -->
        <input type="hidden"
               name="pr_status"
               id="statusValue">
    </label>
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
    // 1. Definisikan updateUI dulu
    function updateUI(isActive) {
        const toggle = document.getElementById('statusToggle');
        const dot    = document.getElementById('statusDot');
        const track  = document.getElementById('statusTrack');
        const text   = document.getElementById('statusText');
        const icon   = document.getElementById('statusIcon');
        const hidden = document.getElementById('statusValue');

        if (!toggle) return;

        toggle.checked = isActive;

        if (isActive) {
            track.classList.remove('bg-red-500');
            track.classList.add('bg-green-500');
            dot.style.transform   = "translateX(28px)";
            text.textContent      = 'Aktif';
            text.classList.remove('text-red-600');
            text.classList.add('text-green-600');
            icon.className        = 'fas fa-unlock text-green-500 text-xs';
            hidden.value          = 'aktif';
        } else {
            track.classList.remove('bg-green-500');
            track.classList.add('bg-red-500');
            dot.style.transform   = "translateX(0px)";
            text.textContent      = 'Nonaktif';
            text.classList.remove('text-green-600');
            text.classList.add('text-red-600');
            icon.className        = 'fas fa-lock text-red-500 text-xs';
            hidden.value          = 'nonaktif';
        }
    }

    // 2. Expose ke global
    window.updateStatusToggle = updateUI;

    // 3. Baru register event (pakai .off dulu!)
    $(document).off('click', '#statusTrack').on('click', '#statusTrack', function (e) {
        e.preventDefault();
        e.stopPropagation();
        const toggle = document.getElementById('statusToggle');
        updateUI(!toggle.checked);
    });





        document.addEventListener('input', function (e) {

            if (!e.target.classList.contains('date-input')) return;

            let v = e.target.value.replace(/\D/g, '');

            if (v.length >= 3) v = v.slice(0, 2) + '/' + v.slice(2);
            if (v.length >= 6) v = v.slice(0, 5) + '/' + v.slice(5, 9);

            e.target.value = v;
        });

        // ==========================
        // PHONE NUMBER ONLY
        // ==========================
        document.addEventListener('input', function (e) {

            if (!e.target.classList.contains('phone-input')) return;

            // hapus semua selain angka
            let v = e.target.value.replace(/\D/g, '');

            // limit max 13 digit (nomor hp Indonesia)
            v = v.slice(0, 13);

            e.target.value = v;
        });


        function formatTanggal(val) {
            if (!val) return '';
            const d = new Date(val);
            return ('0' + d.getDate()).slice(-2) + '/' +
                ('0' + (d.getMonth() + 1)).slice(-2) + '/' +
                d.getFullYear();
        }

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

            function dbToDisplay(val) {
                if (!val) return '';
                const p = val.split('-'); // yyyy-mm-dd
                return p[2] + '/' + p[1] + '/' + p[0];
            }

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

                    console.log(profile);


                    const form = $('#submitFormEditIntern');
                    form.attr('action', `/data-intern/${data.id}/update`);

                    form.find('input[name="name"]').val(data.name ?? '');
                    form.find('input[name="email"]').val(data.email ?? '');

                    form.find('input[name="pr_no_hp"]').val(profile.pr_no_hp ?? '');
                    form.find('input[name="pr_nim"]').val(profile.pr_nim ?? '');
                    form.find('select[name="pr_jurusan_id"]').val(profile.pr_js_id ?? '');
                    form.find('select[name="pr_pekerjaan_id"]').val(profile.pr_id_pekerjaan ?? '');
                    form.find('textarea[name="pr_alamat"]').val(profile.pr_alamat ?? '');
                    form.find('select[name="pr_kampus_id"]').val(profile.pr_km_id ??
                        '');
                    form.find('select[name="pr_jenis_kelamin"]').val(profile
                        .pr_jenis_kelamin ?? '');

                    form.find('input[name="pr_tanggal_lahir"]').val(dbToDisplay(profile
                        .pr_tanggal_lahir));
                    form.find('input[name="pr_internship_start"]').val(dbToDisplay(profile
                        .pr_internship_start));
                    form.find('input[name="pr_internship_end"]').val(dbToDisplay(profile
                        .pr_internship_end));

                    form.find('select[name="pr_supervisor_id"]').val(profile.pr_sp_id ?? '');


                    $('#internEditModal').removeClass('hidden');
                    $('body').addClass('overflow-hidden');

                    setTimeout(() => {
                        updateUI(profile.pr_status === 'aktif');
                    }, 50);
                    $('body').addClass('overflow-hidden');

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

        // ==========================
        // DELETE INTERN (SweetAlert)
        // ==========================
        $(document).on('click', '.btn-delete', function () {

            const id = $(this).data('id');
            const row = $(this).closest('tr');
            const name = row.find('td:eq(1)').text(); // kolom nama

            Swal.fire({
                icon: 'warning',
                title: 'Hapus Data',
                html: `Anda yakin ingin menghapus akun <b>${name}</b>?`,
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#dc2626',
            }).then((result) => {

                if (result.isConfirmed) {

                    Swal.fire({
                        title: 'Menghapus...',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => Swal.showLoading()
                    });

                    $.ajax({
                        url: `/data-intern/${id}`,
                        type: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (res) {

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: res.message,
                                timer: 1500,
                                showConfirmButton: false
                            });

                            window.table.ajax.reload(null, false);
                        },
                        error: function () {
                            Swal.fire('Error', 'Gagal menghapus data', 'error');
                        }
                    });

                }

            });

        });

        // $('#statusToggle').on('change', function () {

        //     const isActive = $(this).is(':checked');
        //     const hidden = $('input[name="pr_status"]');
        //     const name = $('input[name="name"]').val();

        //     const nextStatus = isActive ? 'aktif' : 'nonaktif';

        //     Swal.fire({
        //         icon: 'question',
        //         title: 'Konfirmasi',
        //         html: `Anda yakin ingin <b>${nextStatus === 'aktif' ? 'mengaktifkan' : 'menonaktifkan'}</b> akun <b>${name}</b>?`,
        //         showCancelButton: true,
        //         confirmButtonText: 'Ya, lanjutkan',
        //         cancelButtonText: 'Batal',
        //         confirmButtonColor: nextStatus === 'aktif' ? '#16a34a' : '#dc2626'
        //     }).then((result) => {

        //         if (result.isConfirmed) {
        //             hidden.val(nextStatus);

        //             $('#statusText').text(
        //                 nextStatus === 'aktif' ? 'Aktif' : 'Nonaktif'
        //             );

        //         } else {
        //             // balikkan toggle jika batal
        //             $(this).prop('checked', !isActive);
        //         }

        //     });

        // });


//         $(document).on('click', '#statusTrack', function () {

//     const toggle = document.getElementById('statusToggle');
//     const name = $('input[name="name"]').val();
//     const nextState = !toggle.checked;

//     const nextStatus = nextState ? 'aktif' : 'nonaktif';

//     Swal.fire({
//         icon: 'question',
//         title: 'Konfirmasi',
//         html: `Anda yakin ingin <b>${nextStatus === 'aktif' ? 'mengaktifkan' : 'menonaktifkan'}</b> akun <b>${name}</b>?`,
//         showCancelButton: true,
//         confirmButtonText: 'Ya, lanjutkan',
//         cancelButtonText: 'Batal',
//         confirmButtonColor: nextStatus === 'aktif' ? '#16a34a' : '#dc2626'
//     }).then((result) => {

//         if (result.isConfirmed) {
//             updateUI(nextState);
//         }

//     });

// });
    });

</script>
@endpush
