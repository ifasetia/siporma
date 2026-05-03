<header x-data="{menuToggle: false}"
    class="sticky top-0 z-50 w-full border-b border-gray-200 bg-white/80 backdrop-blur-md dark:border-gray-800 dark:bg-gray-900/80">

    <div class="flex items-center justify-between px-4 py-3 lg:px-6">

        <!-- LEFT -->
        <div class="flex items-center gap-3">

            <!-- Toggle Sidebar -->
            <button @click.stop="sidebarToggle = !sidebarToggle"
                class="flex h-10 w-10 items-center justify-center rounded-lg border text-gray-500 hover:bg-gray-100 dark:border-gray-800 dark:text-gray-400 dark:hover:bg-gray-800">

                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Logo + Title -->
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/icon/LOGO.png') }}" class="h-10 w-auto" alt="Logo">
                <span class="text-lg font-bold text-gray-800 dark:text-white">
                    SIPORMA<span class="text-blue-600">.</span>
                </span>
            </div>

        </div>

        <!-- RIGHT -->
        <div class="flex items-center gap-4">

            <!-- User Dropdown -->
            <div class="relative" x-data="{open:false}" @click.outside="open=false">

                <button @click="open = !open"
                    class="flex items-center gap-2 rounded-lg px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-800">

                    <!-- Avatar -->
                    <div class="h-9 w-9 rounded-full bg-gray-200 overflow-hidden flex items-center justify-center">
                        @if(Auth::user()->profile && Auth::user()->profile->pr_photo)
                        <img src="{{ asset('storage/' . Auth::user()->profile->pr_photo) }}"
                            class="h-full w-full object-cover">
                        @else
                        <span class="text-blue-600 font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </span>
                        @endif
                    </div>

                    <!-- Name -->
                    <span class="hidden sm:block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ Auth::user()->name }}
                    </span>

                    <!-- Arrow -->
                    <svg class="w-4 h-4 transition-transform" :class="open && 'rotate-180'" fill="none"
                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M6 9l6 6 6-6" />
                    </svg>

                </button>

                <!-- Dropdown -->
                <div x-show="open" x-transition
                    class="absolute right-0 mt-3 w-60 rounded-2xl bg-white shadow-xl overflow-hidden">

                    <!-- USER -->
                    <div class="px-5 py-4">
                        <p class="text-sm font-semibold text-gray-800">
                            {{ Auth::user()->name }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ Auth::user()->email }}
                        </p>
                    </div>

                    <!-- MENU -->
                    <div class="py-2">

                        <!-- PROFILE -->
                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center px-5 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition">
                            Edit Profil
                        </a>

                        <!-- LOGOUT -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-5 py-2.5 text-sm text-red-500 hover:bg-red-50 transition">
                                Logout
                            </button>
                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>
</header>
