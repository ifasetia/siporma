<aside class="bg-white border-r min-h-screen relative"
      style="width: 280px; min-width: 280px; max-width: 420px;">

    {{-- HEADER --}}
    <div class="p-4 font-bold text-lg">
        SIPORMA
    </div>

    {{-- MENU --}}
    <nav class="p-4 space-y-2 text-sm">

        {{-- DASHBOARD (SEMUA LOGIN) --}}
        <a href="{{ route('dashboard') }}"
           class="block px-3 py-2 rounded
           {{ request()->routeIs('dashboard') ? 'bg-gray-200 font-semibold' : 'hover:bg-gray-100' }}">
            Dashboard
        </a>

        {{-- SUPER ADMIN --}}
        @if(auth()->user()->role === 'super_admin')
            <a href="#" class="block px-3 py-2 rounded hover:bg-gray-100">
                Manajemen User
            </a>
        @endif

        {{-- ADMIN --}}
        @if(in_array(auth()->user()->role, ['admin', 'super_admin']))
            <a href="#" class="block px-3 py-2 rounded hover:bg-gray-100">
                Kelola Data
            </a>
        @endif

        {{-- INTERN --}}
        @if(auth()->user()->role === 'intern')
            <a href="#" class="block px-3 py-2 rounded hover:bg-gray-100">
                Lihat Data
            </a>
        @endif

    </nav>
</aside>
