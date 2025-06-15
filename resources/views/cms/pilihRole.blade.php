<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pilih Role - {{ config('app.name', 'SIM NATA') }}</title>
    <link rel="icon" href="{{ asset('images/nata-logo-rounded.png') }}" type="image/png">

    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="{{ asset('assets/css/tailwind.output.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/init-alpine.js') }}"></script>
</head>

<body>
    <div class="flex items-center min-h-screen bg-gray-100 dark:bg-gray-900 px-4 py-4">
        <div class="flex-1 h-full max-w-5xl mx-auto bg-white rounded-lg shadow-xl dark:bg-gray-800">
            <div class="flex flex-col md:flex-row">

                <div class="hidden md:block md:w-1/2">
                    <div
                        class="h-full flex flex-col items-center justify-center bg-gradient-to-br from-indigo-600 to-blue-500 text-white p-8 rounded-l-lg">
                        <img src="{{ asset('images/nata-logo-rounded.png') }}" alt="Logo" class="w-24 h-24 mb-4">
                        <h1 class="text-3xl font-bold mb-2">SIM NATA</h1>
                        <p class="text-indigo-200 text-center">Sistem Informasi Manajemen</p>
                    </div>
                </div>

                <div class="flex items-center justify-center w-full p-6 sm:p-12 md:w-1/2">
                    <div class="w-full">
                        <div class="absolute top-4 right-4 flex items-center gap-x-2 sm:gap-x-3 text-sm sm:text-base">
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

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="py-1.5 px-3 sm:px-4 rounded-md bg-red-500 hover:bg-red-600 text-white font-semibold">
                                    Logout
                                </button>
                            </form>
                        </div>

                        <div class="text-center md:hidden mb-8">
                            <img src="{{ asset('images/logo.jpg') }}" alt="Logo Perusahaan"
                                class="h-16 sm:h-20 rounded-md mx-auto mb-4">
                        </div>

                        <div class="text-center md:text-left">
                            <h1 class="mb-1 text-2xl font-bold text-gray-700 dark:text-gray-200">
                                Selamat Datang, {{ auth()->user()->pegawai->nama ?? 'Sahabat' }}
                            </h1>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">NIP:
                                {{ auth()->user()->nip ?? '-' }}</p>
                        </div>

                        <p class="mb-4 text-gray-600 dark:text-gray-300 text-center md:text-left">Silakan pilih role
                            untuk melanjutkan:</p>

                        @if (session('error'))
                            <x-alert type="error" :message="session('error')" title="Akses Ditolak" />
                        @endif


                        <form method="POST" action="{{ route('set-active-role') }}">
                            @csrf
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach ($roles as $role)
                                    {{-- Logika untuk menangani item terakhir yang ganjil --}}
                                    @if ($loop->last && $loop->count % 2 != 0)
                                        {{-- 1. Buat pembungkus yang lebarnya 2 kolom untuk item terakhir --}}
                                        <div class="sm:col-span-2 flex justify-center">
                                            {{-- 2. Buat tombol dengan lebar yang sama seperti tombol lain di grid --}}
                                            <button type="submit" name="role" value="{{ $role }}"
                                                class="w-full md:w-1/2 relative flex items-center space-x-4 p-4 text-left bg-gray-100 dark:bg-gray-700 rounded-lg shadow-sm hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-transform transform hover:scale-105">

                                                <span
                                                    class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 text-white">
                                                    @if ($role === 'super admin')
                                                        <i class="fas fa-crown"></i>
                                                    @elseif($role === 'hrd')
                                                        <i class="fas fa-users"></i>
                                                    @elseif($role === 'keuangan')
                                                        <i class="fas fa-wallet"></i>
                                                    @elseif($role === 'pegawai')
                                                        <i class="fas fa-user"></i>
                                                    @else
                                                        <i class="fas fa-briefcase"></i>
                                                    @endif
                                                </span>

                                                <div class="flex-grow pr-4">
                                                    <p class="font-semibold text-gray-800 dark:text-gray-100">
                                                        {{ ucfirst(str_replace('-', ' ', $role)) }}
                                                    </p>
                                                </div>

                                                <i
                                                    class="fas fa-chevron-right text-gray-400 absolute top-1/2 -translate-y-1/2 right-4"></i>
                                            </button>
                                        </div>
                                    @else
                                        {{-- Untuk item lainnya, tampilkan seperti biasa --}}
                                        <button type="submit" name="role" value="{{ $role }}"
                                            class="relative flex items-center space-x-4 p-4 w-full text-left bg-gray-100 dark:bg-gray-700 rounded-lg shadow-sm hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-transform transform hover:scale-105">

                                            <span
                                                class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 text-white">
                                                @if ($role === 'super admin')
                                                    <i class="fas fa-crown"></i>
                                                @elseif($role === 'hrd')
                                                    <i class="fas fa-users"></i>
                                                @elseif($role === 'keuangan')
                                                    <i class="fas fa-wallet"></i>
                                                @elseif($role === 'pegawai')
                                                    <i class="fas fa-user"></i>
                                                @else
                                                    <i class="fas fa-briefcase"></i>
                                                @endif
                                            </span>

                                            <div class="flex-grow pr-4">
                                                <p class="font-semibold text-gray-800 dark:text-gray-100">
                                                    {{ ucfirst(str_replace('-', ' ', $role)) }}
                                                </p>
                                            </div>

                                            <i
                                                class="fas fa-chevron-right text-gray-400 absolute top-1/2 -translate-y-1/2 right-4"></i>
                                        </button>
                                    @endif
                                @endforeach
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
