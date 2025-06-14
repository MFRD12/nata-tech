@php
    $activeRole = session('active_role');
@endphp
<aside class="z-20 hidden w-64 overflow-y-auto no-scrollbar bg-white dark:bg-gray-800 md:block flex-shrink-0"
    id="sidebar">
    <div class="py-4 text-gray-500 dark:text-gray-400">
        <a class="ml-6 flex items-center space-x-2 text-lg font-bold text-gray-800 dark:text-gray-200"
            href="{{ route('dashboard') }}">
            <img src="{{ asset('images/nata-logo1.png') }}" alt="" class="w-10 h-10 mr-3"> <span>SIM NATA</span>
        </a>
        @if (in_array($activeRole, ['super admin', 'hrd', 'keuangan']))
            {{-- Dashboard --}}
            <ul class="mt-6">
                <li class="relative px-6 py-3">
                    @if (request()->routeIs('dashboard'))
                        <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg"
                            aria-hidden="true"></span>
                    @endif
                    <a class="inline-flex items-center w-full text-sm  transition-colors duration-150 {{ request()->routeIs('dashboard') ? 'text-blue-500 dark:text-blue-400' : 'text-gray-800 dark:text-gray-100 hover:text-gray-800 dark:hover:text-gray-100' }}"
                        href="{{ route('dashboard') }}">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path
                                d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
                            <path
                                d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
                        </svg>

                        <span class="ml-4">Dashboard</span>
                    </a>
                </li>
            </ul>
        @endif

        @if (in_array($activeRole, ['super admin']))
            {{-- Master Data --}}
            @php
                $isMasterActive = request()->routeIs('view-jabatan') || request()->routeIs('view-divisi') || request()->routeIs('view-role');
            @endphp

            <ul x-data="{
                openMenu: localStorage.getItem('openMenuMasterData') || '',
                toggleMenu(menu) {
                    if (this.openMenu === menu) {
                        this.openMenu = '';
                        localStorage.removeItem('openMenuMasterData');
                    } else {
                        this.openMenu = menu;
                        localStorage.setItem('openMenuMasterData', menu);
                    }
                },
                init() {
                    if (!this.openMenu && '{{ $isMasterActive }}' === '1') {
                        this.openMenu = 'masterData';
                        localStorage.setItem('openMenuMasterData', 'masterData');
                    }
                }
            }" x-init="init()">
                <li class="relative px-6 py-3">
                    <button
                        class="inline-flex items-center justify-between w-full text-sm  transition-colors duration-150
        {{ $isMasterActive ? 'text-blue-500 dark:text-blue-400' : 'text-gray-800 dark:text-gray-100 hover:text-gray-800 dark:hover:text-gray-100' }}"
                        @click="toggleMenu('masterData')">
                        <span class="inline-flex items-center">
                            <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                <path
                                    d="M21 6.375c0 2.692-4.03 4.875-9 4.875S3 9.067 3 6.375 7.03 1.5 12 1.5s9 2.183 9 4.875Z" />
                                <path
                                    d="M12 12.75c2.685 0 5.19-.586 7.078-1.609a8.283 8.283 0 0 0 1.897-1.384c.016.121.025.244.025.368C21 12.817 16.97 15 12 15s-9-2.183-9-4.875c0-.124.009-.247.025-.368a8.285 8.285 0 0 0 1.897 1.384C6.809 12.164 9.315 12.75 12 12.75Z" />
                                <path
                                    d="M12 16.5c2.685 0 5.19-.586 7.078-1.609a8.282 8.282 0 0 0 1.897-1.384c.016.121.025.244.025.368 0 2.692-4.03 4.875-9 4.875s-9-2.183-9-4.875c0-.124.009-.247.025-.368a8.284 8.284 0 0 0 1.897 1.384C6.809 15.914 9.315 16.5 12 16.5Z" />
                                <path
                                    d="M12 20.25c2.685 0 5.19-.586 7.078-1.609a8.282 8.282 0 0 0 1.897-1.384c.016.121.025.244.025.368 0 2.692-4.03 4.875-9 4.875s-9-2.183-9-4.875c0-.124.009-.247.025-.368a8.284 8.284 0 0 0 1.897 1.384C6.809 19.664 9.315 20.25 12 20.25Z" />
                            </svg>

                            <span class="ml-4">Master Data</span>
                        </span>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    <template x-if="openMenu === 'masterData'">
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
                                class="relative px-2 py-1 transition-colors duration-150 {{ request()->routeIs('view-jabatan') ? 'text-blue-500 ' : 'hover:text-gray-800 dark:hover:text-gray-200' }}">
                                @if (request()->routeIs('view-jabatan'))
                                    <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-md rounded-br-md"
                                        aria-hidden="true"></span>
                                @endif
                                <a class="block w-full pl-4" href="{{ route('view-jabatan') }}">Kelola Jabatan</a>
                            </li>

                            <li
                                class="relative px-2 py-1 transition-colors duration-150 {{ request()->routeIs('view-divisi') ? 'text-blue-500 ' : 'hover:text-gray-800 dark:hover:text-gray-200' }}">
                                @if (request()->routeIs('view-divisi'))
                                    <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-md rounded-br-md"
                                        aria-hidden="true"></span>
                                @endif
                                <a class="block w-full pl-4" href="{{ route('view-divisi') }}">Kelola Divisi</a>
                            </li>

                            <li
                                class="relative px-2 py-1 transition-colors duration-150 {{ request()->routeIs('view-role') ? 'text-blue-500 ' : 'hover:text-gray-800 dark:hover:text-gray-200' }}">
                                @if (request()->routeIs('view-role'))
                                    <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-md rounded-br-md"
                                        aria-hidden="true"></span>
                                @endif
                                <a class="block w-full pl-4" href="#">Kelola Role</a>
                            </li>
                        </ul>
                    </template>
                </li>
            </ul>
        @endif

        @if (in_array($activeRole, ['super admin', 'hrd']))
            {{-- Kepegawaian --}}
            @php
                $isKepegawaianActive =
                    request()->routeIs('view-pegawai') ||
                    request()->routeIs('tambah-view-pegawai') ||
                    request()->routeIs('edit-view-pegawai') ||
                    request()->routeIs('view-keluarga') ||
                    request()->routeIs('tambah-view-keluarga') ||
                    request()->routeIs('edit-view-keluarga') ||
                    request()->routeIs('detail-view-keluarga') ||
                    request()->routeIs('view-rekap-absensi') ||
                    request()->routeIs('view-rekap-detail');
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
                        class="inline-flex items-center justify-between w-full text-sm  transition-colors duration-150
        {{ $isKepegawaianActive ? 'text-blue-500 dark:text-blue-400' : 'text-gray-800 dark:text-gray-100 hover:text-gray-800 dark:hover:text-gray-100' }}"
                        @click="toggleMenu('kepegawaian')" aria-haspopup="true">
                        <span class="inline-flex items-center">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                                </path>
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
                                class="relative px-2 py-1 transition-colors duration-150 {{ request()->routeIs('view-pegawai') || request()->routeIs('tambah-view-pegawai') || request()->routeIs('edit-view-pegawai') ? 'text-blue-500 ' : 'hover:text-gray-800 dark:hover:text-gray-200' }}">
                                @if (request()->routeIs('view-pegawai') ||
                                        request()->routeIs('tambah-view-pegawai') ||
                                        request()->routeIs('edit-view-pegawai'))
                                    <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-md rounded-br-md"
                                        aria-hidden="true"></span>
                                @endif
                                <a class="block w-full pl-4" href="{{ route('view-pegawai') }}">Data Pegawai</a>
                            </li>

                            {{-- Menu Keluarga --}}
                            {{-- <li
                                class="relative px-2 py-1 transition-colors duration-150 {{ request()->routeIs('view-keluarga') || request()->routeIs('tambah-view-keluarga') || request()->routeIs('edit-view-keluarga') || request()->routeIs('detail-view-keluarga') ? 'text-blue-500 ' : 'hover:text-gray-800 dark:hover:text-gray-200' }}">
                                @if (request()->routeIs('view-keluarga') ||
                                        request()->routeIs('tambah-view-keluarga') ||
                                        request()->routeIs('edit-view-keluarga') ||
                                        request()->routeIs('detail-view-keluarga'))
                                    <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-md rounded-br-md"
                                        aria-hidden="true"></span>
                                @endif
                                <a class="block w-full pl-4" href="{{ route('view-keluarga') }}">Data Keluarga</a>
                            </li> --}}

                            {{-- Menu Absensi --}}
                            <li
                                class="relative px-2 py-1 transition-colors duration-150 {{ request()->routeIs('view-rekap-absensi') || request()->routeIs('view-rekap-detail') ? 'text-blue-500 ' : 'hover:text-gray-800 dark:hover:text-gray-200' }}">
                                @if (request()->routeIs('view-rekap-absensi') || request()->routeIs('view-rekap-detail'))
                                    <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-md rounded-br-md"
                                        aria-hidden="true"></span>
                                @endif
                                <a class="block w-full pl-4" href="{{ route('view-rekap-absensi') }}">Rekap
                                    Absensi</a>
                            </li>

                        </ul>
                    </template>
                </li>
            </ul>
        @endif

        @if (in_array($activeRole, ['super admin', 'keuangan']))
            {{-- Keuangan --}}
            @php
                $isKeuanganActive =
                    request()->routeIs('view-kategori') ||
                    request()->routeIs('view-transaksi') ||
                    request()->routeIs('view-laporan');
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
                        class="inline-flex items-center justify-between w-full text-sm  transition-colors duration-150
        {{ $isKeuanganActive ? 'text-blue-500 dark:text-blue-400' : 'text-gray-800 dark:text-gray-100 hover:text-gray-800 dark:hover:text-gray-100' }}"
                        @click="toggleMenu('keuangan')">
                        <span class="inline-flex items-center">
                            <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                <path d="M12 7.5a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" />
                                <path fill-rule="evenodd"
                                    d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v9.75c0 1.036-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 14.625v-9.75ZM8.25 9.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM18.75 9a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V9.75a.75.75 0 0 0-.75-.75h-.008ZM4.5 9.75A.75.75 0 0 1 5.25 9h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H5.25a.75.75 0 0 1-.75-.75V9.75Z"
                                    clip-rule="evenodd" />
                                <path
                                    d="M2.25 18a.75.75 0 0 0 0 1.5c5.4 0 10.63.722 15.6 2.075 1.19.324 2.4-.558 2.4-1.82V18.75a.75.75 0 0 0-.75-.75H2.25Z" />
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
                                class="relative px-2 py-1 transition-colors duration-150 {{ request()->routeIs('view-kategori') ? 'text-blue-500 ' : 'hover:text-gray-800 dark:hover:text-gray-200' }}">
                                @if (request()->routeIs('view-kategori'))
                                    <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-md rounded-br-md"
                                        aria-hidden="true"></span>
                                @endif
                                <a class="block w-full pl-4" href="{{ route('view-kategori') }}">Kelola Kategori</a>
                            </li>
                            <li
                                class="relative px-2 py-1 transition-colors duration-150 {{ request()->routeIs('view-transaksi') ? 'text-blue-500 ' : 'hover:text-gray-800 dark:hover:text-gray-200' }}">
                                @if (request()->routeIs('view-transaksi'))
                                    <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-md rounded-br-md"
                                        aria-hidden="true"></span>
                                @endif
                                <a class="block w-full pl-4" href="{{ route('view-transaksi') }}">Data Transaksi</a>
                            </li>
                            <li
                                class="relative px-2 py-1 transition-colors duration-150 {{ request()->routeIs('view-laporan') ? 'text-blue-500 ' : 'hover:text-gray-800 dark:hover:text-gray-200' }}">
                                @if (request()->routeIs('view-laporan'))
                                    <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-md rounded-br-md"
                                        aria-hidden="true"></span>
                                @endif
                                <a class="block w-full pl-4" href="{{ route('view-laporan') }}">Laporan Transaksi</a>
                            </li>
                        </ul>
                    </template>
                </li>
            </ul>
        @endif

        @if (in_array($activeRole, ['super admin']))
            {{-- Pengaturan --}}
            <ul>
                <li class="relative px-6 py-3">
                    @if (request()->routeIs('view-akun'))
                        <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg"
                            aria-hidden="true"></span>
                    @endif
                    <a class="inline-flex items-center w-full text-sm  transition-colors duration-150 {{ request()->routeIs('view-akun') ? 'text-blue-500 dark:text-blue-400' : 'text-gray-800 dark:text-gray-100 hover:text-gray-800 dark:hover:text-gray-100' }}"
                        href="{{ route('view-akun') }}">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd"
                                d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 0 0-.986.57c-.166.115-.334.126-.45.083L6.3 5.508a1.875 1.875 0 0 0-2.282.819l-.922 1.597a1.875 1.875 0 0 0 .432 2.385l.84.692c.095.078.17.229.154.43a7.598 7.598 0 0 0 0 1.139c.015.2-.059.352-.153.43l-.841.692a1.875 1.875 0 0 0-.432 2.385l.922 1.597a1.875 1.875 0 0 0 2.282.818l1.019-.382c.115-.043.283-.031.45.082.312.214.641.405.985.57.182.088.277.228.297.35l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.344-.165.673-.356.985-.57.167-.114.335-.125.45-.082l1.02.382a1.875 1.875 0 0 0 2.28-.819l.923-1.597a1.875 1.875 0 0 0-.432-2.385l-.84-.692c-.095-.078-.17-.229-.154-.43a7.614 7.614 0 0 0 0-1.139c-.016-.2.059-.352.153-.43l.84-.692c.708-.582.891-1.59.433-2.385l-.922-1.597a1.875 1.875 0 0 0-2.282-.818l-1.02.382c-.114.043-.282.031-.449-.083a7.49 7.49 0 0 0-.985-.57c-.183-.087-.277-.227-.297-.348l-.179-1.072a1.875 1.875 0 0 0-1.85-1.567h-1.843ZM12 15.75a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="ml-4">Pengaturan Akun</span>
                    </a>
                </li>
            </ul>
        @endif

        @if (in_array($activeRole, ['pegawai']))
            {{-- Profile Pegawai --}}
            <ul class="mt-6">
                <li class="relative px-6 py-3">
                    @if (request()->routeIs('view-profile') || request()->routeIs('view-edit-profile'))
                        <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg"
                            aria-hidden="true"></span>
                    @endif
                    <a class="inline-flex items-center w-full text-sm  transition-colors duration-150 {{ request()->routeIs('view-profile') || request()->routeIs('view-edit-profile')
                        ? 'text-blue-500 dark:text-blue-400'
                        : 'text-gray-800 dark:text-gray-100 hover:text-gray-800 dark:hover:text-gray-100' }}"
                        href="{{ route('view-profile') }}">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                            <path fill-rule="evenodd"
                                d="M4.5 3.75a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V6.75a3 3 0 0 0-3-3h-15Zm4.125 3a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Zm-3.873 8.703a4.126 4.126 0 0 1 7.746 0 .75.75 0 0 1-.351.92 7.47 7.47 0 0 1-3.522.877 7.47 7.47 0 0 1-3.522-.877.75.75 0 0 1-.351-.92ZM15 8.25a.75.75 0 0 0 0 1.5h3.75a.75.75 0 0 0 0-1.5H15ZM14.25 12a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H15a.75.75 0 0 1-.75-.75Zm.75 2.25a.75.75 0 0 0 0 1.5h3.75a.75.75 0 0 0 0-1.5H15Z"
                                clip-rule="evenodd" />
                        </svg>

                        <span class="ml-4">Profile Pegawai</span>
                    </a>
                </li>
                {{-- Profile Kelaurga --}}
                {{-- <li class="relative px-6 py-3">
                    @if (request()->routeIs('view-profile-keluarga') || request()->routeIs('view-edit-profile-keluarga'))
                        <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg"
                            aria-hidden="true"></span>
                    @endif
                    <a class="inline-flex items-center w-full text-sm  transition-colors duration-150 {{ request()->routeIs('view-profile-keluarga') || request()->routeIs('view-edit-profile-keluarga') ? 'text-blue-500 dark:text-blue-400' : 'text-gray-800 dark:text-gray-100 hover:text-gray-800 dark:hover:text-gray-100' }}"
                        href="{{ route('view-profile-keluarga') }}">
                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                        <span class="ml-4">Profile Keluarga</span>
                    </a>
                </li> --}}
                {{-- Absensi --}}
                <li class="relative px-6 py-3">
                    @if (request()->routeIs('view-absen-pegawai') || request()->routeIs('view-riwayat-absen'))
                        <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg"
                            aria-hidden="true"></span>
                    @endif
                    <a class="inline-flex items-center w-full text-sm  transition-colors duration-150 {{ request()->routeIs('view-absen-pegawai') || request()->routeIs('view-riwayat-absen') ? 'text-blue-500 dark:text-blue-400' : 'text-gray-800 dark:text-gray-100 hover:text-gray-800 dark:hover:text-gray-100' }}"
                        href="{{ route('view-absen-pegawai') }}">
                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                        <span class="ml-4">Absensi</span>
                    </a>
                </li>
            </ul>
        @endif

        <div class="px-6 my-6">
            <label
                class="flex items-center justify-center w-full px-4 py-2 text-sm font-bold leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-purple">
                NATA TECH
            </label>
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
        @if (in_array($activeRole, ['super admin', 'hrd', 'keuangan']))
            {{-- Dashboard --}}
            <ul class="mt-6">
                <li class="relative px-6 py-3">
                    @if (request()->routeIs('dashboard'))
                        <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg"
                            aria-hidden="true"></span>
                    @endif
                    <a class="inline-flex items-center w-full text-sm  transition-colors duration-150 {{ request()->routeIs('dashboard') ? 'text-blue-500 dark:text-blue-400' : 'text-gray-800 dark:text-gray-100 hover:text-gray-800 dark:hover:text-gray-100' }}"
                        href="{{ route('dashboard') }}">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path
                                d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
                            <path
                                d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
                        </svg>

                        <span class="ml-4">Dashboard</span>
                    </a>
                </li>
            </ul>
        @endif

        @if (in_array($activeRole, ['super admin']))
            {{-- Master Data --}}
            @php
                $isMasterActive = request()->routeIs('view-jabatan');
            @endphp

            <ul x-data="{
                openMenu: localStorage.getItem('openMenuMasterData') || '',
                toggleMenu(menu) {
                    if (this.openMenu === menu) {
                        this.openMenu = '';
                        localStorage.removeItem('openMenuMasterData');
                    } else {
                        this.openMenu = menu;
                        localStorage.setItem('openMenuMasterData', menu);
                    }
                },
                init() {
                    if (!this.openMenu && '{{ $isMasterActive }}' === '1') {
                        this.openMenu = 'masterData';
                        localStorage.setItem('openMenuMasterData', 'masterData');
                    }
                }
            }" x-init="init()">
                <li class="relative px-6 py-3">
                    <button
                        class="inline-flex items-center justify-between w-full text-sm  transition-colors duration-150
        {{ $isMasterActive ? 'text-blue-500 dark:text-blue-400' : 'text-gray-800 dark:text-gray-100 hover:text-gray-800 dark:hover:text-gray-100' }}"
                        @click="toggleMenu('masterData')">
                        <span class="inline-flex items-center">
                            <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                <path
                                    d="M21 6.375c0 2.692-4.03 4.875-9 4.875S3 9.067 3 6.375 7.03 1.5 12 1.5s9 2.183 9 4.875Z" />
                                <path
                                    d="M12 12.75c2.685 0 5.19-.586 7.078-1.609a8.283 8.283 0 0 0 1.897-1.384c.016.121.025.244.025.368C21 12.817 16.97 15 12 15s-9-2.183-9-4.875c0-.124.009-.247.025-.368a8.285 8.285 0 0 0 1.897 1.384C6.809 12.164 9.315 12.75 12 12.75Z" />
                                <path
                                    d="M12 16.5c2.685 0 5.19-.586 7.078-1.609a8.282 8.282 0 0 0 1.897-1.384c.016.121.025.244.025.368 0 2.692-4.03 4.875-9 4.875s-9-2.183-9-4.875c0-.124.009-.247.025-.368a8.284 8.284 0 0 0 1.897 1.384C6.809 15.914 9.315 16.5 12 16.5Z" />
                                <path
                                    d="M12 20.25c2.685 0 5.19-.586 7.078-1.609a8.282 8.282 0 0 0 1.897-1.384c.016.121.025.244.025.368 0 2.692-4.03 4.875-9 4.875s-9-2.183-9-4.875c0-.124.009-.247.025-.368a8.284 8.284 0 0 0 1.897 1.384C6.809 19.664 9.315 20.25 12 20.25Z" />
                            </svg>

                            <span class="ml-4">Master Data</span>
                        </span>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    <template x-if="openMenu === 'masterData'">
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
                                class="relative px-2 py-1 transition-colors duration-150 {{ request()->routeIs('view-jabatan') ? 'text-blue-500 ' : 'hover:text-gray-800 dark:hover:text-gray-200' }}">
                                @if (request()->routeIs('view-jabatan'))
                                    <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-md rounded-br-md"
                                        aria-hidden="true"></span>
                                @endif
                                <a class="block w-full pl-4" href="{{ route('view-jabatan') }}">Kelola Jabatan</a>
                            </li>
                        </ul>
                    </template>
                </li>
            </ul>
        @endif

        @if (in_array($activeRole, ['super admin', 'hrd']))
            {{-- Kepegawaian --}}
            @php
                $isKepegawaianActive =
                    request()->routeIs('view-pegawai') ||
                    request()->routeIs('tambah-view-pegawai') ||
                    request()->routeIs('edit-view-pegawai') ||
                    request()->routeIs('view-keluarga') ||
                    request()->routeIs('tambah-view-keluarga') ||
                    request()->routeIs('edit-view-keluarga') ||
                    request()->routeIs('detail-view-keluarga') ||
                    request()->routeIs('view-rekap-absensi') ||
                    request()->routeIs('view-rekap-detail');
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
                        class="inline-flex items-center justify-between w-full text-sm  transition-colors duration-150
        {{ $isKepegawaianActive ? 'text-blue-500 dark:text-blue-400' : 'text-gray-800 dark:text-gray-100 hover:text-gray-800 dark:hover:text-gray-100' }}"
                        @click="toggleMenu('kepegawaian')" aria-haspopup="true">
                        <span class="inline-flex items-center">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                                </path>
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
                                class="relative px-2 py-1 transition-colors duration-150 {{ request()->routeIs('view-pegawai') || request()->routeIs('tambah-view-pegawai') || request()->routeIs('edit-view-pegawai') ? 'text-blue-500 ' : 'hover:text-gray-800 dark:hover:text-gray-200' }}">
                                @if (request()->routeIs('view-pegawai') ||
                                        request()->routeIs('tambah-view-pegawai') ||
                                        request()->routeIs('edit-view-pegawai'))
                                    <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-md rounded-br-md"
                                        aria-hidden="true"></span>
                                @endif
                                <a class="block w-full pl-4" href="{{ route('view-pegawai') }}">Data Pegawai</a>
                            </li>

                            {{-- Menu Keluarga --}}
                            {{-- <li
                                class="relative px-2 py-1 transition-colors duration-150 {{ request()->routeIs('view-keluarga') || request()->routeIs('tambah-view-keluarga') || request()->routeIs('edit-view-keluarga') || request()->routeIs('detail-view-keluarga') ? 'text-blue-500 ' : 'hover:text-gray-800 dark:hover:text-gray-200' }}">
                                @if (request()->routeIs('view-keluarga') ||
                                        request()->routeIs('tambah-view-keluarga') ||
                                        request()->routeIs('edit-view-keluarga') ||
                                        request()->routeIs('detail-view-keluarga'))
                                    <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-md rounded-br-md"
                                        aria-hidden="true"></span>
                                @endif
                                <a class="block w-full pl-4" href="{{ route('view-keluarga') }}">Data Keluarga</a>
                            </li> --}}

                            {{-- Menu Absensi --}}
                            <li
                                class="relative px-2 py-1 transition-colors duration-150 {{ request()->routeIs('view-rekap-absensi') || request()->routeIs('view-rekap-detail') ? 'text-blue-500 ' : 'hover:text-gray-800 dark:hover:text-gray-200' }}">
                                @if (request()->routeIs('view-rekap-absensi') || request()->routeIs('view-rekap-detail'))
                                    <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-md rounded-br-md"
                                        aria-hidden="true"></span>
                                @endif
                                <a class="block w-full pl-4" href="{{ route('view-rekap-absensi') }}">Rekap
                                    Absensi</a>
                            </li>

                        </ul>
                    </template>
                </li>
            </ul>
        @endif

        @if (in_array($activeRole, ['super admin', 'keuangan']))
            {{-- Keuangan --}}
            @php
                $isKeuanganActive =
                    request()->routeIs('view-kategori') ||
                    request()->routeIs('view-transaksi') ||
                    request()->routeIs('view-laporan');
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
                        class="inline-flex items-center justify-between w-full text-sm  transition-colors duration-150
        {{ $isKeuanganActive ? 'text-blue-500 dark:text-blue-400' : 'text-gray-800 dark:text-gray-100 hover:text-gray-800 dark:hover:text-gray-100' }}"
                        @click="toggleMenu('keuangan')">
                        <span class="inline-flex items-center">
                            <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                <path d="M12 7.5a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" />
                                <path fill-rule="evenodd"
                                    d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v9.75c0 1.036-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 14.625v-9.75ZM8.25 9.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM18.75 9a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V9.75a.75.75 0 0 0-.75-.75h-.008ZM4.5 9.75A.75.75 0 0 1 5.25 9h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H5.25a.75.75 0 0 1-.75-.75V9.75Z"
                                    clip-rule="evenodd" />
                                <path
                                    d="M2.25 18a.75.75 0 0 0 0 1.5c5.4 0 10.63.722 15.6 2.075 1.19.324 2.4-.558 2.4-1.82V18.75a.75.75 0 0 0-.75-.75H2.25Z" />
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
                                class="relative px-2 py-1 transition-colors duration-150 {{ request()->routeIs('view-kategori') ? 'text-blue-500 ' : 'hover:text-gray-800 dark:hover:text-gray-200' }}">
                                @if (request()->routeIs('view-kategori'))
                                    <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-md rounded-br-md"
                                        aria-hidden="true"></span>
                                @endif
                                <a class="block w-full pl-4" href="{{ route('view-kategori') }}">Kelola Kategori</a>
                            </li>
                            <li
                                class="relative px-2 py-1 transition-colors duration-150 {{ request()->routeIs('view-transaksi') ? 'text-blue-500 ' : 'hover:text-gray-800 dark:hover:text-gray-200' }}">
                                @if (request()->routeIs('view-transaksi'))
                                    <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-md rounded-br-md"
                                        aria-hidden="true"></span>
                                @endif
                                <a class="block w-full pl-4" href="{{ route('view-transaksi') }}">Data Transaksi</a>
                            </li>
                            <li
                                class="relative px-2 py-1 transition-colors duration-150 {{ request()->routeIs('view-laporan') ? 'text-blue-500 ' : 'hover:text-gray-800 dark:hover:text-gray-200' }}">
                                @if (request()->routeIs('view-laporan'))
                                    <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-md rounded-br-md"
                                        aria-hidden="true"></span>
                                @endif
                                <a class="block w-full pl-4" href="{{ route('view-laporan') }}">Laporan Transaksi</a>
                            </li>
                        </ul>
                    </template>
                </li>
            </ul>
        @endif

        @if (in_array($activeRole, ['super admin']))
            {{-- Pengaturan --}}
            <ul>
                <li class="relative px-6 py-3">
                    @if (request()->routeIs('view-akun'))
                        <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg"
                            aria-hidden="true"></span>
                    @endif
                    <a class="inline-flex items-center w-full text-sm  transition-colors duration-150 {{ request()->routeIs('view-akun') ? 'text-blue-500 dark:text-blue-400' : 'text-gray-800 dark:text-gray-100 hover:text-gray-800 dark:hover:text-gray-100' }}"
                        href="{{ route('view-akun') }}">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd"
                                d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 0 0-.986.57c-.166.115-.334.126-.45.083L6.3 5.508a1.875 1.875 0 0 0-2.282.819l-.922 1.597a1.875 1.875 0 0 0 .432 2.385l.84.692c.095.078.17.229.154.43a7.598 7.598 0 0 0 0 1.139c.015.2-.059.352-.153.43l-.841.692a1.875 1.875 0 0 0-.432 2.385l.922 1.597a1.875 1.875 0 0 0 2.282.818l1.019-.382c.115-.043.283-.031.45.082.312.214.641.405.985.57.182.088.277.228.297.35l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.344-.165.673-.356.985-.57.167-.114.335-.125.45-.082l1.02.382a1.875 1.875 0 0 0 2.28-.819l.923-1.597a1.875 1.875 0 0 0-.432-2.385l-.84-.692c-.095-.078-.17-.229-.154-.43a7.614 7.614 0 0 0 0-1.139c-.016-.2.059-.352.153-.43l.84-.692c.708-.582.891-1.59.433-2.385l-.922-1.597a1.875 1.875 0 0 0-2.282-.818l-1.02.382c-.114.043-.282.031-.449-.083a7.49 7.49 0 0 0-.985-.57c-.183-.087-.277-.227-.297-.348l-.179-1.072a1.875 1.875 0 0 0-1.85-1.567h-1.843ZM12 15.75a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="ml-4">Pengaturan Akun</span>
                    </a>
                </li>
            </ul>
        @endif


        @if (in_array($activeRole, ['pegawai']))
            {{-- Profile Pegawai --}}
            <ul class="mt-6">
                <li class="relative px-6 py-3">
                    @if (request()->routeIs('view-profile') || request()->routeIs('view-edit-profile'))
                        <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg"
                            aria-hidden="true"></span>
                    @endif
                    <a class="inline-flex items-center w-full text-sm  transition-colors duration-150 {{ request()->routeIs('view-profile') || request()->routeIs('view-edit-profile')
                        ? 'text-blue-500 dark:text-blue-400'
                        : 'text-gray-800 dark:text-gray-100 hover:text-gray-800 dark:hover:text-gray-100' }}"
                        href="{{ route('view-profile') }}">
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
                {{-- <li class="relative px-6 py-3">
                    @if (request()->routeIs('view-profile-keluarga') || request()->routeIs('view-edit-profile-keluarga'))
                        <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg"
                            aria-hidden="true"></span>
                    @endif
                    <a class="inline-flex items-center w-full text-sm  transition-colors duration-150 {{ request()->routeIs('view-profile-keluarga') || request()->routeIs('view-edit-profile-keluarga') ? 'text-blue-500 dark:text-blue-400' : 'text-gray-800 dark:text-gray-100 hover:text-gray-800 dark:hover:text-gray-100' }}"
                        href="{{ route('view-profile-keluarga') }}">
                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                        <span class="ml-4">Profile Keluarga</span>
                    </a>
                </li> --}}
                {{-- Absensi --}}
                <li class="relative px-6 py-3">
                    @if (request()->routeIs('view-absen-pegawai') || request()->routeIs('view-riwayat-absen'))
                        <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg"
                            aria-hidden="true"></span>
                    @endif
                    <a class="inline-flex items-center w-full text-sm  transition-colors duration-150 {{ request()->routeIs('view-absen-pegawai') || request()->routeIs('view-riwayat-absen') ? 'text-blue-500 dark:text-blue-400' : 'text-gray-800 dark:text-gray-100 hover:text-gray-800 dark:hover:text-gray-100' }}"
                        href="{{ route('view-absen-pegawai') }}">
                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                            <path d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                        </svg>
                        <span class="ml-4">Absensi</span>
                    </a>
                </li>
            </ul>
        @endif

        <div class="px-6 my-6">
            <label
                class="flex items-center justify-center w-full px-4 py-2 text-sm font-bold leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-purple">
                NATA TECH
            </label>
        </div>
    </div>
</aside>
