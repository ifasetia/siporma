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
                    <div>
                        <h4 class="mb-1 text-lg font-semibold text-gray-800 dark:text-white">
                            {{ $profile->pr_nama ?? $user->name }}
                        </h4>
                        <p class="text-sm text-gray-500">{{ $profile->pr_kampus ?? 'Dinas Kominfo & Statistik' }}</p>
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
                </div>
            </div>
            <div class="p-6 border border-gray-200 rounded-2xl">
                <h4 class="text-lg font-bold mb-6">Pendidikan & Alamat</h4>
                <div class="space-y-4 text-sm">
                    <p><span class="text-gray-400 block text-xs font-bold uppercase mb-1">Asal Kampus</span> {{ $profile->pr_kampus ?? '-' }}</p>
                    <p><span class="text-gray-400 block text-xs font-bold uppercase mb-1">Alamat</span> {{ $profile->pr_alamat ?? '-' }}</p>
                </div>
            </div>
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

                    <div>
                        <h5 class="font-semibold text-xl">Edit Informasi & Keamanan</h5>
                        <p class="text-sm text-gray-500">Silahkan perbarui data diri dan keamanan akun kamu di sini.</p>
                    </div>

                    <div class="p-5 bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Update Foto</label>
                        <input type="file" name="pr_photo" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-200 file:text-gray-700 hover:file:bg-gray-300 cursor-pointer"/>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1">
                            <label class="text-sm font-medium">Nama Lengkap</label>
                            <input type="text" name="pr_nama" value="{{ $profile->pr_nama ?? $user->name }}"
                            class="form-input h-11 rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none">
                        </div>
                        <div class="flex flex-col gap-1">
                            <label class="text-sm font-medium">Nomor HP</label>
                            <input type="text" name="pr_no_hp" value="{{ $profile->pr_no_hp }}"
                            class="form-input h-11 rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1">
                            <label class="text-sm font-medium">Jenis Kelamin</label>
                            <select name="pr_jenis_kelamin" class="form-input h-11 rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none bg-white">
                                <option value="Laki-laki" {{ ($profile->pr_jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ ($profile->pr_jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="flex flex-col gap-1">
                            <label class="text-sm font-medium">Alamat</label>
                            <input type="text" name="pr_alamat" value="{{ $profile->pr_alamat }}"
                            class="form-input h-11 rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none" placeholder="Alamat lengkap...">
                        </div>
                    </div>

                    <div class="border-t pt-4">
                        <label class="text-sm font-bold mb-4 block">Link Sosial Media</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input type="text" name="pr_instagram" value="{{ $profile->pr_instagram }}" placeholder="Link Instagram..." class="form-input h-11 rounded-lg border border-gray-300 px-4 text-sm">
                            <input type="text" name="pr_facebook" value="{{ $profile->pr_facebook }}" placeholder="Link Facebook..." class="form-input h-11 rounded-lg border border-gray-300 px-4 text-sm">
                            <input type="text" name="pr_linkedin" value="{{ $profile->pr_linkedin }}" placeholder="Link LinkedIn..." class="form-input h-11 rounded-lg border border-gray-300 px-4 text-sm">
                            <input type="text" name="pr_github" value="{{ $profile->pr_github }}" placeholder="Link GitHub..." class="form-input h-11 rounded-lg border border-gray-300 px-4 text-sm">
                            <input type="text" name="pr_whatsapp" value="{{ $profile->pr_whatsapp }}" placeholder="Nomor WhatsApp (Contoh: 628...)" class="form-input h-11 rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:outline-none">
                        </div>
                    </div>

                    <div class="border-t pt-4 bg-red-50/50 p-4 rounded-2xl">
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
