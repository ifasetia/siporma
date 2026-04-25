<!-- DETAIL MODAL PROJECT -->
<div id="detailModal" class="fixed inset-0 z-999999 hidden p-5 overflow-y-auto">
    <div id="photoPreviewModal" class="fixed inset-0 z-[999999] hidden bg-black/60 flex items-center justify-center">
        <img id="previewImg" class="max-h-[90vh] rounded-xl shadow-xl">
    </div>

    <div class="fixed inset-0 bg-gray-400/50 backdrop-blur-sm"></div>

    <div class="min-h-full flex items-center justify-center">
        <div class="relative w-full max-w-[700px] rounded-3xl bg-white p-6 lg:p-11">

            <button type="button"
                class="close-detail absolute top-5 right-5 flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200">
                ✕
            </button>



            <!-- HEADER -->
            <div>
                <h5 class="font-semibold text-gray-800 text-xl">Detail Project</h5>
                <p class="text-sm text-gray-500">Informasi lengkap data project.</p>
            </div>

            <!-- CONTENT -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 mt-6 text-sm">

                <!-- ================= LEFT ================= -->
                <div class="space-y-6">

                    <div>
                        <label class="block font-medium text-gray-500">Judul Project</label>
                        <p id="d_title" class="mt-1 text-gray-800"></p>
                    </div>

                    <div>
                        <label class="block font-medium text-gray-500">Deskripsi</label>
                        <p id="d_description" class="mt-1 text-gray-800 leading-relaxed"></p>
                    </div>

                    <div>
                        <label class="block font-medium text-gray-500">Link Project</label>
                        <div id="d_links" class="mt-1 text-blue-600 break-all space-y-1"></div>
                    </div>


                    <div>
                        <label class="block font-medium text-gray-500">Foto Dokumentasi</label>
                        <div id="d_photos" class="grid grid-cols-3 gap-2 mt-2"></div>
                    </div>

                </div>

                <!-- ================= RIGHT ================= -->
                <div class="space-y-6">

                    <div>
                        <label class="block font-medium text-gray-500">Status</label>
                        <div id="d_status" class="mt-1"></div>
                    </div>

                    <div>
                        <label class="block font-medium text-gray-500">Teknologi</label>
                        <div id="d_tech" class="flex flex-wrap gap-2 mt-1"></div>
                    </div>


                    <div>
                        <label class="block font-medium text-gray-500">File</label>
                        <div id="d_files" class="mt-2 text-blue-600 space-y-2"></div>
                    </div>

                    <div>
                        <label class="block font-medium text-gray-500">Kolaborator</label>
                        <ul id="d_members" class="mt-1 list-disc list-inside text-sm text-gray-700"></ul>
                    </div>
                    <div id="d_comment"></div>

                </div>


            </div>

            <!-- FOOTER -->
            <div class="flex justify-end gap-3 pt-6">
                <button type="button"
                    class="close-detail w-24 rounded-lg bg-red-500 text-white px-4 py-2 text-sm hover:bg-red-600">
                    Tutup
                </button>
            </div>

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

        $(document).on('click', '.btn-detail', function () {

            const id = $(this).data('id');

            Swal.fire({
                title: 'Mengambil data...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => Swal.showLoading()
            });

            $.get(`/projects/${id}/detail`)
                .done(function (res) {

                    Swal.close();

                    const p = res.data;

                    // BASIC
                    $('#d_title').text(p.title ?? '-');
                    $('#d_description').text(p.description ?? '-');

                    // STATUS
                    if (p.master_status) {
                        $('#d_status').html(`
                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold ${p.master_status.sp_warna}">
                        ${p.master_status.sp_nama_status}
                    </span>
                `);
                    }

                    // TEKNOLOGI
                    $('#d_tech').html('');
                    if (p.teknologis && p.teknologis.length) {
                        p.teknologis.forEach(t => {
                            $('#d_tech').append(`
                        <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-700">
                            ${t.tk_nama}
                        </span>
                    `);
                        });
                    }

                    // FILE
                    $('#d_files').html('');

                    if (p.files && p.files.length) {
                        p.files.forEach(f => {

                            const name = f.file_path.split('/').pop();

                            $('#d_files').append(`
            <div class="flex items-center justify-between gap-3 p-3 border rounded-xl bg-gray-50">

                <div class="flex items-center gap-2 overflow-hidden">
                    <span class="text-lg">📄</span>

                    <div class="truncate max-w-[180px] text-sm text-gray-700">
                        ${name}
                    </div>
                </div>

                <button onclick="window.open('/storage/${f.file_path}')"
                    class="text-blue-600 text-sm hover:underline whitespace-nowrap">
                    Lihat
                </button>

            </div>
        `);

                        });
                    } else {
                        $('#d_files').html('<span class="text-gray-400">Tidak ada file</span>');
                    }

                    // FOTO
                    $('#d_photos').html('');
                    if (p.photos) {
                        p.photos.forEach(ph => {
                            $('#d_photos').append(`
                        <img src="/storage/${ph.photo}"
                        onclick="openPhoto('/storage/${ph.photo}')"
                        class="h-24 w-24 rounded-lg object-cover cursor-pointer">
                    `);
                        });
                    }

                    // MEMBERS
                    $('#d_members').html('');
                    if (p.members && p.members.length) {
                        p.members.forEach(m => {
                            $('#d_members').append(`<li>${m.name}</li>`);
                        });
                    } else {
                        $('#d_members').html(
                            '<span class="text-gray-400">Tidak ada kolaborator</span>');
                    }

                    // KOMENTAR
                    if (p.admin_comment) {
                        $('#d_comment').html(`
                    <div class="mt-4 bg-blue-50 border border-blue-200 rounded-xl p-4">
                        <div class="text-sm font-semibold text-blue-600">
                            ${p.comment_by ?? 'Admin'}
                        </div>
                        <div class="text-sm text-gray-700 mt-1">
                            ${p.admin_comment}
                        </div>
                    </div>
                `);
                    } else {
                        $('#d_comment').html('');
                    }

                    $('#detailModal').removeClass('hidden');
                    $('body').addClass('overflow-hidden');

                })
                .fail(function (err) {
                    console.error(err);
                    Swal.close();
                    Swal.fire('Error', 'Gagal ambil data', 'error');
                });

        });

        // CLOSE
        $(document).on('click', '.close-detail', function () {
            $('#detailModal').addClass('hidden');
            $('body').removeClass('overflow-hidden');
        });

    });

    function openPhoto(src) {
        $('#previewImg').attr('src', src);
        $('#photoPreviewModal').removeClass('hidden');
    }

    $('#photoPreviewModal').on('click', function () {
        $(this).addClass('hidden');
    });

</script>
@endpush
