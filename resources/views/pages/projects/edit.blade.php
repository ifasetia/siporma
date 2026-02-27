<!-- EDIT MODAL PROJECT -->
<div id="eventEditModal" class="fixed inset-0 z-999999 hidden p-5 overflow-y-auto">

<div class="fixed inset-0 bg-gray-400/50 backdrop-blur-sm"></div>

<div class="min-h-full flex items-center justify-center">
<div class="modal-dialog relative w-full max-w-[700px] rounded-3xl bg-white p-6 lg:p-11">

<button type="button"
class="modal-close-btn absolute top-5 right-5 flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-gray-500">
✕
</button>

<form id="submitFormEditProject"
class="flex flex-col gap-5"
method="POST"
enctype="multipart/form-data">

@csrf

<input type="hidden" id="edit_project_id">

<!-- HEADER -->
<div>
<h5 class="font-semibold text-gray-800 text-xl">
Edit Project
</h5>
<p class="text-sm text-gray-500">
Silahkan ubah data project.
</p>
</div>

<!-- JUDUL -->
<div>
<label class="block text-sm font-medium mb-1">Judul Project</label>
<input name="title"
class="input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm">
<span class="error text-xs text-red-500" data-error="title"></span>
</div>

<!-- DESKRIPSI -->
<div>
<label class="block text-sm font-medium mb-1">Deskripsi</label>
<textarea name="description"
class="input-field h-24 w-full rounded-lg border border-gray-300 px-4 py-2 text-sm"></textarea>
<span class="error text-xs text-red-500" data-error="description"></span>
</div>

<!-- TEKNOLOGI -->
<div>
<label class="block text-sm font-medium mb-1">Teknologi</label>
<select id="edit_teknologis" name="teknologis[]" multiple
class="input-field w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">
@foreach(\App\Models\Master\Teknologi::all() as $tk)
<option value="{{ $tk->tk_id }}">
    {{ $tk->tk_nama }}
</option>
@endforeach
</select>

<span class="error text-xs text-red-500" data-error="teknologis"></span>
<span class="error text-xs text-red-500" data-error="technologies"></span>
</div>

<!-- LINK PROJECT -->
<div>
<label class="block text-sm font-medium mb-1">Link Project</label>

<div id="edit-link-wrapper" class="space-y-2"></div>

<button type="button" id="btnAddEditLink"
class="mt-2 text-sm text-blue-600 hover:underline">
+ Tambah Link
</button>
</div>

<!-- FILE LAMA -->
<div>
<label class="block text-sm font-medium mb-1">File Lama</label>
<ul id="oldFileList" class="text-sm text-gray-600"></ul>
</div>

<!-- FILE BARU -->
<div>
<label class="block text-sm font-medium mb-1">Tambah File</label>
<input id="edit_files" type="file" name="files[]" multiple class="hidden">
<label for="edit_files"
class="cursor-pointer border-2 border-dashed border-gray-300 rounded-xl p-6 block text-center">
Klik upload file
</label>

<ul id="editFileList" class="mt-2 text-sm"></ul>
</div>

<!-- FOTO LAMA -->
<div>
<label class="block text-sm font-medium mb-1">Foto Lama</label>
<div id="oldPhotoPreview" class="grid grid-cols-4 gap-2"></div>
</div>

<!-- FOTO BARU -->
<div>
<label class="block text-sm font-medium mb-1">Tambah Foto</label>

<input id="edit_photos" type="file" name="photos[]" multiple accept="image/*" class="hidden">

<label for="edit_photos"
class="cursor-pointer border-2 border-dashed border-gray-300 rounded-xl p-6 block text-center">
Klik upload foto
</label>

<div id="editPhotoPreview" class="grid grid-cols-4 gap-2 mt-3"></div>
</div>

<!-- KOLLABORATOR -->
<div>
<label class="block text-sm font-medium mb-1">Kolaborator</label>

<select id="edit_members" name="members[]" multiple
class="input-field w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">

@foreach(\App\Models\User::where('role','intern')->get() as $intern)
<option value="{{ $intern->id }}">
    {{ $intern->name }}
</option>
@endforeach

</select>

<span class="error text-xs text-red-500" data-error="members"></span>
</div>

<!-- FOOTER -->
<div class="flex justify-end gap-3 pt-4">

<button type="button"
class="modal-close-btn w-24 rounded-lg bg-red-500 text-white px-4 py-2 text-sm">
Tutup
</button>

<button type="button" id="btnEditProject"
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

    /* ============================================================
       MODAL HANDLER
    ============================================================ */

    const $modalEdit = $('#eventEditModal');

    function closeEditModal() {
        $modalEdit.addClass('hidden');
        $('body').removeClass('overflow-hidden');
        resetEditProjectForm();
    }

    function resetEditProjectForm() {
        const form = $('#submitFormEditProject');
        form[0].reset();

        $('.error').text('');
        $('#edit-link-wrapper').html('');
        $('#oldFileList').html('');
        $('#oldPhotoPreview').html('');
        $('#editFileList').html('');
        $('#editPhotoPreview').html('');

        editLinkIndex = 0;
        // 🔥 TAMBAHKAN INI
        editFileBuffer = [];
        editPhotoBuffer = [];
    }

    $(document).on('click', '.modal-close-btn', function () {
        closeEditModal();
    });

    $(document).on('keydown', function (e) {
        if (e.key === 'Escape') {
            closeEditModal();
        }
    });


    /* ============================================================
       TAMBAH LINK EDIT
    ============================================================ */

    let editLinkIndex = 0;

    $('#btnAddEditLink').on('click', function () {

        $('#edit-link-wrapper').append(`
            <div class="flex gap-2 link-row">
                <input name="links[${editLinkIndex}][label]"
                       class="border rounded px-3 py-2 w-1/3">

                <input name="links[${editLinkIndex}][url]"
                       class="border rounded px-3 py-2 flex-1">

                <button type="button"
                        class="btn-remove-link text-red-500">✕</button>
            </div>
        `);

        editLinkIndex++;
    });

    $(document).on('click', '.btn-remove-link', function () {
        $(this).closest('.link-row').remove();
    });


    /* ============================================================
       LOAD DATA EDIT
    ============================================================ */

    $(document).on('click', '.btn-edit', function () {

        const id = $(this).data('id');

        Swal.fire({
            title: 'Mengambil data...',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => Swal.showLoading()
        });

        $.ajax({
            url: `/projects/${id}/edit`,
            type: 'GET',
            success: function (res) {

                Swal.close();

                const data = res.data ?? res;

                console.log('DATA EDIT:', data);

                openEditProject(data);
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal mengambil data'
                });
            }
        });

    });


    /* ============================================================
       OPEN EDIT MODAL + ISI DATA
    ============================================================ */

    function openEditProject(p) {

        $modalEdit.removeClass('hidden');
        $('body').addClass('overflow-hidden');

        $('#edit_project_id').val(p.id ?? '');

        $('input[name="title"]').val(p.title ?? '');
        $('textarea[name="description"]').val(p.description ?? '');
        if (editTomSelect) {
        editTomSelect.clear();
    }

    if (p.teknologis && p.teknologis.length) {

        p.teknologis.forEach(function(t){
            editTomSelect.addItem(t.tk_id);
        });

    }

    if (editMemberSelect) {
        editMemberSelect.clear();
    }

    if (p.members && p.members.length) {

    p.members.forEach(function(user){
        editMemberSelect.addItem(user.id);
    });

}

        /* ---------- LINKS ---------- */
        $('#edit-link-wrapper').html('');
        editLinkIndex = 0;

        if (p.links && p.links.length) {
            p.links.forEach((l, index) => {

                $('#edit-link-wrapper').append(`
                    <div class="flex gap-2 link-row">
                        <input name="links[${index}][label]"
                               value="${l.label ?? ''}"
                               class="border rounded px-3 py-2 w-1/3">

                        <input name="links[${index}][url]"
                               value="${l.url ?? ''}"
                               class="border rounded px-3 py-2 flex-1">

                        <button type="button"
                                onclick="deleteOldLink('${l.id}')"
                                class="text-red-500">✕</button>
                    </div>
                `);

                editLinkIndex++;
            });
        }

        /* ---------- FILE LAMA ---------- */
        $('#oldFileList').html('');

        if (p.files && p.files.length) {
            p.files.forEach(f => {

                const filename = f.file_path.split('/').pop();

                $('#oldFileList').append(`
                    <li class="flex justify-between items-center">
                        <span>${filename}</span>
                        <button type="button"
                                onclick="deleteOldFile('${f.id}')"
                                class="text-red-500">✕</button>
                    </li>
                `);
            });
        } else {
            $('#oldFileList').html('<span class="text-gray-400">Tidak ada file</span>');
        }

        /* ---------- FOTO LAMA ---------- */
        $('#oldPhotoPreview').html('');

        if (p.photos && p.photos.length) {
            p.photos.forEach(ph => {

                $('#oldPhotoPreview').append(`
                    <div class="relative">
                        <img src="/storage/${ph.photo}"
                             class="h-20 rounded-lg object-cover">

                        <button type="button"
                                onclick="deleteOldPhoto('${ph.id}')"
                                class="absolute top-0 right-0 bg-red-500 text-white w-5 h-5 text-xs rounded-full">
                            ✕
                        </button>
                    </div>
                `);
            });
        } else {
            $('#oldPhotoPreview').html('<span class="text-gray-400">Tidak ada foto</span>');
        }
    }


    /* ============================================================
       DELETE FILE / FOTO / LINK LAMA
    ============================================================ */

    window.deleteOldFile = function (id) {
        $.ajax({
            url: `/project-files/${id}`,
            type: 'DELETE',
            data: { _token: $('meta[name="csrf-token"]').attr('content') },
            success: function () {
                $(`button[onclick*="${id}"]`).parent().remove();
            }
        });
    };

    window.deleteOldPhoto = function (id) {
        $.ajax({
            url: `/project-photos/${id}`,
            type: 'DELETE',
            data: { _token: $('meta[name="csrf-token"]').attr('content') },
            success: function () {
                $(`button[onclick*="${id}"]`).parent().remove();
            }
        });
    };

    window.deleteOldLink = function (id) {
        $.ajax({
            url: `/project-links/${id}`,
            type: 'DELETE',
            data: { _token: $('meta[name="csrf-token"]').attr('content') },
            success: function () {
                $(`button[onclick*="${id}"]`).parent().remove();
            }
        });
    };


    /* ============================================================
       UPDATE PROJECT
    ============================================================ */

    $('#btnEditProject').on('click', function (e) {

        e.preventDefault();

        const id = $('#edit_project_id').val();
        const form = $('#submitFormEditProject');
        const data = new FormData(form[0]);
        
        
        const btn = $(this);

        $('.error').text('');

        btn.prop('disabled', true).text('Mengupdate...');

        Swal.fire({
            title: 'Mengupdate data...',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => Swal.showLoading()
        });

        $.ajax({
            url: `/projects/${id}/update`, // 🔥 ubah di sini
            method: 'POST',
            data: data,
            processData: false,
            contentType: false,
            success: function (res) {

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: res.message,
                    timer: 1500,
                    showConfirmButton: false
                });

                closeEditModal();
                window.table.ajax.reload(null, false);
            },
            error: function (xhr) {

                Swal.close();

                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;

                    Object.keys(errors).forEach(function (key) {
                        $(`[data-error="${key}"]`).text(errors[key][0]);
                    });

                    return;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Gagal update'
                });
            },
            complete: function () {
                btn.prop('disabled', false).text('Simpan');
            }
        });

    });


    /* ============================================================
    TOMSELECT EDIT TEKNOLOGI
    ============================================================ */

    let editTomSelect = new TomSelect('#edit_teknologis', {
        plugins: ['remove_button'],
        create: false,
        placeholder: 'Pilih teknologi...'
    });

    let editMemberSelect = new TomSelect('#edit_members', {
        plugins:['remove_button'],
        create:false,
        placeholder:'Pilih intern...'
    });

    /* ============================================================
    PREVIEW FILE BARU (EDIT)
    ============================================================ */

    let editFileBuffer = [];

    $('#edit_files').on('change', function () {

        Array.from(this.files).forEach(f => editFileBuffer.push(f));

        refreshEditFiles();
    });

    function refreshEditFiles() {

        const dt = new DataTransfer();
        editFileBuffer.forEach(f => dt.items.add(f));
        document.getElementById('edit_files').files = dt.files;

        $('#editFileList').html('');

        editFileBuffer.forEach((file,index) => {

            $('#editFileList').append(`
                <li class="flex justify-between items-center bg-gray-50 px-3 py-2 rounded">
                    <span>📄 ${file.name}</span>
                    <button type="button"
                            onclick="removeEditFile(${index})"
                            class="text-red-500 text-sm">✕</button>
                </li>
            `);

        });
    }

    window.removeEditFile = function(index){
        editFileBuffer.splice(index,1);
        refreshEditFiles();
    }

    /* ============================================================
    PREVIEW FOTO BARU (EDIT)
    ============================================================ */

    let editPhotoBuffer = [];

    $('#edit_photos').on('change', function () {

        Array.from(this.files).forEach(f => editPhotoBuffer.push(f));

        refreshEditPhotos();
    });

    function refreshEditPhotos() {

        const dt = new DataTransfer();
        editPhotoBuffer.forEach(f => dt.items.add(f));
        document.getElementById('edit_photos').files = dt.files;

        $('#editPhotoPreview').html('');

        editPhotoBuffer.forEach((file,index) => {

            const reader = new FileReader();

            reader.onload = function(e){

                $('#editPhotoPreview').append(`
                    <div class="relative">
                        <img src="${e.target.result}"
                            class="h-24 w-24 rounded-lg object-cover border">
                        <button type="button"
                                onclick="removeEditPhoto(${index})"
                                class="absolute top-0 right-0 bg-red-500 text-white w-5 h-5 text-xs rounded-full">
                            ✕
                        </button>
                    </div>
                `);

            }

            reader.readAsDataURL(file);

        });
    }

    window.removeEditPhoto = function(index){
        editPhotoBuffer.splice(index,1);
        refreshEditPhotos();
    }
});
</script>
@endpush
