    @extends('layouts.app')

    @section('title','Project Saya')

    @section('content')

    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
        {{-- <h3 class="mb-5 text-lg font-semibold text-gray-800 dark:text-white/90 lg:mb-7">
            Project Saya
        </h3> --}}

        <div class="p-5 mb-6 border border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6">
            <div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">
                <div class="flex flex-col items-center w-full gap-6 xl:flex-row">
                    <div class="w-25 h-25 overflow-hidden   dark:border-gray-800">
                        <img src="{{ asset('images/icon/kampus.png') }}" alt="user" />
                    </div>
                    <div class="order-3 xl:order-2">
                        <h4 class="mb-2 text-lg font-semibold text-center text-gray-800 dark:text-white/90 xl:text-left">
                            Kelola project saya
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

                <button id="btnOpen"
                    class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow hover:bg-blue-700 transition">
                    <x-heroicon-c-plus-circle class="h-5 w-5" />
                    <span>Tambah</span>
                </button>
            </div>
        </div>

        <div class="p-5 mb-6 border border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6 w-full">

            <div class="w-full overflow-x-auto">
                <table id="projectTable" class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-medium">
                        <tr>
                            <tr>
                                <th class="px-6 py-3 text-center w-16">No</th>
                                <th class="px-6 py-3 text-left">Judul Project</th>
                                <th class="px-6 py-3 text-left">Teknologi</th>
                                <th class="px-6 py-3 text-left">Status</th>
                                <th class="px-6 py-3 text-center w-44">Aksi</th>
                            </tr>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100"></tbody>
                </table>
            </div>
        </div>
    </div>



    @endsection
    {{-- MODAL --}}
    @include('pages.projects.add')
    @include('pages.projects.edit')
    @include('pages.projects.detail')

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            if (!window.$) {
                console.error('jQuery NOT loaded');
                return;
            }


            window.table = $('#projectTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('projects.datatables') }}",

        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable:false,
                searchable:false,
                className:'text-center'
            },
            {
                data: 'title',
                name: 'title'
            },
            {
                data: 'technologies',
                name: 'technologies'
            },
            {
                data: 'status',
                name: 'status',
                orderable:false,
                searchable:false
            },
            {
                data: 'aksi',
                name: 'aksi',
                orderable:false,
                searchable:false,
                className:'text-center'
            },
        ]
    });
            
        });

    </script>
    @endpush
