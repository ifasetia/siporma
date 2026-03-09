@extends('layouts.template')

@section('content')
<div x-data="{
    isProfileInfoModal: false,
    modalPassword: false
}">
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
        <h3 class="mb-5 text-lg font-semibold text-gray-800 dark:text-white/90 lg:mb-7">Profile</h3>
        @if (session('status'))
            <div class="mb-5 rounded-xl border border-green-200 bg-green-50 p-4 text-green-700">
                <div class="flex items-center gap-3">
                    <i class="fas fa-check-circle text-green-600"></i>
                    <span class="text-sm font-semibold">
                        {{ session('status') }}
                    </span>
                </div>
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
                <ul class="text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li class="flex items-center gap-2">
                            <i class="fas fa-exclamation-circle text-red-500"></i>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="p-5 mb-6 border border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6">
            <div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between w-full">
                <div class="flex items-center gap-6">
                    <div
                        class="w-20 h-20 overflow-hidden border border-gray-200 rounded-full bg-gray-100 flex items-center justify-center">
                        @if($profile && $profile->pr_photo)
                        <img src="{{ Storage::url($profile->pr_photo) }}" class="object-cover w-full h-full" />
                        @else
                        <span class="text-2xl font-bold text-blue-600">{{ substr($user->name, 0, 1) }}</span>
                        @endif

                    </div>
                    <div class="flex items-center gap-3">
                        <h4 class="text-lg font-semibold text-gray-800">
                            {{ $profile->pr_nama ?? $user->name }}
                        </h4>

                        @if(strtolower($profile?->pr_status) === 'aktif')
                        <span class="px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">
                            Aktif
                        </span>
                        @elseif($profile?->pr_status === 'nonaktif')
                        <span class="px-3 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">
                            Nonaktif
                        </span>
                        @else
                        <span class="px-3 py-1 text-xs font-semibold text-gray-700 bg-gray-100 rounded-full">
                            Menunggu
                        </span>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    @foreach([
                    'facebook' => ['icon' => 'fab fa-facebook-f', 'name' => 'Facebook', 'base' =>
                    'https://facebook.com/'],
                    'instagram' => ['icon' => 'fab fa-instagram', 'name' => 'Instagram', 'base' =>
                    'https://instagram.com/'],
                    'linkedin' => ['icon' => 'fab fa-linkedin-in', 'name' => 'LinkedIn', 'base' =>
                    'https://linkedin.com/in/'],
                    'github' => ['icon' => 'fab fa-github', 'name' => 'GitHub', 'base' => 'https://github.com/'],
                    'whatsapp' => ['icon' => 'fab fa-whatsapp', 'name' => 'WhatsApp', 'base' => 'https://wa.me/']
                    ] as $key => $data)

                    @php
                    $field = "pr_$key";
                    $username = $profile->$field ?? null;

                    if ($username) {
                    // khusus WhatsApp → hanya angka
                    if ($key === 'whatsapp') {
                    $username = preg_replace('/[^0-9]/', '', $profile->pr_whatsapp);
                    }
                    $url = $data['base'] . $username;
                    }
                    @endphp

                    @if(!empty($username))
                    <a href="{{ $url }}" title="{{ $data['name'] }}" target="_blank" rel="noopener noreferrer"
                        class="flex h-10 w-10 items-center justify-center rounded-full border border-gray-200 text-gray-500 hover:bg-gray-100 transition-all shadow-sm">
                        <i class="{{ $data['icon'] }}"></i>
                    </a>

                    @endif

                    @endforeach
                    <button type="button" title="Ganti Password" @click="modalPassword = true"
                        class="flex h-10 w-10 items-center justify-center rounded-full border border-gray-200 text-gray-500 hover:bg-gray-100 transition-all shadow-sm">
                        <i class="fas fa-key"></i>
                    </button>

                    <button type="button" @click="isProfileInfoModal = true"
                        class="ml-4 flex items-center gap-2 rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition shadow-sm">
                        <i class="fas fa-pencil-alt text-xs"></i> Edit Profil
                    </button>

                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-700">
            <div class="p-6 border border-gray-200 rounded-2xl">
                <h4 class="text-lg font-bold mb-6">Informasi Personal</h4>
                <div class="space-y-4 text-sm">
                    <p><span class="text-gray-400 block text-xs font-bold uppercase mb-1">Email</span>
                        {{ $user->email }}</p>
                    <p><span class="text-gray-400 block text-xs font-bold uppercase mb-1">Nomor HP</span>
                        {{ $profile->pr_no_hp ?? '-' }}</p>
                    <p><span class="text-gray-400 block text-xs font-bold uppercase mb-1">Jenis Kelamin</span>
                        {{ $profile->pr_jenis_kelamin ?? '-' }}</p>
                    <p><span class="text-gray-400 block text-xs font-bold uppercase mb-1">Tanggal Lahir</span>
                        {{ $profile->pr_tanggal_lahir ? \Carbon\Carbon::parse($profile->pr_tanggal_lahir)->format('d M Y') : '-' }}
                    </p>
                    @if(auth()->user()->role === 'admin')
                    <p><span class="text-gray-400 block text-xs font-bold uppercase mb-1">Alamat</span>
                        {{ $profile->pr_alamat ?? '-' }}</p>
                    @endif
                </div>
            </div>
            @if(auth()->user()->role === 'intern')
            <div class="p-6 border border-gray-200 rounded-2xl">
                <h4 class="text-lg font-bold mb-6">Pendidikan & Alamat</h4>
                <div class="space-y-4 text-sm">
                    <p><span class="text-gray-400 block text-xs font-bold uppercase mb-1">Asal Kampus</span>
                        {{ $profile->kampus->km_nama_kampus ?? '-' }}</p>
                    <p><span class="text-gray-400 block text-xs font-bold uppercase mb-1">Alamat</span>
                        {{ $profile->pr_alamat ?? '-' }}</p>
                    <p><span class="text-gray-400 block text-xs font-bold uppercase mb-1">Jurusan</span>
                        {{ $profile->jurusan->js_nama ?? '-' }}</p>
                    <p><span class="text-gray-400 block text-xs font-bold uppercase mb-1">Tipe Pekerjaan</span>
                        {{ $profile->pekerjaan->pk_nama_pekerjaan ?? '-' }}</p>
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

    <div x-show="isProfileInfoModal" class="fixed inset-0 z-[9999999] p-5 overflow-y-auto" x-cloak>
        <div class="fixed inset-0 bg-gray-400/50 backdrop-blur-sm" @click="isProfileInfoModal = false"></div>

        <div class="min-h-full flex items-center justify-center">
            <div class="relative w-full max-w-[700px] rounded-[32px] bg-white p-6 lg:p-11 shadow-2xl"
                @click.away="isProfileInfoModal = false">

                <button type="button" @click="isProfileInfoModal = false"
                    class="absolute top-5 right-5 flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200 transition">
                    ✕
                </button>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data"
                    class="flex flex-col gap-6 text-gray-800">
                    @csrf
                    @method('PATCH')

                    <div class="pb-6">
                        <h4 class="text-lg font-semibold mb-4">Data Pribadi</h4>
                        <p class="text-sm text-gray-500">Silahkan perbarui data diri dan keamanan akun kamu di sini.</p>
                        <div class="p-5 bg-gray-50 rounded-2xl border border-dashed border-gray-300">

                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">
                                Update Foto
                            </label>

                            {{-- INPUT FILE --}}
                            <input type="file" name="pr_photo" accept="image/*" class="block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-gray-200 file:text-gray-700
                                    hover:file:bg-gray-300 cursor-pointer" />

                        </div>
                        @if($profile->pr_photo)
                        <div class="mb-4 flex flex-col items-center">
                            <p class="text-xs text-gray-500 mb-2">Foto Saat Ini:</p>
                            <img src="{{ Storage::url($profile->pr_photo) }}" alt="Foto Profile"
                                class="w-32 h-32 object-cover rounded-full border shadow">
                        </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex flex-col gap-1">
                                <label>Nama Lengkap</label>
                                <input type="text" name="pr_nama"
                                    value="{{ old('pr_nama', $profile->pr_nama ?? $user->name) }}"
                                    class="form-input h-11 rounded-lg border border-gray-300 px-4 text-sm">
                            </div>

                            <div class="flex flex-col gap-1">
                                <label>Nomor HP</label>
                                <input type="text" name="pr_no_hp" value="{{ old('pr_no_hp', $profile->pr_no_hp) }}"
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
                    <div class="py-6">
                        <h4 class="text-lg font-semibold mb-4">Data Akademik</h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <div class="flex flex-col gap-1">
                                <label>NIM</label>
                                <input type="text" name="pr_nim" value="{{ old('pr_nim', $profile->pr_nim) }}"
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
                    <div class="mt-6 pt-6">
                        <h4 class="text-lg font-semibold mb-4">Data Kepegawaian</h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <div class="flex flex-col gap-1">
                                <label>NIP</label>
                                <input type="text" name="pr_nip" value="{{ old('pr_nip', $profile->pr_nip) }}"
                                    class="form-input h-11 rounded-lg border border-gray-300 px-4 text-sm">
                            </div>

                            <div class="flex flex-col gap-1">
                                <label>Posisi</label>
                                <input type="text" name="pr_posisi" value="{{ old('pr_posisi', $profile->pr_posisi) }}"
                                    class="form-input h-11 rounded-lg border border-gray-300 px-4 text-sm">
                            </div>

                        </div>
                    </div>
                    @endif


                    <div class="mt-6 pt-6">
                        <h4 class="text-lg font-semibold mb-4">Sosial Media</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- Instagram --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-2">
                                    <i class="fab fa-instagram text-pink-500 mr-1"></i> Instagram
                                </label>
                                <div
                                    class="flex rounded-xl border border-gray-300 overflow-hidden focus-within:ring-2 focus-within:ring-pink-400 transition">
                                    <span class="bg-gray-100 px-3 flex items-center text-sm text-gray-500">
                                        instagram.com/
                                    </span>
                                    <input type="text" name="pr_instagram"
                                        value="{{ old('pr_instagram', $profile->pr_instagram) }}" placeholder="username"
                                        class="w-full px-4 py-2 text-sm focus:outline-none">
                                </div>
                            </div>

                            {{-- LinkedIn --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-2">
                                    <i class="fab fa-linkedin text-blue-600 mr-1"></i> LinkedIn
                                </label>
                                <div
                                    class="flex rounded-xl border border-gray-300 overflow-hidden focus-within:ring-2 focus-within:ring-blue-400 transition">
                                    <span class="bg-gray-100 px-3 flex items-center text-sm text-gray-500">
                                        linkedin.com/in/
                                    </span>
                                    <input type="text" name="pr_linkedin"
                                        value="{{ old('pr_linkedin', $profile->pr_linkedin) }}" placeholder="username"
                                        class="w-full px-4 py-2 text-sm focus:outline-none">
                                </div>
                            </div>

                            {{-- GitHub --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-2">
                                    <i class="fab fa-github text-gray-800 mr-1"></i> GitHub
                                </label>
                                <div
                                    class="flex rounded-xl border border-gray-300 overflow-hidden focus-within:ring-2 focus-within:ring-gray-400 transition">
                                    <span class="bg-gray-100 px-3 flex items-center text-sm text-gray-500">
                                        github.com/
                                    </span>
                                    <input type="text" name="pr_github"
                                        value="{{ old('pr_github', $profile->pr_github) }}" placeholder="username"
                                        class="w-full px-4 py-2 text-sm focus:outline-none">
                                </div>
                            </div>

                            {{-- WhatsApp --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-2">
                                    <i class="fab fa-whatsapp text-green-500 mr-1"></i> WhatsApp
                                </label>
                                <div
                                    class="flex rounded-xl border border-gray-300 overflow-hidden focus-within:ring-2 focus-within:ring-green-400 transition">
                                    <span class="bg-gray-100 px-3 flex items-center text-sm text-gray-500">
                                        wa.me/
                                    </span>
                                    <input type="text" name="pr_whatsapp"
                                        value="{{ old('pr_whatsapp', $profile->pr_whatsapp) }}"
                                        placeholder="628xxxxxxxxxx" class="w-full px-4 py-2 text-sm focus:outline-none">
                                </div>
                            </div>

                            {{-- Facebook --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-600 mb-2">
                                    <i class="fab fa-facebook text-blue-500 mr-1"></i> Facebook
                                </label>
                                <div
                                    class="flex rounded-xl border border-gray-300 overflow-hidden focus-within:ring-2 focus-within:ring-blue-400 transition">
                                    <span class="bg-gray-100 px-3 flex items-center text-sm text-gray-500">
                                        facebook.com/
                                    </span>
                                    <input type="text" name="pr_facebook"
                                        value="{{ old('pr_facebook', $profile->pr_facebook) }}" placeholder="username"
                                        class="w-full px-4 py-2 text-sm focus:outline-none">
                                </div>
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
    <div x-show="modalPassword" class="fixed inset-0 z-[999999] p-5 overflow-y-auto" x-cloak>
        <div class="fixed inset-0 bg-gray-400/50 backdrop-blur-sm" @click="modalPassword = false"></div>

        <div class="min-h-full flex items-center justify-center">
            <div class="relative w-full max-w-[700px] rounded-[32px] bg-white p-6 lg:p-11 shadow-2xl"
                @click.away="modalPassword = false">

                <button type="button" @click="modalPassword = false"
                    class="absolute top-5 right-5 flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200 transition">
                    ✕
                </button>

                <form action="{{ route('profile.update-password') }}" method="POST" enctype="multipart/form-data"
                    class="flex flex-col gap-6 text-gray-800">
                    @csrf
                    @method('PATCH')
                    <div class="mt-8 pt-8 bg-gray-50 p-6 rounded-2xl shadow-sm">
                        <h4 class="text-lg font-semibold mb-4">Ganti Password</h4>
                        <label class="text-sm font-semibold text-red-500 mb-6 flex items-center gap-2">
                            <i class="fas fa-lock"></i>
                            Ganti Password <span class="text-gray-400 font-normal">(Opsional)</span>
                        </label>

                        <div class="flex flex-col gap-5">

                            {{-- Current Password --}}
                            <div class="relative">
                                <input type="password" name="current_password" id="current_password"
                                    placeholder="Password Saat Ini"
                                    class="w-full h-11 rounded-xl border border-gray-300 px-4 pr-12 text-sm focus:ring-2 focus:ring-red-400 focus:outline-none transition">
                                <button type="button" onclick="togglePassword('current_password')"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>

                            {{-- New Password + Confirmation --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                <div class="relative">
                                    <input type="password" name="new_password" id="new_password" placeholder="Password Baru"
                                        class="w-full h-11 rounded-xl border border-gray-300 px-4 pr-12 text-sm focus:ring-2 focus:ring-red-400 focus:outline-none transition">
                                    <button type="button" onclick="togglePassword('new_password')"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="relative">
                                    <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                        placeholder="Konfirmasi Password" disabled class="w-full h-11 rounded-xl border border-gray-300 px-4 pr-12 text-sm
                                    focus:ring-2 focus:ring-red-400 focus:outline-none
                                    transition disabled:bg-gray-100 disabled:cursor-not-allowed">
                                    <button type="button"
                                        onclick="togglePassword('new_password_confirmation')"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="mt-3 space-y-2">
                                    {{-- Strength Bar --}}
                                    <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                        <div id="strength-bar" class="h-2 w-0 bg-red-500 transition-all duration-300">
                                        </div>
                                    </div>

                                    {{-- Strength Text --}}
                                    <div id="password-strength" class="text-xs font-semibold"></div>

                                    {{-- Requirement Checklist --}}
                                    <ul class="text-xs space-y-1 mt-2">
                                        <li id="length" data-label="Minimal 8 karakter"
                                            class="flex items-center gap-2 text-gray-400">
                                            <span class="icon">•</span>
                                            <span>Minimal 8 karakter</span>
                                        </li>
                                        <li id="uppercase" data-label="Huruf besar (A-Z)"
                                            class="flex items-center gap-2 text-gray-400">
                                            <span class="icon">•</span>
                                            <span>Huruf besar (A-Z)</span>
                                        </li>
                                        <li id="lowercase" data-label="Huruf kecil (a-z)"
                                            class="flex items-center gap-2 text-gray-400">
                                            <span class="icon">•</span>
                                            <span>Huruf kecil (a-z)</span>
                                        </li>
                                        <li id="number" data-label="Angka (0-9)"
                                            class="flex items-center gap-2 text-gray-400">
                                            <span class="icon">•</span>
                                            <span>Angka (0-9)</span>
                                        </li>
                                        <li id="symbol" data-label="Simbol (@$!%*#?&)"
                                            class="flex items-center gap-2 text-gray-400">
                                            <span class="icon">•</span>
                                            <span>Simbol (@$!%*#?&)</span>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" @click="modalPassword = false"
                            class="w-24 rounded-lg border border-gray-300 px-4 py-2 text-sm bg-red-500 text-white hover:bg-red-600 transition">
                            Tutup
                        </button>
                        <button type="submit"
                            id="submitPasswordBtn"
                            disabled
                            class="w-24 bg-blue-600 hover:bg-blue-700 rounded-lg px-4 py-2 text-sm text-white shadow-md
                            active:scale-95 transition disabled:bg-gray-300 disabled:cursor-not-allowed disabled:shadow-none">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- NOTIFIKASI LOADING (Sama Persis Data User) --}}
    <div id="loadingOverlay" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-[999999999]">
        <div class="bg-white px-6 py-4 rounded-lg shadow-lg flex items-center gap-3">
            <svg class="animate-spin h-10 w-10 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
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
        function togglePassword(id) {
        const input = document.getElementById(id);
        const icon = input.parentElement.querySelector("i");

        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            input.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }
document.addEventListener('DOMContentLoaded', function () {

    const passwordInput = document.getElementById('new_password');
    const confirmInput = document.getElementById('new_password_confirmation');
    const currentInput = document.getElementById('current_password');
    const submitBtn = document.getElementById('submitPasswordBtn');
    const strengthBar = document.getElementById('strength-bar');
    const strengthText = document.getElementById('password-strength');
    const toggleConfirmBtn = document.getElementById('toggleConfirmBtn');

    const mismatchText = document.createElement('p');
    mismatchText.className = "text-xs font-semibold mt-1";
    confirmInput.parentElement.appendChild(mismatchText);

    function updateChecklist(id, valid) {
        const el = document.getElementById(id);
        const icon = el.querySelector('.icon');

        if (valid) {
            el.classList.remove('text-gray-400');
            el.classList.add('text-green-600');
            icon.innerHTML = "✔";
        } else {
            el.classList.remove('text-green-600');
            el.classList.add('text-gray-400');
            icon.innerHTML = "•";
        }
    }

    function validatePassword() {

        const value = passwordInput.value;
        const confirmValue = confirmInput.value;
        const currentValue = currentInput.value;

        const rules = {
            length: value.length >= 8,
            uppercase: /[A-Z]/.test(value),
            lowercase: /[a-z]/.test(value),
            number: /[0-9]/.test(value),
            symbol: /[@$!%*#?&]/.test(value)
        };

        // Update checklist
        updateChecklist("length", rules.length);
        updateChecklist("uppercase", rules.uppercase);
        updateChecklist("lowercase", rules.lowercase);
        updateChecklist("number", rules.number);
        updateChecklist("symbol", rules.symbol);

        let strength = Object.values(rules).filter(Boolean).length;
        let percentage = (strength / 5) * 100;
        strengthBar.style.width = percentage + "%";

        // Enable confirm only if very strong
        if (strength === 5) {
            confirmInput.disabled = false;
            passwordInput.classList.remove('border-red-400');
            passwordInput.classList.add('border-green-500');
        } else {
            confirmInput.disabled = true;
            confirmInput.value = "";
            passwordInput.classList.remove('border-green-500');
            if (value.length > 0) {
                passwordInput.classList.add('border-red-400');
            }
        }

        // Strength Text
        if (value.length === 0) {
            strengthText.textContent = "";
            strengthBar.style.width = "0%";
            passwordInput.classList.remove('border-red-400','border-green-500');
        } else if (strength <= 2) {
            strengthText.textContent = "🔴 Password Lemah";
            strengthBar.className = "h-2 bg-red-500 transition-all duration-300";
        } else if (strength <= 4) {
            strengthText.textContent = "🟡 Password Sedang";
            strengthBar.className = "h-2 bg-yellow-500 transition-all duration-300";
        } else {
            strengthText.textContent = "🟢 Password Sangat Kuat";
            strengthBar.className = "h-2 bg-green-600 transition-all duration-300";
        }

        // Confirm validation
        if (confirmValue.length > 0) {
            if (confirmValue === value) {
                confirmInput.classList.remove('border-red-400');
                confirmInput.classList.add('border-green-500');
                mismatchText.textContent = "✔ Password cocok";
                mismatchText.classList.remove('text-red-500');
                mismatchText.classList.add('text-green-600');
            } else {
                confirmInput.classList.add('border-red-400');
                confirmInput.classList.remove('border-green-500');
                mismatchText.textContent = "❌ Password tidak sama";
                mismatchText.classList.remove('text-green-600');
                mismatchText.classList.add('text-red-500');
            }
        } else {
            mismatchText.textContent = "";
            confirmInput.classList.remove('border-red-400','border-green-500');
        }

        // Final button validation
        if (
            strength === 5 &&
            confirmValue === value &&
            currentValue.length > 0
        ) {
            submitBtn.disabled = false;
        } else {
            submitBtn.disabled = true;
        }
    }

    if (passwordInput) {
        passwordInput.addEventListener('input', validatePassword);
        confirmInput.addEventListener('input', validatePassword);
        currentInput.addEventListener('input', validatePassword);
    }


    // Loading overlay
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function () {
            document.getElementById('loadingOverlay')
                .classList.remove('hidden');
            document.getElementById('loadingOverlay')
                .classList.add('flex');
        });
    });

});
</script>
    @endpush
    @endsection
