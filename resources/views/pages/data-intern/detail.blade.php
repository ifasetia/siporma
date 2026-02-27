<!-- DETAIL MODAL -->
<div id="detailModal" class="fixed inset-0 z-999999 hidden p-5 overflow-y-auto">

    <!-- Overlay -->
    <div class="fixed inset-0 bg-gray-400/50 backdrop-blur-sm"></div>

    <div class="min-h-full flex items-center justify-center">
        <div class="relative w-full max-w-[700px] rounded-3xl bg-white p-6 lg:p-11">

            <!-- Close -->
            <button type="button"
                class="close-detail absolute top-5 right-5 flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200">
                ✕
            </button>

            <!-- HEADER -->
            <div>
                <h5 class="font-semibold text-gray-800 text-xl">Detail Profil Intern</h5>
                <p class="text-sm text-gray-500">Informasi lengkap data intern.</p>
            </div>

            <!-- CONTENT -->
            <div class="grid grid-cols-2 gap-5 mt-6 text-sm">

                <div>
                    <label class="block font-medium text-gray-500">Nama</label>
                    <p id="d_nama" class="mt-1 text-gray-800"></p>
                </div>

                <div>
                    <label class="block font-medium text-gray-500">Email</label>
                    <p id="d_email" class="mt-1 text-gray-800"></p>
                </div>

                <div>
                    <label class="block font-medium text-gray-500">NIM</label>
                    <p id="d_nim" class="mt-1 text-gray-800"></p>
                </div>

                <div>
                    <label class="block font-medium text-gray-500">Kampus</label>
                    <p id="d_kampus" class="mt-1 text-gray-800"></p>
                </div>

                <div class="flex flex-col gap-1 mt-3">
                    <label>Jurusan</label>
                    <select name="pr_jurusan"
                        class="form-input h-11 rounded-lg border border-gray-300 px-4 text-sm">
                        <option value="">-- Pilih Jurusan --</option>
                        @foreach($jurusanList as $jurusan)
                            <option value="{{ $jurusan->js_id }}"
                                {{ $profile->pr_jurusan == $jurusan->js_id ? 'selected' : '' }}>
                                {{ $jurusan->js_nama}}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-medium text-gray-500">Posisi Magang</label>
                    <p id="d_pekerjaan" class="mt-1 text-gray-800"></p>
                </div>

                <div>
                    <label class="block font-medium text-gray-500">No HP</label>
                    <p id="d_hp" class="mt-1 text-gray-800"></p>
                </div>

                <div>
                    <label class="block font-medium text-gray-500">Jenis Kelamin</label>
                    <p id="d_gender" class="mt-1 text-gray-800"></p>
                </div>

                <div>
                    <label class="block font-medium text-gray-500">Tanggal Lahir</label>
                    <p id="d_birth" class="mt-1 text-gray-800"></p>
                </div>

                <div>
                    <label class="block font-medium text-gray-500">Alamat</label>
                    <p id="d_alamat" class="mt-1 text-gray-800"></p>
                </div>

                <div>
                    <label class="block font-medium text-gray-500">Status</label>
                    <p id="d_status" class="mt-1 text-gray-800"></p>
                </div>

                <div>
                    <label class="block font-medium text-gray-500">Mulai Magang</label>
                    <p id="d_start" class="mt-1 text-gray-800"></p>
                </div>

                <div>
                    <label class="block font-medium text-gray-500">Selesai Magang</label>
                    <p id="d_end" class="mt-1 text-gray-800"></p>
                </div>

                <div>
                    <label class="block font-medium text-gray-500">Nama Supervisor</label>
                    <p id="d_spv" class="mt-1 text-gray-800"></p>
                </div>

                <div>
                    <label class="block font-medium text-gray-500">Kontak Supervisor</label>
                    <p id="d_spv_contact" class="mt-1 text-gray-800"></p>
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

    function dbToDisplay(val){
    if(!val) return '-';
    const p = val.split('-'); // yyyy-mm-dd
    return p[2]+'/'+p[1]+'/'+p[0];
}

    if (!window.$) {
        console.error('jQuery NOT loaded');
        return;
    }

    // OPEN DETAIL
    $(document).on('click','.btn-detail',function(){

        const id = $(this).data('id');

        Swal.fire({
            title: 'Mengambil data...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => Swal.showLoading()
        });

        $.get(`/data-intern/${id}/detail`, function(res){

            Swal.close();

            const profile = res.data.profile;

            $('#d_nama').text(profile?.pr_nama ?? '-');
            $('#d_email').text(res.data.email ?? '-');
            $('#d_nim').text(profile?.pr_nim ?? '-');
            $('#d_kampus').text(profile?.kampus?.km_nama_kampus ?? '-');
            $('#d_jurusan').text(profile?.pr_jurusan ?? '-');
            $('#d_pekerjaan').text(profile?.pekerjaan?.pk_nama_pekerjaan ?? '-');
            $('#d_hp').text(profile?.pr_no_hp ?? '-');
            $('#d_gender').text(profile?.pr_jenis_kelamin ?? '-');
            $('#d_birth').text(dbToDisplay(profile?.pr_tanggal_lahir));
            $('#d_alamat').text(profile?.pr_alamat ?? '-');
            const status = profile?.pr_status ?? 'Nonaktif';

            if(status === 'Aktif'){
                $('#d_status').html(`
                    <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                        Aktif
                    </span>
                `);
            }else{
                $('#d_status').html(`
                    <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                        Nonaktif
                    </span>
                `);
            }

            $('#d_start').text(dbToDisplay(profile?.pr_internship_start));
            $('#d_end').text(dbToDisplay(profile?.pr_internship_end));
            $('#d_spv').text(profile?.pr_supervisor_name ?? '-');
            $('#d_spv_contact').text(profile?.pr_supervisor_contact ?? '-');


            $('#detailModal').removeClass('hidden');
            $('body').addClass('overflow-hidden');
        });
    });

    // CLOSE DETAIL
    $(document).on('click','.close-detail',function(){
        $('#detailModal').addClass('hidden');
        $('body').removeClass('overflow-hidden');
    });

});
</script>
@endpush
