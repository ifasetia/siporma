<!-- REVIEW MODAL -->
<div id="reviewModal" class="fixed inset-0 z-999999 hidden p-5 overflow-y-auto">

<div class="fixed inset-0 bg-gray-400/50 backdrop-blur-sm"></div>

<div class="min-h-full flex items-center justify-center">
<div class="relative w-full max-w-[700px] rounded-3xl bg-white p-6 lg:p-11">

<button type="button"
class="close-review absolute top-5 right-5 flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200">
✕
</button>

<div>
<h5 class="font-semibold text-gray-800 text-xl">Detail Project</h5>
<p class="text-sm text-gray-500">Informasi lengkap data project.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 mt-6 text-sm">

<!-- LEFT -->
<div class="space-y-6">

<div>
<label class="block font-medium text-gray-500">Judul Project</label>
<p id="r_title" class="mt-1 text-gray-800"></p>
</div>

<div>
<label class="block font-medium text-gray-500">Deskripsi</label>
<p id="r_description" class="mt-1 text-gray-800 leading-relaxed"></p>
</div>

<div>
<label class="block font-medium text-gray-500">Link Project</label>
<div id="r_links" class="mt-1 text-blue-600 space-y-1"></div>
</div>

<div>
<label class="block font-medium text-gray-500">Foto Dokumentasi</label>
<div id="r_photos" class="grid grid-cols-3 gap-2 mt-2"></div>
</div>

</div>

<!-- RIGHT -->
<div class="space-y-6">

<div>
<label class="block font-medium text-gray-500">Status</label>
<div id="r_status" class="mt-1"></div>
</div>

<div>
<label class="block font-medium text-gray-500">Teknologi</label>
<div id="r_tech" class="flex flex-wrap gap-2 mt-1"></div>
</div>



<div>
<label class="block font-medium text-gray-500">File</label>
<div id="r_files" class="mt-2 space-y-2 break-all"></div>
</div>

<div>
<label class="block font-medium text-gray-500">Kolaborator</label>
<ul id="r_members" class="mt-1 list-disc list-inside text-sm text-gray-700"></ul>
</div>

</div>

</div>

<div class="flex justify-end gap-3 pt-6">
<button type="button"
class="close-review w-24 rounded-lg bg-red-500 text-white px-4 py-2 text-sm hover:bg-red-600">
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

$(document).on('click','.btn-review',function(){

const id = $(this).data('id');

Swal.fire({
title:'Mengambil data...',
text:'Mohon tunggu sebentar',
allowOutsideClick:false,
showConfirmButton:false,
didOpen:()=>Swal.showLoading()
});

$.get(`/projects/${id}/detail`,function(res){

Swal.close();

const p = res.data;

// RESET
$('#r_members,#r_links,#r_photos,#r_files,#r_tech,#r_status').html('');

// BASIC
$('#r_title').text(p.title ?? '-');
$('#r_description').text(p.description ?? '-');

// STATUS
if(p.master_status){
$('#r_status').html(`
<span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold ${p.master_status.sp_warna}">
${p.master_status.sp_nama_status}
</span>
`);
}

// TEKNOLOGI
if(p.teknologis){
p.teknologis.forEach(t=>{
$('#r_tech').append(`
<span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-700">
${t.tk_nama}
</span>
`);
});
}

// LINKS
if(p.links){
p.links.forEach(l=>{
$('#r_links').append(`
<a href="${l.url}" target="_blank" class="block underline">
${l.label ?? l.url}
</a>
`);
});
}

// FOTO
if(p.photos){
p.photos.forEach(ph=>{
$('#r_photos').append(`
<img src="/storage/${ph.photo}"
class="h-24 w-24 rounded-lg object-cover border">
`);
});
}

// FILE
if(p.files){
p.files.forEach(f=>{
const name = f.file_path.split('/').pop();
$('#r_files').append(`
<button
title="${name}"
onclick="window.open('/storage/${f.file_path}')"
class="w-full max-w-full overflow-hidden whitespace-nowrap text-ellipsis inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm text-white hover:bg-blue-700">

<span class="truncate block w-full">
📄 ${name}
</span>

</button>
`);
});
}

// MEMBERS
$('#r_members').html('');

if (p.members && p.members.length) {

    p.members.forEach(function(user) {
        $('#r_members').append(`<li>${user.name}</li>`);
    });

} else {

    $('#r_members').html('<span class="text-gray-400">Tidak ada kolaborator</span>');

}

$('#reviewModal').removeClass('hidden');
$('body').addClass('overflow-hidden');

}); // ← tutup $.get

}); // ← tutup btn-review click


// CLOSE
$(document).on('click','.close-review',function(){
    $('#reviewModal').addClass('hidden');
    $('body').removeClass('overflow-hidden');
});

}); // ← tutup DOMContentLoaded
</script>
@endpush