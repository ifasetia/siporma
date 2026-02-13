<div id="eventEditModal" class="fixed inset-0 z-999999 hidden p-5 overflow-y-auto" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-400/50 backdrop-blur-sm"></div>
    <div class="min-h-full flex items-center justify-center">
        <div class="modal-dialog relative w-full max-w-[700px] rounded-3xl bg-white p-6 lg:p-11 ">
            <button type="button" class="modal-close-btn absolute top-5 right-5 flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200 dark:bg-white/5">
                ✕
            </button>

            <form id="submitFormEditPekerjaan" class="flex flex-col gap-6" action="" method="POST">
                @csrf
                @method('PUT')
                <div>
                    <h5 id="eventEditModalLabel" class="font-semibold text-gray-800 text-xl dark:text-white">
                        Edit Data Pekerjaan
                    </h5>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Silahkan perbarui data tipe pekerjaan berikut.
                    </p>
                </div>

                <!-- Kode Tipe Pekerjaan -->
                <div>
                    <label class="block text-sm font-medium mb-1">Kode Tipe Pekerjaan</label>
                    <input type="text" name="pk_kode_tipe_pekerjaan" value="{{ old('pk_kode_tipe_pekerjaan') }}"
                        placeholder="Inputkan kode tipe pekerjaan..." class="h-11 w-full rounded-lg border px-4 text-sm
            @error('pk_kode_tipe_pekerjaan') border-red-500 @else border-gray-300 @enderror">

                    @error('pk_kode_tipe_pekerjaan')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Pekerjaan -->
                <div>
                    <label class="block text-sm font-medium mb-1">Nama Pekerjaan</label>
                    <input type="text" name="pk_nama_pekerjaan" value="{{ old('pk_nama_pekerjaan') }}"
                        placeholder="Inputkan nama pekerjaan..." class="h-11 w-full rounded-lg border px-4 text-sm
            @error('pk_nama_pekerjaan') border-red-500 @else border-gray-300 @enderror">

                    @error('pk_nama_pekerjaan')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Level Pekerjaan -->
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Level Pekerjaan
                    </label>
                    <div class="relative">
                        <select name="pk_level_pekerjaan" class="h-11 w-full appearance-none rounded-lg border px-4 pr-11 text-sm focus:ring-2 focus:outline-none
                    @error('pk_level_pekerjaan') border-red-500 focus:ring-red-200
                    @else border-gray-300 focus:ring-blue-200
                    @enderror
                    dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                            <option value="">-- Pilih Level Pekerjaan --</option>
                            <option value="Easy" {{ old('pk_level_pekerjaan') == 'Easy' ? 'selected' : '' }}>
                                Easy
                            </option>
                            <option value="Medium" {{ old('pk_level_pekerjaan') == 'Medium' ? 'selected' : '' }}>
                                Medium
                            </option>
                            <option value="Hard" {{ old('pk_level_pekerjaan') == 'Hard' ? 'selected' : '' }}>
                                Hard
                            </option>
                        </select>
                        {{-- icon dropdown --}}
                        <span class="pointer-events-none absolute top-1/2 right-4 -translate-y-1/2 text-gray-500">
                            <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20">
                                <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </div>
                    @error('pk_level_pekerjaan')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Durasi Pekerjaan -->
                <div>
                    <label class="block text-sm font-medium mb-1">Durasi Pekerjaan / Hari</label>
                    <input type="number" name="pk_estimasi_durasi_hari" value="{{ old('pk_estimasi_durasi_hari') }}"
                        placeholder="Inputkan durasi pekerjaan..." class="h-11 w-full rounded-lg border px-4 text-sm
            @error('pk_estimasi_durasi_hari') border-red-500 @else border-gray-300 @enderror">

                    @error('pk_estimasi_durasi_hari')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi Pekerjaan -->
                <div>
                    <label class="block text-sm font-medium mb-1">Deskripsi Pekerjaan</label>
                    <textarea name="pk_deskripsi_pekerjaan" placeholder="Inputkan deskripsi pekerjaan..."
                        class="h-24 w-full rounded-lg border px-4 py-2 text-sm
            @error('pk_deskripsi_pekerjaan') border-red-500 @else border-gray-300 @enderror">{{ old('pk_deskripsi_pekerjaan') }}</textarea>

                    @error('pk_deskripsi_pekerjaan')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Minimal Skill -->
                <div>
                    <label class="block text-sm font-medium mb-1">Skill yang Dibutuhkan</label>
                    <textarea name="pk_minimal_skill" placeholder="Inputkan skill yang dibutuhkan..."
                        class="h-24 w-full rounded-lg border px-4 py-2 text-sm
            @error('pk_minimal_skill') border-red-500 @else border-gray-300 @enderror">{{ old('pk_minimal_skill') }}</textarea>

                    @error('pk_minimal_skill')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                {{-- Tambahkan field lainnya di sini sama persis dengan add.blade --}}

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" class="modal-close-btn w-24 rounded-lg border px-4 py-2 text-sm bg-red-500 text-white hover:bg-red-600">Tutup</button>
                    <button type="button" id="btnUpdatePekerjaan" class="w-24 bg-brand-500 hover:bg-brand-600 rounded-lg px-4 py-2 text-sm text-white disabled:bg-grey-400">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).on('click', '.btn-edit', function () {
        const id = $(this).data('id');
        Swal.fire({ title: 'Mengambil data...', allowOutsideClick: false, showConfirmButton: false, didOpen: () => Swal.showLoading() });

        $.ajax({
            url: `/pekerjaan/${id}/edit`,
            type: 'GET',
            success: function (res) {
                Swal.close();
                const data = res.data;
                const form = $('#submitFormEditPekerjaan');
                form.attr('action', `/pekerjaan/${id}/update`);

                form.find('[name="pk_nama_pekerjaan"]').val(data.pk_nama_pekerjaan);
                // Tambahkan mapping field lainnya di sini...

                $('#eventEditModal').removeClass('hidden');
                $('body').addClass('overflow-hidden');
            }
        });
    });

    $(document).on('click', '.modal-close-btn', function() {
        $('#eventEditModal').addClass('hidden');
        $('body').removeClass('overflow-hidden');
    });

    $('#btnUpdatePekerjaan').on('click', function (e) {
        e.preventDefault();
        const form = $('#submitFormEditPekerjaan');
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function (res) {
                Swal.fire({ icon: 'success', title: 'Berhasil!', text: res.message, timer: 1500, showConfirmButton: false });
                $('#eventEditModal').addClass('hidden');
                window.table.ajax.reload(null, false);
            }
        });
    });

<div id="eventEditModal" class="fixed inset-0 z-999999 hidden p-5 overflow-y-auto" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-400/50 backdrop-blur-sm"></div>
    <div class="min-h-full flex items-center justify-center">
        <div class="modal-dialog relative w-full max-w-[700px] rounded-3xl bg-white p-6 lg:p-11 ">
            <button type="button" class="modal-close-btn absolute top-5 right-5 flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200 dark:bg-white/5">
                ✕
            </button>

            <form id="submitFormEditPekerjaan" class="flex flex-col gap-6" action="" method="POST">
                @csrf
                @method('PUT')
                <div>
                    <h5 class="font-semibold text-gray-800 text-xl dark:text-white">Edit Data Pekerjaan</h5>
                    <p class="text-sm text-gray-500">Silahkan perbarui field tipe pekerjaan di bawah ini.</p>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Kode Tipe Pekerjaan</label>
                        <input type="text" name="pk_kode_tipe_pekerjaan" class="form-input h-11 w-full rounded-lg border border-gray-300 px-4 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Nama Pekerjaan</label>
                        <input type="text" name="pk_nama_pekerjaan" class="form-input h-11 w-full rounded-lg border border-gray-300 px-4 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Level</label>
                        <select name="pk_level_pekerjaan" class="h-11 w-full rounded-lg border border-gray-300 px-4 text-sm">
                            <option value="Easy">Easy</option>
                            <option value="Medium">Medium</option>
                            <option value="Hard">Hard</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Estimasi Hari</label>
                        <input type="number" name="pk_estimasi_durasi_hari" class="form-input h-11 w-full rounded-lg border border-gray-300 px-4 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Deskripsi</label>
                        <textarea name="pk_deskripsi_pekerjaan" class="h-24 w-full rounded-lg border border-gray-300 px-4 py-2 text-sm"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Minimal Skill</label>
                        <textarea name="pk_minimal_skill" class="h-24 w-full rounded-lg border border-gray-300 px-4 py-2 text-sm"></textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" class="modal-close-btn w-24 rounded-lg border py-2 bg-red-500 text-white hover:bg-red-600">Tutup</button>
                    <button type="button" id="btnUpdatePekerjaan" class="w-24 bg-brand-500 hover:bg-brand-600 rounded-lg py-2 text-white">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Fungsi Tombol Tutup
    $(document).on('click', '.modal-close-btn', function() {
        $('#eventEditModal').addClass('hidden');
        $('body').removeClass('overflow-hidden');
    });

    // Fungsi Tombol Simpan (Update)
    $(document).on('click', '#btnUpdatePekerjaan', function(e) {
        e.preventDefault();
        const form = $('#submitFormEditPekerjaan');
        const btn = $(this);

        btn.prop('disabled', true).text('Menyimpan...');

        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(res) {
                Swal.fire({ icon: 'success', title: 'Berhasil!', text: res.message, timer: 1500, showConfirmButton: false });
                $('#eventEditModal').addClass('hidden');
                $('body').removeClass('overflow-hidden');
                window.table.ajax.reload(null, false);
            },
            error: function() {
                Swal.fire('Error', 'Gagal memperbarui data', 'error');
            },
            complete: () => btn.prop('disabled', false).text('Simpan')
        });
    });
</script>
@endpush

