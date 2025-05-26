<x-app-layout>
    @section('title', 'Pengaturan Akun')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200 tracking-tight">Pengaturan Akun</h1>

        @if (session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 2000)" x-show="show" x-transition
                class="bg-green-100 text-green-800 p-3 rounded mb-4 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <form method="GET" action="{{ route('view-akun') }}" class="mb-6 space-y-4 md:space-y-0">
            <!-- Tambah button mobile -->
            <div class="mb-6 space-y-4 md:space-y-0">
                <div class="md:hidden">
                    <a href="{{ route('view-akun', ['modal' => 'tambah', 'page' => request('page')]) }}"
                        class="w-full block text-center bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm shadow">
                        + Tambah
                    </a>
                </div>

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto md:flex-1">
                        <!-- Search -->
                        <input type="text" id="search-input" name="search" value="{{ request('search') }}"
                            placeholder="Cari Nama, NIP, atau Email"
                            class="w-full sm:w-64 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm shadow-sm">

                        <!-- Filter Role -->
                        <select name="role" onchange="this.form.submit()"
                            class="w-full sm:w-52 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm shadow-sm">
                            <option value="">-- Filter berdasarkan role --</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}"
                                    {{ request('role') === $role->name ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Reset -->
                        @if (request('search') || request('role'))
                            <a href="{{ route('view-akun') }}"
                                class="inline-flex items-center justify-center bg-red-500 text-gray-200 hover:bg-red-600 px-4 py-2 rounded text-sm shadow-sm transition">
                                Reset
                            </a>
                        @endif
                    </div>

                    <!-- Tambah button -->
                    <div class="hidden md:block">
                        <a href="{{ route('view-akun', ['modal' => 'tambah', 'page' => request('page')]) }}"
                            class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm shadow">
                            + Tambah
                        </a>
                    </div>
                </div>
            </div>
        </form>

        <!-- Tabel Akun -->
        <div class="overflow-x-auto no-scrollbar rounded-lg shadow ring-1 ring-black ring-opacity-5">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr class="text-gray-700 dark:text-gray-300 text-left">
                        <th class="px-4 py-3 font-semibold">No</th>
                        <th class="px-4 py-3 font-semibold">Nama</th>
                        <th class="px-4 py-3 font-semibold">NIP</th>
                        <th class="px-4 py-3 font-semibold">Email</th>
                        <th class="px-4 py-3 font-semibold">Role</th>
                        <th class="px-4 py-3 font-semibold text-center sticky right-0 bg-gray-50 dark:bg-gray-700 z-5">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($users as $user)
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-800">
                            <td class="px-4 py-3 text-center text-gray-800 dark:text-gray-200">
                                {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                            <td class="px-4 py-3 text-gray-800 dark:text-gray-200">
                                {{ $user->pegawai ? $user->pegawai->nama : '-' }}
                            </td>
                            <td class="px-4 py-3 text-gray-800 dark:text-gray-200">{{ $user->nip }}</td>
                            <td class="px-4 py-3 text-gray-800 dark:text-gray-200">{{ $user->email }}</td>
                            <td class="px-4 py-3 text-gray-800 dark:text-gray-200">
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($user->roles as $role)
                                        @php
                                            $colorMap = [
                                                'super admin' => 'bg-red-600',
                                                'hrd' => 'bg-orange-600',
                                                'keuangan' => 'bg-blue-600',
                                                'pegawai' => 'bg-green-600',
                                                'kontributor' => 'bg-purple-600',
                                            ];
                                            $color = $colorMap[$role->name] ?? 'bg-gray-300 text-gray-700';
                                        @endphp
                                        <span
                                            class="inline-block {{ $color }} text-white px-2 py-1 rounded text-xs font-semibold mr-1">
                                            {{ ucfirst($role->name) }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-4 py-2 text-center sticky right-0 bg-white dark:bg-gray-900 z-5">
                                <a href="{{ route('view-akun', ['modal' => 'edit', 'user' => $user->id, 'search' => request('search'), 'role' => request('role'), 'page' => request('page')]) }}"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded text-xs font-medium shadow-sm">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @php
            $currentPage = $users->currentPage();
            $lastPage = $users->lastPage();
            $start = max($currentPage - 1, 2);
            $end = min($currentPage + 1, $lastPage - 1);
        @endphp

        <div
            class="flex flex-col md:flex-row justify-between items-start md:items-center mt-4 text-sm text-gray-700 dark:text-gray-300 space-y-2 md:space-y-0">
            <div>
                Tampil {{ $users->firstItem() }} sampai {{ $users->lastItem() }} dari {{ $users->total() }} data
            </div>

            @if ($lastPage > 1)
                <div class="flex items-center space-x-1">
                    {{-- Previous --}}
                    @if ($users->onFirstPage())
                        <span
                            class="px-3 py-1 rounded border bg-white dark:bg-gray-900 text-gray-400 dark:text-gray-500 cursor-not-allowed">
                            &lt;
                        </span>
                    @else
                        <a href="{{ $users->previousPageUrl() }}"
                            class="px-3 py-1 rounded border bg-white text-gray-700 border-gray-300 hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600">
                            &lt;
                        </a>
                    @endif

                    {{-- First page --}}
                    <a href="{{ $users->url(1) }}"
                        class="px-3 py-1 rounded border {{ $currentPage == 1 ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600' }}">
                        1
                    </a>

                    {{-- Ellipsis before --}}
                    @if ($start > 2)
                        <span class="px-2 text-gray-500 dark:text-gray-400">...</span>
                    @endif

                    {{-- Page range --}}
                    @for ($i = $start; $i <= $end; $i++)
                        <a href="{{ $users->url($i) }}"
                            class="px-3 py-1 rounded border {{ $currentPage == $i ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600' }}">
                            {{ $i }}
                        </a>
                    @endfor

                    {{-- Ellipsis after --}}
                    @if ($end < $lastPage - 1)
                        <span class="px-2 text-gray-500 dark:text-gray-400">...</span>
                    @endif

                    {{-- Last page --}}
                    @if ($lastPage > 1)
                        <a href="{{ $users->url($lastPage) }}"
                            class="px-3 py-1 rounded border {{ $currentPage == $lastPage ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600' }}">
                            {{ $lastPage }}
                        </a>
                    @endif

                    {{-- Next --}}
                    @if ($users->hasMorePages())
                        <a href="{{ $users->nextPageUrl() }}"
                            class="px-3 py-1 rounded border bg-white text-gray-700 border-gray-300 hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600">
                            &gt;
                        </a>
                    @else
                        <span
                            class="px-3 py-1 rounded border bg-white dark:bg-gray-900 text-gray-400 dark:text-gray-500 cursor-not-allowed">
                            &gt;
                        </span>
                    @endif
                </div>
            @endif
        </div>


        <!-- Modal Tambah Akun -->
        @if (request('modal') === 'tambah' || $errors->any())
            <div class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center px-4">
                <div
                    class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 rounded-xl shadow-lg w-full max-w-xl p-6">
                    <form method="POST" action="{{ route('tambah-akun') }}">
                        @csrf
                        <input type="hidden" name="page" value="{{ request('page') }}">
                        <h3 class="text-2xl font-semibold mb-6 text-gray-800 dark:text-gray-200">Tambah Akun</h3>

                        <div class="space-y-4">

                            <input name="nip" maxlength="16" placeholder="NIP"
                                class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{ old('nip') }}" required>
                            <x-input-error :messages="$errors->get('nip')" class="mt-1" />

                            <input name="email" type="email" placeholder="Email"
                                class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{ old('email') }}" required>
                            <x-input-error :messages="$errors->get('email')" class="mt-1" />

                            <input name="password" type="password" autocomplete="new-password" placeholder="Password"
                                class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />

                            <div>
                                <label class="block font-semibold mb-2">Role:</label>
                                <div class="flex flex-wrap gap-3">
                                    @foreach ($roles as $role)
                                        <label class="inline-flex items-center space-x-2">
                                            <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                                class="text-blue-500 dark:text-blue-400"
                                                {{ is_array(old('roles')) && in_array($role->name, old('roles')) ? 'checked' : '' }}>
                                            <span>{{ ucfirst($role->name) }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <x-input-error :messages="$errors->get('roles')" class="mt-1" />
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-2">
                            <a href="{{ route('view-akun', request()->only(['search', 'role', 'page'])) }}"
                                class="px-4 py-2 rounded-lg bg-gray-500 hover:bg-gray-600 text-white text-sm">Batal</a>
                            <button type="submit"
                                class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        <!-- Modal Edit Error -->
        @if (request('modal') === 'edit' && request('user') && !$editUser)
            <div class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center px-4">
                <div
                    class="bg-white dark:bg-gray-900 text-red-600 dark:text-red-400 rounded-xl shadow-lg w-full max-w-md p-6 text-center">
                    <h3 class="text-xl font-semibold mb-4">Error</h3>
                    <p>Akun tidak ditemukan dalam daftar.</p>
                    <div class="mt-6">
                        <a href="{{ route('view-akun') }}"
                            class="px-4 py-2 rounded-lg bg-gray-500 hover:bg-gray-600 text-white text-sm">Tutup</a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Modal Edit Akun -->
        @if (request('modal') === 'edit' && $editUser)
            <div class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center px-4">
                <div
                    class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 rounded-xl shadow-lg w-full max-w-xl p-6">
                    <form method="POST" action="{{ route('update-akun', $editUser->id) }}">
                        @csrf
                        <h3 class="text-2xl font-semibold mb-6 text-gray-800 dark:text-gray-200">Edit Akun</h3>

                        <div class="space-y-4">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <input type="hidden" name="role" value="{{ request('role') }}">
                            <input type="hidden" name="page" value="{{ request('page') }}">

                            <input name="nip"
                                class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                                value="{{ old('nip', $editUser->nip) }}" required>
                            <x-input-error :messages="$errors->get('nip')" class="mt-1" />

                            <input name="email" type="email"
                                class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                                value="{{ old('email', $editUser->email) }}" required>
                            <x-input-error :messages="$errors->get('email')" class="mt-1" />

                            <input name="password" type="password" placeholder="Password (kosongkan jika tidak ubah)"
                                class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />

                            <input name="password_confirmation" type="password" placeholder="Konfirmasi Password"
                                class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">

                            <div>
                                <label class="block font-semibold mb-2">Role:</label>
                                <div class="flex flex-wrap gap-3">
                                    @foreach ($roles as $role)
                                        <label class="inline-flex items-center space-x-2">
                                            <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                                class="text-green-600 dark:text-green-400"
                                                {{ $editUser->roles->pluck('name')->contains($role->name) ? 'checked' : '' }}>
                                            <span>{{ ucfirst($role->name) }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <x-input-error :messages="$errors->get('roles')" class="mt-1" />
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-2">
                            <a href="{{ route('view-akun', request()->only(['search', 'role', 'page'])) }}"
                                class="px-4 py-2 rounded-lg bg-gray-500 hover:bg-gray-600 text-white text-sm">Batal</a>
                            <button type="submit"
                                class="px-4 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white text-sm">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

</x-app-layout>
