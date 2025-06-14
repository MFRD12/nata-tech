<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pilih Role - {{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('images/nata-logo-rounded.png') }}" type="image/png">

    <!-- Styles -->
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="{{ asset('assets/css/tailwind.output.css') }}" />

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="{{ asset('assets/js/init-alpine.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" defer></script>
</head>

<body
    class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-white min-h-screen flex items-center justify-center px-4">

    @if (session('error'))
        <x-alert type="error" :message="session('error')" :duration="4000" :title="'Akses Ditolak'"/>
    @endif

    <!-- Tombol tema & logout -->
    <div class="absolute top-4 right-4 flex items-center gap-x-2 sm:gap-x-3 text-sm sm:text-base">
        <!-- Theme Toggle -->
        <button @click="toggleTheme" class=" text-blue-500 dark:text-purple-300 focus:outline-none">
            <template x-if="!dark">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                </svg>
            </template>
            <template x-if="dark">
                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                        clip-rule="evenodd"></path>
                </svg>
            </template>
        </button>

        <!-- Logout Button -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="py-1.5 px-3 sm:px-4 rounded-md bg-red-500 hover:bg-red-600 text-white font-semibold">
                Logout
            </button>
        </form>
    </div>

    <!-- Kontainer utama -->
    <div
        class="w-full max-w-sm sm:max-w-md md:max-w-xl bg-white dark:bg-gray-800 rounded-lg shadow-lg px-4 py-6 sm:p-8 space-y-6">
        <!-- Logo & Nama -->
        <div class="text-center">
            <img src="{{ asset('images/logo.jpg') }}" alt="Logo Perusahaan"
                class="h-16 sm:h-20 rounded-md mx-auto mb-4">
            <h1 class="text-xl sm:text-2xl font-bold">Selamat Datang, {{ auth()->user()->pegawai->nama ?? 'Sahabat' }}
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">NIP: {{ auth()->user()->nip ?? '-' }}</p>
        </div>

        <!-- Pilih Role -->
        <form method="POST" action="{{ route('set-active-role') }}" class="space-y-3">
            @csrf
            <h2 class="text-base sm:text-md font-semibold mb-2">Silakan pilih role untuk melanjutkan:</h2>
            @foreach ($roles as $role)
                <button type="submit" name="role" value="{{ $role }}"
                    class="w-full py-2.5 sm:py-3 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-md sm:text-base transition">
                    Masuk sebagai {{ ucfirst(str_replace('-', ' ', $role)) }}
                </button>
            @endforeach
        </form>
    </div>

</body>

</html>
