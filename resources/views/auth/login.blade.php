<x-guest-layout>
    <div class="flex items-center justify-center p-5">
        <div class="relative w-full max-w-[500px] rounded-3xl bg-white p-8 lg:p-12 shadow-xl dark:bg-gray-800 border border-gray-200 dark:border-gray-700">

            <div class="text-center mb-10">
                <div class="flex justify-center mb-4">
                    <img src="{{ asset('images/icon/kampus.png') }}" class="h-16 w-auto" alt="Logo">
                </div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Siporma-app</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                    Sistem Pengumpulan Project Mahasiswa Magang <br>
                    Dinas Kominfo dan Statistik
                </p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium mb-1.5 text-gray-700 dark:text-gray-300">Email Mahasiswa / Admin</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-900 dark:border-gray-600 dark:text-white"
                        placeholder="nama@email.com">
                    @error('email')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>


                <div>
                    <label class="block text-sm font-medium mb-1.5 text-gray-700 dark:text-gray-300">Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required
                            class="h-11 w-full rounded-lg border border-gray-300 px-4 pr-12 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-900 dark:border-gray-600 dark:text-white"
                            placeholder="Masukkan password...">

                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-blue-600">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.644C3.67 8.5 7.652 4.5 12 4.5c4.348 0 8.33 4 9.964 7.178a1.012 1.012 0 010 .644C20.33 15.5 16.348 19.5 12 19.5c-4.348 0-8.33-4-9.964-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full h-11 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200 shadow-md">
                    Masuk ke Sistem
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-700 text-center">
                <p class="text-xs text-gray-400">
                    Akun dibuat oleh Super Admin. <br>
                    Silakan hubungi Admin jika Anda belum memiliki akses.
                </p>
            </div>
        </div>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function (e) {
            // Toggle tipe input
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // Toggle warna ikon agar ada feedback saat aktif
            this.classList.toggle('text-blue-600');
        });
    </script>
</x-guest-layout>
