<div id="validasiModal" class="fixed inset-0 z-999999 hidden p-5 overflow-y-auto">

<div class="fixed inset-0 bg-gray-400/50 backdrop-blur-sm"></div>

<div class="min-h-full flex items-center justify-center">
<div class="relative w-full max-w-[700px] rounded-3xl bg-white p-6 lg:p-11">

<button type="button"
class="close-validasi absolute top-5 right-5 flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200">
✕
</button>

<h5 class="font-semibold text-gray-800 text-xl">Validasi Project</h5>
<p class="text-sm text-gray-500 mb-6">Ubah status project intern.</p>

<div class="space-y-6 text-sm">

<div>
<label class="block font-medium text-gray-500">Judul Project</label>
<p id="v_title" class="mt-1 text-gray-800"></p>
</div>

<div>
<label class="block font-medium text-gray-500">Status Saat Ini</label>
<div id="v_status" class="mt-1"></div>
</div>

<div>
<label class="block font-medium text-gray-500">Ubah Status</label>
<select id="v_status_id"
class="w-full mt-2 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm">

@foreach($statuses as $status)
<option value="{{ $status->sp_id }}">
{{ $status->sp_nama_status }}
</option>
@endforeach

</select>
</div>

</div>

<div class="flex justify-end gap-3 pt-8">

<button type="button"
class="close-validasi w-24 rounded-lg bg-gray-200 px-4 py-2 text-sm hover:bg-gray-300">
Batal
</button>

<button id="btnSimpanValidasi"
class="w-24 rounded-lg bg-blue-600 text-white px-4 py-2 text-sm hover:bg-blue-700">
Simpan
</button>

</div>

</div>
</div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

let validasiId = null;

$(document).on('click','.btn-validasi',function(){

validasiId = $(this).data('id');

Swal.fire({
title:'Mengambil data...',
text:'Mohon tunggu sebentar',
allowOutsideClick:false,
showConfirmButton:false,
didOpen:()=>Swal.showLoading()
});

$.get(`/projects/${validasiId}/detail`,function(res){

Swal.close();

const p = res.data;

$('#v_title').text(p.title ?? '-');
$('#v_status_id').val(p.status_id);

if(p.master_status){
$('#v_status').html(`
<span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold ${p.master_status.sp_warna}">
${p.master_status.sp_nama_status}
</span>
`);
}

$('#validasiModal').removeClass('hidden');
$('body').addClass('overflow-hidden');

});

});


$('#btnSimpanValidasi').click(function(){

const status_id = $('#v_status_id').val();

Swal.fire({
title:'Menyimpan...',
allowOutsideClick:false,
showConfirmButton:false,
didOpen:()=>Swal.showLoading()
});

$.ajax({
url:`/validasi-proyek/${validasiId}/status`,
method:"PUT",
data:{
status_id:status_id,
_token:"{{ csrf_token() }}"
},
success:function(res){

Swal.fire({
icon:'success',
title:'Berhasil',
text:res.message
}).then(()=>{
$('#validasiModal').addClass('hidden');
$('body').removeClass('overflow-hidden');
$('#validasiTable').DataTable().ajax.reload(null,false);
});

}
});

});


$(document).on('click','.close-validasi',function(){
$('#validasiModal').addClass('hidden');
$('body').removeClass('overflow-hidden');
});

});
</script>
@endpush