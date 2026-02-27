@extends('layouts.template')

@section('title','Profile Saya')

@section('content')
<div x-data="{ isProfileInfoModal: false }">
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
        <h3 class="mb-5 text-lg font-semibold text-gray-800 dark:text-white/90 lg:mb-7">Profile</h3>

        <div class="p-5 mb-6 border border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6">
            <div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between w-full">
                <div class="flex items-center gap-6">
                    <div class="w-20 h-20 overflow-hidden border border-gray-200 rounded-full bg-gray-100 flex items-center justify-center">
                        @if($profile && $profile->pr_photo)
                            <img src="{{ asset('storage/' . $profile->pr_photo) }}" class="object-cover w-full h-full" />
                        @else
                            <span class="text-2xl font-bold text-blue-600">{{ substr($user->name, 0, 1) }}</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-3">
                        <h4 class="text-lg font-semibold text-gray-800">
                            {{ $profile->pr_nama ?? $user->name }}
                        </h4>

                        @if($profile->pr_status === 'Aktif')
                            <span class="px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">
                                Aktif
                            </span>
                        @elseif($profile->pr_status === 'Nonaktif')
                            <span class="px-3 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">
                                Nonaktif
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs font-semibold text-gray-700 bg-gray-100 rounded-full">
                                Belum Ditentukan
                            </span>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    @foreach(['facebook' => 'fab fa-facebook-f', 'instagram' => 'fab fa-instagram', 'linkedin' => 'fab fa-linkedin-in', 'github' => 'fab fa-github', 'whatsapp' => 'fab fa-whatsapp'] as $key => $icon)
                        @php $field = "pr_$key"; @endphp
                        @if($profile->$field)
                            <a href="{{ $key === 'whatsapp' ? 'https://wa.me/'.$profile->$field : $profile->$field }}" target="_blank"
                            class="flex h-10 w-10 items-center justify-center rounded-full border border-gray-200 text-gray-500 hover:bg-gray-100 transition-all shadow-sm">
                                <i class="{{ $icon }}"></i>
                            </a>
                        @endif
                    @endforeach
                    <button @click="isProfileInfoModal = true" class="ml-4 flex items-center gap-2 rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition shadow-sm">
                        <i class="fas fa-pencil-alt text-xs"></i> Edit Profil
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-700">
            <div class="p-6 border border-gray-200 rounded-2xl">
                <h4 class="text-lg font-bold mb-6">Informasi Personal</h4>
                <div class="space-y-4 text-sm">
                    <p><span class="text-gray-400 block text-xs font-bold uppercase mb-1">Email</span> {{ $user->email }}</p>
                    <p><span class="text-gray-400 block text-xs font-bold uppercase mb-1">Nomor HP</span> {{ $profile->pr_no_hp ?? '-' }}</p>
                    <p><span class="text-gray-400 block text-xs font-bold uppercase mb-1">Jenis Kelamin</span> {{ $profile->pr_jenis_kelamin ?? '-' }}</p>
                    <p><span class="text-gray-400 block text-xs font-bold uppercase mb-1">Tanggal Lahir</span> {{ $profile->pr_tanggal_lahir ? \Carbon\Carbon::parse($profile->pr_tanggal_lahir)->format('d M Y') : '-' }}</p>
                    @if(auth()->user()->role === 'admin')
                    <p><span class="text-gray-400 block text-xs font-bold uppercase mb-1">Alamat</span> {{ $profile->pr_alamat ?? '-' }}</p>
                    @endif
                </div>
            </div>
            @if(auth()->user()->role === 'intern')
            <div class="p-6 border border-gray-200 rounded-2xl">
                <h4 class="text-lg font-bold mb-6">Pendidikan & Alamat</h4>
                <div class="space-y-4 text-sm">
                    <p><span class="text-gray-400 block text-xs font-bold uppercase mb-1">Asal Kampus</span> {{ $profile->kampus->km_nama_kampus ?? '-' }}</p>
                    <p><span class="text-gray-400 block text-xs font-bold uppercase mb-1">Alamat</span> {{ $profile->pr_alamat ?? '-' }}</p>
                    <p><span class="text-gray-400 block text-xs font-bold uppercase mb-1">Jurusan</span> {{ $profile->jurusan->js_nama ?? '-' }}</p>
                    <p><span class="text-gray-400 block text-xs font-bold uppercase mb-1">Tipe Pekerjaan</span> {{ $profile->pekerjaan->pk_nama_pekerjaan ?? '-' }}</p>
                </div>
            </div>
            @endif

            @if(auth()->user()->role === 'admin')
                <div class="p-6 border border-gray-200 rounded-2xl">
                    <h4 class="text-lg font-bold mb-6">Data Kepegawaian</h4>

                    <div class="space-y-4 text-sm">
                        <p>
                            <span class="text-gray-400 block text-xs font-bold uppercase mb-1">
                                NIP
                            </span>
                            {{ $profile->pr_nip ?? '-' }}
                        </p>

                        <p>
                            <span class="text-gray-400 block text-xs font-bold uppercase mb-1">
                                Posisi
                            </span>
                            {{ $profile->pr_posisi ?? '-' }}
                        </p>
                    </div>
                </div>
                @endif
        </div>
    </div>

    <div x-show="isProfileInfoModal" class="fixed inset-0 z-[99999] p-5 overflow-y-auto" x-cloak>
        <div class="fixed inset-0 bg-gray-400/50 backdrop-blur-sm" @click="isProfileInfoModal = false"></div>

        <div class="min-h-full flex items-center justify-center">
            <div class="relative w-full max-w-[700px] rounded-[32px] bg-white p-6 lg:p-11 shadow-2xl" @click.away="isProfileInfoModal = false">

                <button type="button" @click="isProfileInfoModal = false"
                    class="absolute top-5 right-5 flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200 transition">
                    ✕
                </button>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-6 text-gray-800">
                    @csrf
                    @method('PATCH')

                    <div class="border-b pb-6">
                        <h4 class="text-lg font-semibold mb-4">Data Pribadi</h4>
                        <p class="text-sm text-gray-500">Silahkan perbarui data diri dan keamanan akun kamu di sini.</p>
        

                    <div class="p-5 bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Update Foto</label>
                        <input type="file" name="pr_photo" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-200 file:text-gray-700 hover:file:bg-gray-300 cursor-pointer"/>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1">
                            <label>Nama Lengkap</label>
                            <input type="text" name="pr_nama"
                                value="{{ old('pr_nama', $profile->pr_nama ?? $user->name) }}"
                                class="form-input h-11 rounded-lg border border-gray-300 px-4 text-sm">
                        </div>

                        <div class="flex flex-col gap-1">
                            <label>Nomor HP</label>
                            <input type="text" name="pr_no_hp"
                                value="{{ old('pr_no_hp', $profile->pr_no_hp) }}"
                                class="form-input h-11 rounded-lg border border-gray-300 px-4 text-sm">
                        </div>

                        <div class="flex flex-col gap-1">
                            <label>Jenis Kelamin</label>
                            <select name="pr_jenis_kelamin"
                                class="form-input h-11 rounded-lg border border-gray-300 px-4 text-sm">
                                <option value="Laki-laki"
                                    {{ $profile->pr_jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>
                                    Laki-laki
                                </option>
                                <option value="Perempuan"
                                    {{ $profile->pr_jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan
                                </option>
                            </select>
                        </div>

                        <div class="flex flex-col gap-1">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="pr_tanggal_lahir"
                                value="{{ old('pr_tanggal_lahir', $profile->pr_tanggal_lahir) }}"
                                class="form-input h-11 rounded-lg border border-gray-300 px-4 text-sm">
                        </div>

                        <div class="md:col-span-2 flex flex-col gap-1">
                            <label>Alamat</label>
                            <textarea name="pr_alamat"
                                class="form-input rounded-lg border border-gray-300 px-4 py-2 text-sm">{{ old('pr_alamat', $profile->pr_alamat) }}</textarea>
                        </div>
                    </div>
                </div>

                    @if(auth()->user()->role === 'intern')
                    <div class="border-b py-6">
                        <h4 class="text-lg font-semibold mb-4">Data Akademik</h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <div class="flex flex-col gap-1">
                                <label>NIM</label>
                                <input type="text" name="pr_nim"
                                    value="{{ old('pr_nim', $profile->pr_nim) }}"
                                    class="form-input h-11 rounded-lg border border-gray-300 px-4 text-sm">
                            </div>

                            <div class="flex flex-col gap-1">
                                <label>Kampus</label>
                                <select name="pr_kampus_id"
                                    class="form-input h-11 rounded-lg border border-gray-300 px-4 text-sm">
                                    @foreach($kampusList as $kampus)
                                        <option value="{{ $kampus->km_id }}"
                                            {{ $profile->pr_kampus_id == $kampus->km_id ? 'selected' : '' }}>
                                            {{ $kampus->km_nama_kampus }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex flex-col gap-1">
                                <label>Jurusan</label>
                                <select name="pr_jurusan"
                                    class="form-input h-11 rounded-lg border border-gray-300 px-4 text-sm">
                                    @foreach($jurusanList as $jurusan)
                                        <option value="{{ $jurusan->js_id }}"
                                            {{ $profile->pr_jurusan == $jurusan->js_id ? 'selected' : '' }}>
                                            {{ $jurusan->js_nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex flex-col gap-1">
                                <label>Tipe Pekerjaan</label>
                                <select name="pr_pekerjaan_id"
                                    class="form-input h-11 rounded-lg border border-gray-300 px-4 text-sm">
                                    @foreach($pekerjaanList as $pekerjaan)
                                        <option value="{{ $pekerjaan->pk_id_pekerjaan }}"
                                            {{ $profile->pr_pekerjaan_id == $pekerjaan->pk_id_pekerjaan ? 'selected' : '' }}>
                                            {{ $pekerjaan->pk_nama_pekerjaan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>
                    @endif

                    @if(auth()->user()->role === 'admin')
                    <div class="border-t mt-6 pt-6">
                        <h4 class="text-lg font-semibold mb-4">Data Kepegawaian</h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <div class="flex flex-col gap-1">
                                <label>NIP</label>
                                <input type="text" name="pr_nip"
                                    value="{{ old('pr_nip', $profile->pr_nip) }}"
                                    class="form-input h-11 rounded-lg border border-gray-300 px-4 text-sm">
                            </div>

                            <div class="flex flex-col gap-1">
                                <label>Posisi</label>
                                <input type="text" name="pr_posisi"
                                    value="{{ old('pr_posisi', $profile->pr_posisi) }}"
                                    class="form-input h-11 rounded-lg border border-gray-300 px-4 text-sm">
                            </div>

                        </div>
                    </div>
                    @endif


                    <div class="border-b py-6">
                        <h4 class="text-lg font-semibold mb-4">Sosial Media</h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input type="text" name="pr_instagram"
                                value="{{ $profile->pr_instagram }}"
                                placeholder="Instagram"
                                class="form-input h-11 rounded-lg border border-gray-300 px-4 text-sm">

                            <input type="text" name="pr_linkedin"
                                value="{{ $profile->pr_linkedin }}"
                                placeholder="LinkedIn"
                                class="form-input h-11 rounded-lg border border-gray-300 px-4 text-sm">

                            <input type="text" name="pr_github"
                                value="{{ $profile->pr_github }}"
                                placeholder="GitHub"
                                class="form-input h-11 rounded-lg border border-gray-300 px-4 text-sm">

                            <input type="text" name="pr_whatsapp"
                                value="{{ $profile->pr_whatsapp }}"
                                placeholder="WhatsApp"
                                class="form-input h-11 rounded-lg border border-gray-300 px-4 text-sm">
                        </div>
                    </div>

                    <div class="border-t mt-6 pt-6  p-4 rounded-2xl">
                        <label class="text-sm font-bold text-red-500 mb-4 block">Ganti Password (Opsional)</label>
                        <div class="flex flex-col gap-3">
                            <input type="password" name="current_password" placeholder="Password Saat Ini" class="form-input h-11 rounded-lg border border-gray-300 px-4 text-sm">
                            <div class="grid grid-cols-2 gap-4">
                                <input type="password" name="password" placeholder="Password Baru" class="form-input h-11 rounded-lg border border-gray-300 px-4 text-sm">
                                <input type="password" name="password_confirmation" placeholder="Konfirmasi" class="form-input h-11 rounded-lg border border-gray-300 px-4 text-sm">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" @click="isProfileInfoModal = false"
                            class="w-24 rounded-lg border border-gray-300 px-4 py-2 text-sm bg-red-500 text-white hover:bg-red-600 transition">
                            Tutup
                        </button>
                        <button type="submit"
                            class="w-24 bg-blue-600 hover:bg-blue-700 rounded-lg px-4 py-2 text-sm text-white shadow-md active:scale-95 transition">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- NOTIFIKASI LOADING (Sama Persis Data User) --}}
<div id="loadingOverlay" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-[999999]">
    <div class="bg-white px-6 py-4 rounded-lg shadow-lg flex items-center gap-3">
        <svg class="animate-spin h-10 w-10 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
        </svg>
        <span class="text-xl font-medium text-gray-700">Mohon tunggu...</span>
    </div>
</div>

{{-- Memanggil SweetAlert dari CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@push('scripts')
<script>
    document.querySelector('form').addEventListener('submit', function(e) {
        // Tampilkan Loading Overlay
        document.getElementById('loadingOverlay').classList.remove('hidden');
        document.getElementById('loadingOverlay').classList.add('flex');

        // Opsional: Gunakan SweetAlert biar makin mirip Data User
        Swal.fire({
            title: 'Menyimpan perubahan...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading()
            }
        });
    });

    // Menampilkan Notifikasi Sukses setelah Page Refresh (Logika Laravel)
    @if(session('status') === 'profile-updated')
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Profil kamu sudah diperbarui!',
            timer: 2000,
            showConfirmButton: false
        });
    @endif

</script>
@endpush
@endsection
