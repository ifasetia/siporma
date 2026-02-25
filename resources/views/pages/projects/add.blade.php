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


          <form id="submitFormProject"
    class="flex flex-col gap-5"
    action="{{ route('projects.store') }}"
    method="POST"
    enctype="multipart/form-data">
@csrf

<!-- Header -->
<div>
    <h5 class="font-semibold text-gray-800 text-xl">
        Tambah Project
    </h5>
    <p class="text-sm text-gray-500">
        Silahkan isi form berikut untuk menambahkan project baru.
    </p>
</div>

<!-- Judul -->
<div>
<label class="block text-sm font-medium mb-1">Judul Project</label>
<input name="title"
class="input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm"
placeholder="Judul project...">
<span class="error text-xs text-red-500" data-error="title"></span>
</div>

<!-- Deskripsi -->
<div>
<label class="block text-sm font-medium mb-1">Deskripsi</label>
<textarea name="description"
class="input-field h-24 w-full rounded-lg border border-gray-300 px-4 py-2 text-sm"
placeholder="Deskripsi project..."></textarea>
<span class="error text-xs text-red-500" data-error="description"></span>
</div>

<!-- Teknologi -->
<div>
<label class="block text-sm font-medium mb-1">Teknologi</label>
<input name="technologies"
class="input-field h-11 w-full rounded-lg border border-gray-300 px-4 text-sm"
placeholder="Laravel, Flutter, PostgreSQL">
<span class="error text-xs text-red-500" data-error="technologies"></span>
</div>

<!-- Dokumen -->
<div>
<label class="block text-sm font-medium mb-1">Upload Dokumen</label>

<label for="files" class="cursor-pointer">
<div
class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-blue-500 transition">

<svg class="mx-auto h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M12 12v9m0-9l-3 3m3-3l3 3"/>
</svg>

<p class="mt-2 text-sm text-gray-600">
Klik atau drag file ke sini
</p>

<p class="text-xs text-gray-400">
PDF / DOC / ZIP / dll
</p>

</div>
</label>

<input id="files" type="file" name="files[]" multiple class="hidden">

<ul id="fileList" class="mt-2 text-sm text-gray-600"></ul>
</div>

<!-- LINK PROJECT -->
<div>
<label class="block text-sm font-medium mb-1">Link Project</label>

<div id="link-wrapper" class="space-y-2">

<div class="flex gap-2 link-row">
<input name="links[0][label]"
class="h-10 w-1/3 rounded border border-gray-300 px-3 text-sm"
placeholder="GitHub">

<input name="links[0][url]"
class="h-10 flex-1 rounded border border-gray-300 px-3 text-sm"
placeholder="https://...">

<button type="button" class="btn-remove-link text-red-500">✕</button>
</div>

</div>

<button type="button" id="btnAddLink"
class="mt-2 text-sm text-blue-600 hover:underline">
+ Tambah Link
</button>
</div>

<!-- FOTO -->
<div>
<label class="block text-sm font-medium mb-1">Upload Foto Dokumentasi</label>

<input id="photos" type="file" name="photos[]" multiple accept="image/*" class="hidden">

<label for="photos"
class="cursor-pointer border-2 border-dashed border-gray-300 rounded-xl p-6 block text-center hover:border-blue-500">

📷 Klik untuk upload foto

</label>

<div id="photoPreview" class="grid grid-cols-4 gap-2 mt-3"></div>
</div>

<!-- KOLABORATOR -->
<div>
<label class="block text-sm font-medium mb-1">Kolaborator</label>

<select id="members" name="members[]" multiple
class="input-field w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">
@foreach($interns as $intern)
<option value="{{ $intern->id }}">{{ $intern->name }}</option>
@endforeach
</select>

<small class="text-gray-500">
Bisa pilih lebih dari satu intern
</small>
</div>

<!-- FOOTER -->
<div class="flex justify-end gap-3 pt-4">
<button type="button"
class="modal-close-btn w-24 rounded-lg bg-red-500 text-white px-4 py-2 text-sm hover:bg-red-600">
Tutup
</button>

<button type="button" id="btnSimpanProject"
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

let fileBuffer = [];

$('#files').on('change',function(){

Array.from(this.files).forEach(f=>fileBuffer.push(f));

refreshFiles();

});

function refreshFiles(){

const dt = new DataTransfer();
fileBuffer.forEach(f=>dt.items.add(f));
document.getElementById('files').files = dt.files;

$('#fileList').html('');

fileBuffer.forEach((file,index)=>{

$('#fileList').append(`
<li class="flex justify-between items-center gap-2">
<span>📄 ${file.name}</span>
<button type="button"
onclick="removeFile(${index})"
class="text-red-500 text-sm">✕</button>
</li>
`);

});
}

function removeFile(index){
fileBuffer.splice(index,1);
refreshFiles();
}
window.removeFile = removeFile;   // ⬅️ TAMBAH


let photoBuffer = [];

$('#photos').on('change',function(){

Array.from(this.files).forEach(f=>photoBuffer.push(f));

refreshPhotos();

});

function refreshPhotos(){

const dt = new DataTransfer();
photoBuffer.forEach(f=>dt.items.add(f));
document.getElementById('photos').files = dt.files;

$('#photoPreview').html('');

photoBuffer.forEach((file,index)=>{

const reader = new FileReader();

reader.onload = e=>{

$('#photoPreview').append(`
<div class="relative">
<img src="${e.target.result}" class="h-20 rounded-lg object-cover">
<button type="button"
onclick="removePhoto(${index})"
class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-5 h-5 text-xs">✕</button>
</div>
`);

}

reader.readAsDataURL(file);

});
}

function removePhoto(index){
photoBuffer.splice(index,1);
refreshPhotos();
}

window.removePhoto = removePhoto; // ⬅️ TAMBAH

function openPhoto(src){
    $('#previewImg').attr('src', src);
    $('#photoPreviewModal').removeClass('hidden');
}

window.openPhoto = openPhoto;

        let linkIndex = 1;

$('#btnAddLink').on('click', function () {

$('#link-wrapper').append(`
<div class="flex gap-2 mt-2 link-row">

<input name="links[${linkIndex}][label]" placeholder="Label"
class="border rounded px-3 py-2 w-1/3">

<input name="links[${linkIndex}][url]" placeholder="https://..."
class="border rounded px-3 py-2 flex-1">

<button type="button" class="btn-remove-link text-red-500">✕</button>

</div>
`);

linkIndex++;

});

$(document).on('click','.btn-remove-link',function(){
$(this).closest('.link-row').remove();
});

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
            resetProjectForm();
        };

        // CLOSE MODAL
        function closeModal() {
            $modal.addClass('hidden');
            $('body').removeClass('overflow-hidden');
            resetProjectForm();
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


        function resetProjectForm() {
const form = $('#submitFormProject');
form[0].reset();
$('.error').text('');
$('#link-wrapper').html('');
linkIndex = 0;
$('#btnAddLink').click();
}


        /*
        |--------------------------------------------------------------------------
        | ➕ ADD DATA KAMPUS
        |--------------------------------------------------------------------------
        | Flow:
        | 1. Klik tombol simpan
        | 2. Validasi form
        | 3. SweetAlert loading
        | 4. AJAX POST
        | 5. Reload DataTables
        |--------------------------------------------------------------------------
        */
        $(document).on('click', '#btnSimpanProject', function (e) {
            e.preventDefault();
            const form = $('#submitFormProject');
            const url = form.attr('action');
            const data = new FormData(form[0]);
            const btn = $(this);
            console.log('BTN SIMPAN CLICKED');
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
                processData:false,
                contentType:false,
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
                        resetProjectForm();
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
        | 🗑️ DELETE DATA KAMPUS
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
                    url: `/projects/${id}`,
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

        new TomSelect('#members',{
    plugins:['remove_button'],
    create:false,
    placeholder:'Pilih intern...'
});
    });

</script>
@endpush
