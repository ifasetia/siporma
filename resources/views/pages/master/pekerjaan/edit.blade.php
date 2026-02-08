@extends('layouts.app')

@section('title','Master Pekerjaan')

@section('content')
<div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
    <div class="p-5 mb-6 border border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6">
        <div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">
            <div class="flex flex-col items-center w-full gap-6 xl:flex-row">
                <div class="w-25 h-25 overflow-hidden   dark:border-gray-800">
                    <img src="{{ asset('images/icon/kampus.png') }}" alt="user" />
                </div>
                <div class="order-3 xl:order-2">
                    <h4 class="mb-2 text-lg font-semibold text-center text-gray-800 dark:text-white/90 xl:text-left">
                        Edit Data Pekerjaan
                    </h4>
                    <div class="flex flex-col items-center gap-1 text-center xl:flex-row xl:gap-3 xl:text-left">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Team Manager
                        </p>
                        <div class="hidden h-3.5 w-px bg-gray-300 dark:bg-gray-700 xl:block"></div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Arizona, United States
                        </p>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
        @if(session('success'))
        <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-700">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-700">
            {{ session('error') }}
        </div>
        @endif

        @if ($errors->any())
        <div class="mb-4 p-4 rounded-lg bg-yellow-100 text-yellow-700">
            <ul class="list-disc ml-5 text-sm">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif


        <form class="flex flex-col gap-6" action="{{ route('pekerjaan.update', $pekerjaan->pk_id_pekerjaan) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!-- Kode Tipe Pekerjaan -->
            <div>
                <label class="block text-sm font-medium mb-1">Kode Tipe Pekerjaan</label>
                <input type="text" name="pk_kode_tipe_pekerjaan" value="{{ old('pk_kode_tipe_pekerjaan', $pekerjaan->pk_kode_tipe_pekerjaan) }}"
                    placeholder="Inputkan kode tipe pekerjaan..." class="h-11 w-full rounded-lg border px-4 text-sm
        @error('pk_kode_tipe_pekerjaan') border-red-500 @else border-gray-300 @enderror">

                @error('pk_kode_tipe_pekerjaan')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Pekerjaan -->
            <div>
                <label class="block text-sm font-medium mb-1">Nama Pekerjaan</label>
                <input type="text" name="pk_nama_pekerjaan" value="{{ old('pk_nama_pekerjaan', $pekerjaan->pk_nama_pekerjaan) }}"
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
                        <option value="Easy" {{ old('pk_level_pekerjaan', $pekerjaan->pk_level_pekerjaan) == 'Easy' ? 'selected' : '' }}>
                            Easy
                        </option>
                        <option value="Medium" {{ old('pk_level_pekerjaan', $pekerjaan->pk_level_pekerjaan) == 'Medium' ? 'selected' : '' }}>
                            Medium
                        </option>
                        <option value="Hard" {{ old('pk_level_pekerjaan', $pekerjaan->pk_level_pekerjaan) == 'Hard' ? 'selected' : '' }}>
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
                <input type="number" name="pk_estimasi_durasi_hari" value="{{ old('pk_estimasi_durasi_hari', $pekerjaan->pk_estimasi_durasi_hari) }}"
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
        @error('pk_deskripsi_pekerjaan') border-red-500 @else border-gray-300 @enderror">{{ old('pk_deskripsi_pekerjaan', $pekerjaan->pk_deskripsi_pekerjaan) }}</textarea>

                @error('pk_deskripsi_pekerjaan')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Minimal Skill -->
            <div>
                <label class="block text-sm font-medium mb-1">Skill yang Dibutuhkan</label>
                <textarea name="pk_minimal_skill" placeholder="Inputkan skill yang dibutuhkan..."
                    class="h-24 w-full rounded-lg border px-4 py-2 text-sm
        @error('pk_minimal_skill') border-red-500 @else border-gray-300 @enderror">{{ old('pk_minimal_skill', $pekerjaan->pk_minimal_skill) }}</textarea>

                @error('pk_minimal_skill')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>


            <!-- Footer -->
            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('pekerjaan.index') }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white shadow hover:bg-red-700 transition">
                    <x-heroicon-o-arrow-left class="h-5 w-5" />
                    <span>Kembali</span>
                </a>

                <button type="submit"
                    class="inline-flex items-center gap-2 rounded-lg bg-brand-600 px-4 py-2 text-sm font-medium text-white shadow hover:bg-brand-700 transition">
                    <span>Update</span>
                    <x-heroicon-o-arrow-right class="h-5 w-5" />
                </button>
            </div>

        </form>

    </div>


@endsection

@push('scripts')
    <script>

    </script>
@endpush
