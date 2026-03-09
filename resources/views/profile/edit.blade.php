<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

    @if(auth()->user()->role === 'intern')

<div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg mt-6">
    <div class="max-w-xl">
        <h5 class="font-semibold text-gray-800 text-xl dark:text-white mb-1">
            Data Akademik
        </h5>
        <p class="text-sm text-gray-500 mb-6">
            Silahkan lengkapi data akademik anda.
        </p>

        <div class="grid grid-cols-1 gap-4">

            <!-- NIM -->
            <div>
                <label class="block text-sm font-medium mb-1">NIM</label>
                <input type="text" name="pr_nim"
                    value="{{ old('pr_nim', $profile->pr_nim) }}"
                    placeholder="Masukkan NIM..."
                    class="h-11 w-full rounded-lg border px-4 text-sm
                    @error('pr_nim') border-red-500 @else border-gray-300 @enderror">

                @error('pr_nim')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kampus -->
            <div>
                <label class="block text-sm font-medium mb-1">Kampus</label>
                <select name="pr_kampus_id"
                    class="h-11 w-full rounded-lg border px-4 text-sm
                    @error('pr_kampus_id') border-red-500 @else border-gray-300 @enderror">

                    <option value="">-- Pilih Kampus --</option>

                    @foreach($kampusList as $kampus)
                    <option value="{{ $kampus->km_id }}"
                        {{ $profile->pr_kampus_id == $kampus->km_id ? 'selected' : '' }}>
                        {{ $kampus->km_nama_kampus }}
                    </option>
                    @endforeach
                </select>

                @error('pr_kampus_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jurusan -->
            <div>
                <label class="block text-sm font-medium mb-1">Jurusan</label>
                <input type="text" name="pr_jurusan"
                    value="{{ old('pr_jurusan', $profile->pr_jurusan) }}"
                    placeholder="Masukkan jurusan..."
                    class="h-11 w-full rounded-lg border px-4 text-sm
                    @error('pr_jurusan') border-red-500 @else border-gray-300 @enderror">

                @error('pr_jurusan')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

        </div>
    </div>
</div>

@endif



@if(auth()->user()->role === 'admin')

<div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg mt-6">
    <div class="max-w-xl">

        <h5 class="font-semibold text-gray-800 text-xl dark:text-white mb-1">
            Data Admin
        </h5>
        <p class="text-sm text-gray-500 mb-6">
            Silahkan lengkapi data admin berikut.
        </p>

        <div class="grid grid-cols-1 gap-4">

            <!-- NIP -->
            <div>
                <label class="block text-sm font-medium mb-1">NIP</label>
                <input type="text" name="pr_nip"
                    value="{{ old('pr_nip', $profile->pr_nip) }}"
                    placeholder="Masukkan NIP..."
                    class="h-11 w-full rounded-lg border px-4 text-sm
                    @error('pr_nip') border-red-500 @else border-gray-300 @enderror">

                @error('pr_nip')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Posisi -->
            <div>
                <label class="block text-sm font-medium mb-1">Posisi</label>
                <input type="text" name="pr_posisi"
                    value="{{ old('pr_posisi', $profile->pr_posisi) }}"
                    placeholder="Masukkan posisi..."
                    class="h-11 w-full rounded-lg border px-4 text-sm
                    @error('pr_posisi') border-red-500 @else border-gray-300 @enderror">

                @error('pr_posisi')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

        </div>
    </div>
</div>

@endif
</x-app-layout>
