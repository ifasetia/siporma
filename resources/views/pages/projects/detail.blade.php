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
<div class="grid grid-cols-2 gap-5 mt-6 text-sm">

<div>
<label class="block font-medium text-gray-500">Judul Project</label>
<p id="d_title" class="mt-1 text-gray-800"></p>
</div>

<div>
<label class="block font-medium text-gray-500">Status</label>
<p id="d_status" class="mt-1"></p>
</div>

<div>
<label class="block font-medium text-gray-500">Deskripsi</label>
<p id="d_description" class="mt-1 text-gray-800"></p>
</div>

<div>
<label class="block font-medium text-gray-500">Teknologi</label>
<p id="d_tech" class="mt-1 text-gray-800"></p>
</div>

<div class="col-span-2">
<label class="block font-medium text-gray-500">Link Project</label>
<div id="d_links" class="mt-1 text-blue-600 break-all"></div>
</div>

<div>
<label class="block font-medium text-gray-500">Foto Dokumentasi</label>
<div id="d_photos" class="grid grid-cols-3 gap-2 mt-2"></div>
</div>

<div>
<label class="block font-medium text-gray-500">File</label>
<div id="d_files" class="mt-2 text-blue-600"></div>
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

if (!window.$) return;

$(document).on('click','.btn-detail',function(){

const id = $(this).data('id');

Swal.fire({
title: 'Mengambil data...',
text: 'Mohon tunggu sebentar',
allowOutsideClick:false,
showConfirmButton:false,
didOpen:()=>Swal.showLoading()
});

$.get(`/projects/${id}/detail`,function(res){

Swal.close();

const p = res.data;

// BASIC
$('#d_title').text(p.title ?? '-');
$('#d_description').text(p.description ?? '-');
$('#d_tech').text(p.technologies ?? '-');

// STATUS
if(p.status === 'menunggu'){
$('#d_status').html(`<span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">Menunggu</span>`);
}else{
$('#d_status').html(`<span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">Disetujui</span>`);
}

// LINKS
$('#d_links').html('');

if(p.links && p.links.length){
    p.links.forEach(l=>{
        $('#d_links').append(`
            <li class="mb-1">
                <a href="${l.url}" target="_blank" class="text-blue-600 underline">
                    ${l.label ?? l.url}
                </a>
            </li>
        `);
    });
}else{
    $('#d_links').html('<span class="text-gray-400">Tidak ada link</span>');
}

// FOTO
$('#d_photos').html('');

if(p.photos && p.photos.length){
p.photos.forEach(ph=>{
$('#d_photos').append(`
<img src="/storage/${ph.photo}"
onclick="openPhoto('/storage/${ph.photo}')"
class="h-24 w-24 rounded-lg object-cover border cursor-pointer hover:scale-105 transition">
`);
});
}else{
$('#d_photos').html('<span class="text-gray-400">Tidak ada foto</span>');
}

// FILE
$('#d_files').html('');

if(p.files && p.files.length){
p.files.forEach(f=>{

const name = f.file_path.split('/').pop();

$('#d_files').append(`
<button
title="${name}"
onclick="window.open('/storage/${f.file_path}')"
class="mb-2 max-w-full overflow-hidden whitespace-nowrap text-ellipsis inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm text-white hover:bg-blue-700">

📄 ${name}

</button>
`);

});
}else{
$('#d_files').html('<span class="text-gray-400">Tidak ada file</span>');
}

$('#detailModal').removeClass('hidden');
$('body').addClass('overflow-hidden');

});

});

// CLOSE
$(document).on('click','.close-detail',function(){
$('#detailModal').addClass('hidden');
$('body').removeClass('overflow-hidden');
});

function openPhoto(src){
$('#previewImg').attr('src',src);
$('#photoPreviewModal').removeClass('hidden');
}

$('#photoPreviewModal').on('click',function(){
$(this).addClass('hidden');
});



});
</script>
@endpush