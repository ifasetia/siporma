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

    <div>
        <label>NIM</label>
        <input type="text" name="pr_nim" value="{{ old('pr_nim', $profile->pr_nim) }}">
    </div>

    <select name="pr_kampus_id">
        @foreach($kampusList as $kampus)
            <option value="{{ $kampus->km_id }}"
                {{ $profile->pr_kampus_id == $kampus->km_id ? 'selected' : '' }}>
                {{ $kampus->km_nama_kampus }}
            </option>
        @endforeach
    </select>

    <div>
        <label>Jurusan</label>
        <input type="text" name="pr_jurusan">
    </div>

    @endif

    @if(auth()->user()->role === 'admin')

    <div>
        <label>NIP</label>
        <input type="text" name="pr_nip">
    </div>

    <div>
        <label>Posisi</label>
        <input type="text" name="pr_posisi"
            value="{{ old('pr_posisi', $profile->pr_posisi) }}">
    </div>

    @endif
</x-app-layout>
