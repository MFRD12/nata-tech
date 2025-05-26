<aside class="z-20 hidden w-64 overflow-y-auto no-scrollbar bg-white dark:bg-gray-800 md:block flex-shrink-0"
    id="sidebar">
    <div class="py-4 text-gray-500 dark:text-gray-400">
        <a class="ml-6 flex items-center space-x-2 text-lg font-bold text-gray-800 dark:text-gray-200"
            href="{{ route('dashboard') }}">
            <img src="{{ asset('images/nata-logo1.png') }}" alt="" class="w-10 h-10 mr-3"> <span>SIM NATA</span>
        </a>

        {{-- Dashboard --}}
        <ul class="mt-6">
            <li class="relative px-6 py-3">
                @if (request()->routeIs('dashboard'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg"
                        aria-hidden="true"></span>
                @endif
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 
      {{ request()->routeIs('dashboard') ? 'text-blue-500 dark:text-blue-400' : 'text-gray-800 dark:text-gray-100 hover:text-gray-800 dark:hover:text-gray-100' }}"
                    href="{{ route('dashboard') }}">
                    <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    <span class="ml-4">Dashboard</span>
                </a>
            </li>
        </ul>

        {{-- Kepegawaian --}}
        @php
            $isKepegawaianActive =
                request()->routeIs('view-pegawai') ||
                request()->routeIs('tambah-view-pegawai') ||
                request()->routeIs('edit-view-pegawai') ||
                request()->routeIs('keluarga') ||
                request()->routeIs('absensi');
        @endphp

        <ul x-data="{
            openMenu: localStorage.getItem('openMenu') || '',
            toggleMenu(menu) {
                if (this.openMenu === menu) {
                    this.openMenu = '';
                    localStorage.removeItem('openMenu');
                } else {
                    this.openMenu = menu;
                    localStorage.setItem('openMenu', menu);
                }
            },
            init() {
                if (!this.openMenu && '{{ $isKepegawaianActive }}' === '1') {
                    this.openMenu = 'kepegawaian';
                    localStorage.setItem('openMenu', 'kepegawaian');
                }
            }
        }" x-init="init()">
            <li class="relative px-6 py-3">
                <button
                    class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150
        {{ $isKepegawaianActive ? 'text-blue-500 dark:text-blue-400' : 'text-gray-800 dark:text-gray-100 hover:text-gray-800 dark:hover:text-gray-100' }}"
                    @click="toggleMenu('kepegawaian')" aria-haspopup="true">
                    <span class="inline-flex items-center">
                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path
                                d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                        </svg>
                        <span class="ml-4">Kepegawaian</span>
                    </span>
                    <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>

                <template x-if="openMenu === 'kepegawaian'">
                    <ul x-transition:enter="transition-all duration-500 ease-in-out"
                        x-transition:enter-start="opacity-0 max-h-0 scale-95"
                        x-transition:enter-end="opacity-100 max-h-96 scale-100"
                        x-transition:leave="transition-all duration-400 ease-in"
                        x-transition:leave-start="opacity-100 max-h-96 scale-100"
                        x-transition:leave-end="opacity-0 max-h-0 scale-95"
                        class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                        aria-label="submenu">

                        {{-- Menu Pegawai --}}
                        <li
                            class="relative px-2 py-1 transition-colors duration-150 {{ request()->routeIs('view-pegawai') || request()->routeIs('tambah-view-pegawai') || request()->routeIs('edit-view-pegawai') ? 'text-blue-500 font-semibold' : 'hover:text-gray-800 dark:hover:text-gray-200' }}">
                            @if (request()->routeIs('view-pegawai') ||
                                    request()->routeIs('tambah-view-pegawai') ||
                                    request()->routeIs('edit-view-pegawai'))
                                <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-md rounded-br-md"
                                    aria-hidden="true"></span>
                            @endif
                            <a class="block w-full pl-4" href="{{ route('view-pegawai') }}">Data Pegawai</a>
                        </li>

                        {{-- Menu Keluarga --}}
                        <li
                            class="relative px-2 py-1 transition-colors duration-150 {{ request()->routeIs('keluarga') ? 'text-blue-500 font-semibold' : 'hover:text-gray-800 dark:hover:text-gray-200' }}">
                            @if (request()->routeIs('keluarga'))
                                <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-md rounded-br-md"
                                    aria-hidden="true"></span>
                            @endif
                            <a class="block w-full pl-4" href="#">Data Keluarga</a>
                        </li>

                        {{-- Menu Absensi --}}
                        <li
                            class="relative px-2 py-1 transition-colors duration-150 {{ request()->routeIs('absensi') ? 'text-blue-500 font-semibold' : 'hover:text-gray-800 dark:hover:text-gray-200' }}">
                            @if (request()->routeIs('absensi'))
                                <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-md rounded-br-md"
                                    aria-hidden="true"></span>
                            @endif
                            <a class="block w-full pl-4" href="">Data Absensi</a>
                        </li>

                    </ul>
                </template>
            </li>
        </ul>


        {{-- Keuangan --}}
        @php
            $isKeuanganActive =
                request()->routeIs('kategori') || request()->routeIs('transaksi') || request()->routeIs('laporan');
        @endphp

        <ul x-data="{
            openMenu: localStorage.getItem('openMenuKeuangan') || '',
            toggleMenu(menu) {
                if (this.openMenu === menu) {
                    this.openMenu = '';
                    localStorage.removeItem('openMenuKeuangan');
                } else {
                    this.openMenu = menu;
                    localStorage.setItem('openMenuKeuangan', menu);
                }
            },
            init() {
                if (!this.openMenu && '{{ $isKeuanganActive }}' === '1') {
                    this.openMenu = 'keuangan';
                    localStorage.setItem('openMenuKeuangan', 'keuangan');
                }
            }
        }" x-init="init()">
            <li class="relative px-6 py-3">
                <button
                    class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150
        {{ $isKeuanganActive ? 'text-blue-500 dark:text-blue-400' : 'text-gray-800 dark:text-gray-100 hover:text-gray-800 dark:hover:text-gray-100' }}"
                    @click="toggleMenu('keuangan')">
                    <span class="inline-flex items-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path
                                d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3c1.657 0 3-1.343 3-3s-1.343-3-3-3zm0 10c-2.21 0-4-1.79-4-4h2c0 1.105.895 2 2 2s2-.895 2-2-.895-2-2-2c-2.21 0-4-1.79-4-4s1.79-4 4-4c2.21 0 4 1.79 4 4h-2c0-1.105-.895-2-2-2s-2 .895-2 2 .895 2 2 2c2.21 0 4 1.79 4 4s-1.79 4-4 4z" />
                        </svg>
                        <span class="ml-4">Keuangan</span>
                    </span>
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>

                <template x-if="openMenu === 'keuangan'">
                    <ul x-transition:enter="transition-all duration-500 ease-in-out"
                        x-transition:enter-start="opacity-0 max-h-0 scale-95"
                        x-transition:enter-end="opacity-100 max-h-96 scale-100"
                        x-transition:leave="transition-all duration-400 ease-in"
                        x-transition:leave-start="opacity-100 max-h-96 scale-100"
                        x-transition:leave-end="opacity-0 max-h-0 scale-95"
                        class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                        aria-label="submenu"
                        class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900">
                        <li
                            class="relative px-2 py-1 transition-colors duration-150 {{ request()->routeIs('kategori') ? 'text-blue-500 font-semibold' : 'hover:text-gray-800 dark:hover:text-gray-200' }}">
                            @if (request()->routeIs('kategori'))
                                <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-md rounded-br-md"
                                    aria-hidden="true"></span>
                            @endif
                            <a class="block w-full pl-4" href="{{ route('kategori') }}">Tambah Kategori</a>
                        </li>
                        <li
                            class="relative px-2 py-1 transition-colors duration-150 {{ request()->routeIs('transaksi') ? 'text-blue-500 font-semibold' : 'hover:text-gray-800 dark:hover:text-gray-200' }}">
                            @if (request()->routeIs('transaksi'))
                                <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-md rounded-br-md"
                                    aria-hidden="true"></span>
                            @endif
                            <a class="block w-full pl-4" href="">Data Transaksi</a>
                        </li>
                        <li
                            class="relative px-2 py-1 transition-colors duration-150 {{ request()->routeIs('laporan') ? 'text-blue-500 font-semibold' : 'hover:text-gray-800 dark:hover:text-gray-200' }}">
                            @if (request()->routeIs('laporan'))
                                <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-md rounded-br-md"
                                    aria-hidden="true"></span>
                            @endif
                            <a class="block w-full pl-4" href="">Laporan</a>
                        </li>
                    </ul>
                </template>
            </li>
        </ul>

        {{-- Pengaturan --}}
        @php
            $isPengaturanActive = request()->routeIs('view-akun') || request()->routeIs('permission');
        @endphp

        <ul x-data="{
            openMenu: localStorage.getItem('openMenuPengaturan') || '',
            toggleMenu(menu) {
                if (this.openMenu === menu) {
                    this.openMenu = '';
                    localStorage.removeItem('openMenuPengaturan');
                } else {
                    this.openMenu = menu;
                    localStorage.setItem('openMenuPengaturan', menu);
                }
            },
            init() {
                if (!this.openMenu && '{{ $isPengaturanActive }}' === '1') {
                    this.openMenu = 'pengaturan';
                    localStorage.setItem('openMenuPengaturan', 'pengaturan');
                }
            }
        }" x-init="init()">
            <li class="relative px-6 py-3">
                <button
                    class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150
        {{ $isPengaturanActive ? 'text-blue-500 dark:text-blue-400' : 'text-gray-800 dark:text-gray-100 hover:text-gray-800 dark:hover:text-gray-100' }}"
                    @click="toggleMenu('pengaturan')">
                    <span class="inline-flex items-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path d="M12 6v6l4 2M12 4a8 8 0 100 16 8 8 0 000-16z" />
                        </svg>
                        <span class="ml-4">Pengaturan</span>
                    </span>
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>

                <template x-if="openMenu === 'pengaturan'">
                    <ul x-transition:enter="transition-all duration-500 ease-in-out"
                        x-transition:enter-start="opacity-0 max-h-0 scale-95"
                        x-transition:enter-end="opacity-100 max-h-96 scale-100"
                        x-transition:leave="transition-all duration-400 ease-in"
                        x-transition:leave-start="opacity-100 max-h-96 scale-100"
                        x-transition:leave-end="opacity-0 max-h-0 scale-95"
                        class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                        aria-label="submenu"
                        class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900">

                        <li
                            class="relative px-2 py-1 transition-colors duration-150 {{ request()->routeIs('view-akun') ? 'text-blue-500 font-semibold' : 'hover:text-gray-800 dark:hover:text-gray-200' }}">
                            @if (request()->routeIs('view-akun'))
                                <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-md rounded-br-md"
                                    aria-hidden="true"></span>
                            @endif
                            <a class="block w-full pl-4" href="{{ route('view-akun') }}">Tambah Akun</a>
                        </li>

                        <li
                            class="relative px-2 py-1 transition-colors duration-150 {{ request()->routeIs('permission') ? 'text-blue-500 font-semibold' : 'hover:text-gray-800 dark:hover:text-gray-200' }}">
                            @if (request()->routeIs('permission'))
                                <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-md rounded-br-md"
                                    aria-hidden="true"></span>
                            @endif
                            <a class="block w-full pl-4" href="">Atur Permission Role</a>
                        </li>
                    </ul>
                </template>
            </li>
        </ul>

        {{-- Profile Pegawai --}}
        <ul>
            <li class="relative px-6 py-3">
                @if (request()->routeIs(''))
                    <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg"
                        aria-hidden="true"></span>
                @endif
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 {{ request()->routeIs('') ? 'text-blue-500 dark:text-blue-400' : 'text-gray-800 dark:text-gray-100 hover:text-gray-800 dark:hover:text-gray-100' }}"
                    href="#">
                    <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                        </path>
                    </svg>
                    <span class="ml-4">Profile Pegawai</span>
                </a>
            </li>
            {{-- Profile Kelaurga --}}
            <li class="relative px-6 py-3">
                @if (request()->routeIs(''))
                    <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg"
                        aria-hidden="true"></span>
                @endif
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 {{ request()->routeIs('') ? 'text-blue-500 dark:text-blue-400' : 'text-gray-800 dark:text-gray-100 hover:text-gray-800 dark:hover:text-gray-100' }}"
                    href="#">
                    <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                    <span class="ml-4">Profile Keluarga</span>
                </a>
            </li>
            {{-- Absensi --}}
            <li class="relative px-6 py-3">
                @if (request()->routeIs(''))
                    <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg"
                        aria-hidden="true"></span>
                @endif
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 {{ request()->routeIs('') ? 'text-blue-500 dark:text-blue-400' : 'text-gray-800 dark:text-gray-100 hover:text-gray-800 dark:hover:text-gray-100' }}"
                    href="#">
                    <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                        <path d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                    </svg>
                    <span class="ml-4">Absensi</span>
                </a>
            </li>
        </ul>

        <div class="px-6 my-6">
            <button
                class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-purple">
                Coba
                <span class="ml-2" aria-hidden="true">+</span>
            </button>
        </div>
    </div>
</aside>


<!-- Backdrop -->
<div x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"></div>
<aside
    class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto no-scrollbar bg-white dark:bg-gray-800 md:hidden"
    x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150"
    x-transition:enter-start="opacity-0 transform -translate-x-20" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0 transform -translate-x-20" @click.away="closeSideMenu"
    @keydown.escape="closeSideMenu">
    <div class="py-4 text-gray-500 dark:text-gray-400">
        <a class="ml-6 flex items-center space-x-2 text-lg font-bold text-gray-800 dark:text-gray-200" href="#">
            <img src="{{ asset('images/nata-logo1.png') }}" alt="" class="w-8 h-8 mr-3"> <span>SIM
                NATA</span>
        </a>
        <br>
        {{-- Dashboard --}}
        <ul class="mt-6">
            <li class="relative px-6 py-3">
                @if (request()->routeIs('dashboard'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg"
                        aria-hidden="true"></span>
                @endif
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 
      {{ request()->routeIs('dashboard') ? 'text-blue-500 dark:text-blue-400' : 'text-gray-800 dark:text-gray-100 hover:text-gray-800 dark:hover:text-gray-100' }}"
                    href="{{ route('dashboard') }}">
                    <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    <span class="ml-4">Dashboard</span>
                </a>
            </li>
        </ul>
        {{-- Kepegawaian Mobile --}}
        @php
            $isKepegawaianActive =
                request()->routeIs('view-pegawai') ||
                request()->routeIs('tambah-view-pegawai') ||
                request()->routeIs('edit-view-pegawai') ||
                request()->routeIs('keluarga') ||
                request()->routeIs('absensi');
        @endphp

        <ul x-data="{
            openMenu: localStorage.getItem('openMenu') || '',
            toggleMenu(menu) {
                if (this.openMenu === menu) {
                    this.openMenu = '';
                    localStorage.removeItem('openMenu');
                } else {
                    this.openMenu = menu;
                    localStorage.setItem('openMenu', menu);
                }
            },
            init() {
                if (!this.openMenu && '{{ $isKepegawaianActive }}' === '1') {
                    this.openMenu = 'kepegawaian';
                    localStorage.setItem('openMenu', 'kepegawaian');
                }
            }
        }" x-init="init()">
            <li class="relative px-6 py-3">
                <button
                    class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150
        {{ $isKepegawaianActive ? 'text-blue-500 dark:text-blue-400' : 'text-gray-800 dark:text-gray-100 hover:text-gray-800 dark:hover:text-gray-100' }}"
                    @click="toggleMenu('kepegawaian')" aria-haspopup="true">
                    <span class="inline-flex items-center">
                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path
                                d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                        </svg>
                        <span class="ml-4">Kepegawaian</span>
                    </span>
                    <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>

                <template x-if="openMenu === 'kepegawaian'">
                    <ul x-transition:enter="transition-all ease-in-out duration-300"
                        x-transition:enter-start="opacity-25 max-h-0" x-transition:enter-end="opacity-100 max-h-xl"
                        x-transition:leave="transition-all ease-in-out duration-300"
                        x-transition:leave-start="opacity-100 max-h-xl" x-transition:leave-end="opacity-0 max-h-0"
                        class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                        aria-label="submenu">

                        {{-- Menu Pegawai --}}
                        <li
                            class="relative px-2 py-1 transition-colors duration-150 {{ request()->routeIs('view-pegawai') || request()->routeIs('tambah-view-pegawai') || request()->routeIs('edit-view-pegawai') ? 'text-blue-500 font-semibold' : 'hover:text-gray-800 dark:hover:text-gray-200' }}">
                            @if (request()->routeIs('view-pegawai') ||
                                    request()->routeIs('tambah-view-pegawai') ||
                                    request()->routeIs('edit-view-pegawai'))
                                <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-md rounded-br-md"
                                    aria-hidden="true"></span>
                            @endif
                            <a class="block w-full pl-4" href="{{ route('view-pegawai') }}">Data Pegawai</a>
                        </li>

                        {{-- Menu Keluarga --}}
                        <li
                            class="relative px-2 py-1 transition-colors duration-150 {{ request()->routeIs('keluarga') ? 'text-blue-500 font-semibold' : 'hover:text-gray-800 dark:hover:text-gray-200' }}">
                            @if (request()->routeIs('keluarga'))
                                <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-md rounded-br-md"
                                    aria-hidden="true"></span>
                            @endif
                            <a class="block w-full pl-4" href="#">Data Keluarga</a>
                        </li>

                        {{-- Menu Absensi --}}
                        <li
                            class="relative px-2 py-1 transition-colors duration-150 {{ request()->routeIs('absensi') ? 'text-blue-500 font-semibold' : 'hover:text-gray-800 dark:hover:text-gray-200' }}">
                            @if (request()->routeIs('absensi'))
                                <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-md rounded-br-md"
                                    aria-hidden="true"></span>
                            @endif
                            <a class="block w-full pl-4" href="">Data Absensi</a>
                        </li>

                    </ul>
                </template>
            </li>
        </ul>

        {{-- Keuangan Mobile --}}
        @php
            $isKeuanganActive =
                request()->routeIs('kategori') || request()->routeIs('transaksi') || request()->routeIs('laporan');
        @endphp

        <ul x-data="{
            openMenu: localStorage.getItem('openMenuKeuangan') || '',
            toggleMenu(menu) {
                if (this.openMenu === menu) {
                    this.openMenu = '';
                    localStorage.removeItem('openMenuKeuangan');
                } else {
                    this.openMenu = menu;
                    localStorage.setItem('openMenuKeuangan', menu);
                }
            },
            init() {
                if (!this.openMenu && '{{ $isKeuanganActive }}' === '1') {
                    this.openMenu = 'keuangan';
                    localStorage.setItem('openMenuKeuangan', 'keuangan');
                }
            }
        }" x-init="init()">
            <li class="relative px-6 py-3">
                <button
                    class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150
        {{ $isKeuanganActive ? 'text-blue-500 dark:text-blue-400' : 'text-gray-800 dark:text-gray-100 hover:text-gray-800 dark:hover:text-gray-100' }}"
                    @click="toggleMenu('keuangan')">
                    <span class="inline-flex items-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path
                                d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3c1.657 0 3-1.343 3-3s-1.343-3-3-3zm0 10c-2.21 0-4-1.79-4-4h2c0 1.105.895 2 2 2s2-.895 2-2-.895-2-2-2c-2.21 0-4-1.79-4-4s1.79-4 4-4c2.21 0 4 1.79 4 4h-2c0-1.105-.895-2-2-2s-2 .895-2 2 .895 2 2 2c2.21 0 4 1.79 4 4s-1.79 4-4 4z" />
                        </svg>
                        <span class="ml-4">Keuangan</span>
                    </span>
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>

                <template x-if="openMenu === 'keuangan'">
                    <ul
                        class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900">
                        <li
                            class="relative px-2 py-1 transition-colors duration-150 {{ request()->routeIs('kategori') ? 'text-blue-500 font-semibold' : 'hover:text-gray-800 dark:hover:text-gray-200' }}">
                            @if (request()->routeIs('kategori'))
                                <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-md rounded-br-md"
                                    aria-hidden="true"></span>
                            @endif
                            <a class="block w-full pl-4" href="{{ route('kategori') }}">Tambah Kategori</a>
                        </li>
                        <li
                            class="relative px-2 py-1 transition-colors duration-150 {{ request()->routeIs('transaksi') ? 'text-blue-500 font-semibold' : 'hover:text-gray-800 dark:hover:text-gray-200' }}">
                            @if (request()->routeIs('transaksi'))
                                <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-md rounded-br-md"
                                    aria-hidden="true"></span>
                            @endif
                            <a class="block w-full pl-4" href="">Data Transaksi</a>
                        </li>
                        <li
                            class="relative px-2 py-1 transition-colors duration-150 {{ request()->routeIs('laporan') ? 'text-blue-500 font-semibold' : 'hover:text-gray-800 dark:hover:text-gray-200' }}">
                            @if (request()->routeIs('laporan'))
                                <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-md rounded-br-md"
                                    aria-hidden="true"></span>
                            @endif
                            <a class="block w-full pl-4" href="">Laporan</a>
                        </li>
                    </ul>
                </template>
            </li>
        </ul>

        {{-- Pengaturan Mobile --}}
        @php
            $isPengaturanActive = request()->routeIs('view-akun') || request()->routeIs('permission');
        @endphp

        <ul x-data="{
            openMenu: localStorage.getItem('openMenuPengaturan') || '',
            toggleMenu(menu) {
                if (this.openMenu === menu) {
                    this.openMenu = '';
                    localStorage.removeItem('openMenuPengaturan');
                } else {
                    this.openMenu = menu;
                    localStorage.setItem('openMenuPengaturan', menu);
                }
            },
            init() {
                if (!this.openMenu && '{{ $isPengaturanActive }}' === '1') {
                    this.openMenu = 'pengaturan';
                    localStorage.setItem('openMenuPengaturan', 'pengaturan');
                }
            }
        }" x-init="init()">
            <li class="relative px-6 py-3">
                <button
                    class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150
        {{ $isPengaturanActive ? 'text-blue-500 dark:text-blue-400' : 'text-gray-800 dark:text-gray-100 hover:text-gray-800 dark:hover:text-gray-100' }}"
                    @click="toggleMenu('pengaturan')">
                    <span class="inline-flex items-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path d="M12 6v6l4 2M12 4a8 8 0 100 16 8 8 0 000-16z" />
                        </svg>
                        <span class="ml-4">Pengaturan</span>
                    </span>
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>

                <template x-if="openMenu === 'pengaturan'">
                    <ul
                        class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900">

                        <li
                            class="relative px-2 py-1 transition-colors duration-150 {{ request()->routeIs('akun') ? 'text-blue-500 font-semibold' : 'hover:text-gray-800 dark:hover:text-gray-200' }}">
                            @if (request()->routeIs('view-akun'))
                                <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-md rounded-br-md"
                                    aria-hidden="true"></span>
                            @endif
                            <a class="block w-full pl-4" href="{{ route('view-akun') }}">Tambah Akun</a>
                        </li>

                        <li
                            class="relative px-2 py-1 transition-colors duration-150 {{ request()->routeIs('permission') ? 'text-blue-500 font-semibold' : 'hover:text-gray-800 dark:hover:text-gray-200' }}">
                            @if (request()->routeIs('permission'))
                                <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-md rounded-br-md"
                                    aria-hidden="true"></span>
                            @endif
                            <a class="block w-full pl-4" href="">Atur Permission Role</a>
                        </li>
                    </ul>
                </template>
            </li>
        </ul>

        <div class="px-6 my-6">
            <button
                class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-purple">
                Coba
                <span class="ml-2" aria-hidden="true">+</span>
            </button>
        </div>
    </div>
</aside>
