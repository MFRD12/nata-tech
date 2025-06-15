<x-app-layout>
    @section('title', 'Pengaturan Akun')
    <div class="px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">

            <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200 tracking-tight">Pengaturan Akun</h1>

            @if (session('success'))
                <x-alert type="success" :message="session('success')" :duration="3000" />
            @endif

            @if (session('error'))
                <x-alert type="error" :message="session('error')" :duration="3000" :title="'Update Gagal!'" />
            @endif

            <!-- Modal Tambah Akun dengan logika error handling -->
            <div x-data="{
                showModal: false,
                showError: @if ($errors->any() && old('form_context') === 'add_akun') true @else false @endif,
                clearInput() {
                    document.getElementById('add_nip').value = '';
                    document.getElementById('add_email').value = '';
                    document.getElementById('add_password').value = '';
                    const checkboxes = document.querySelectorAll('input[name=\'add_roles[]\']');
                    checkboxes.forEach(checkbox => checkbox.checked = false);
                    this.showError = false;
                }
            }" x-init="@if($errors->any() && old('form_context') === 'add_akun')
            showModal = true;
            @endif">

                <!-- Form Filter dan Tambah Button -->
                <form method="GET" action="{{ route('view-akun') }}" class="mb-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto md:flex-1">
                            <div>
                                <select name="perPage" onchange="this.form.submit()"
                                    class=" w-16 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm shadow-sm">
                                    @foreach ([10, 20, 50, 100] as $size)
                                        <option value="{{ $size }}"
                                            {{ request('perPage', 10) == $size ? 'selected' : '' }}>
                                            {{ $size }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
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
                                <a href="{{ route('view-akun', ['perPage' => request('perPage', 10)]) }}"
                                    class="inline-flex items-center justify-center bg-red-500 text-gray-200 hover:bg-red-600 px-4 py-2 rounded text-sm shadow-sm transition">
                                    Reset
                                </a>
                            @endif
                        </div>
                        <!-- Tambah button desktop -->
                        <div class="flex justify-end md:justify-start">
                            <button type="button" @click="showModal = true"
                                class="w-full md:w-auto bg-blue-600 text-white px-4 py-3 rounded hover:bg-blue-700 text-sm shadow">
                                <i class="fas fa-plus"></i> Tambah
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Modal Tambah Akun -->
                <div x-show="showModal"
                    class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50 px-4">
                    <div @click.away="showModal = false; clearInput()"
                        class="bg-white dark:bg-gray-800 p-6 rounded-lg w-full max-w-xl shadow-lg relative overflow-auto max-h-[90vh]">
                        <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Tambah Akun</h2>

                        <form action="{{ route('tambah-akun') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="form_context" value="add_akun">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <input type="hidden" name="role" value="{{ request('role') }}">
                            <input type="hidden" name="page" value="{{ request('page') }}">
                            <input type="hidden" name="perPage" value="{{ request('perPage', 10) }}">

                            <div>
                                <label for="add_nip"
                                    class="block py-2 text-sm font-medium text-gray-700 dark:text-gray-200">NIP</label>
                                <input type="text" name="nip" id="add_nip" maxlength="16"
                                    value="{{ old('form_context') === 'add_akun' ? old('nip') : '' }}" required
                                    :class="(showError && '{{ old('form_context') === 'add_akun' && $errors->has('nip') }}') ?
                                    'border-red-500 focus:border-red-500 focus:ring-red-500' :
                                    'border-gray-300 dark:border-gray-600 focus:border-blue-500 focus:ring-blue-500'"
                                    class="w-full px-3 py-2 border rounded-md bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring">

                                <div x-show="showError && '{{ old('form_context') === 'add_akun' && $errors->has('nip') }}'"
                                    class="mt-2">
                                    <x-input-error :messages="$errors->get('nip')" class="mt-2" />
                                </div>
                            </div>

                            <div>
                                <label for="add_email"
                                    class="block py-2 text-sm font-medium text-gray-700 dark:text-gray-200">Email</label>
                                <input type="email" name="email" id="add_email"
                                    value="{{ old('form_context') === 'add_akun' ? old('email') : '' }}" required
                                    :class="(showError &&
                                        '{{ old('form_context') === 'add_akun' && $errors->has('email') }}') ?
                                    'border-red-500 focus:border-red-500 focus:ring-red-500' :
                                    'border-gray-300 dark:border-gray-600 focus:border-blue-500 focus:ring-blue-500'"
                                    class="w-full px-3 py-2 border rounded-md bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring">

                                <div x-show="showError && '{{ old('form_context') === 'add_akun' && $errors->has('email') }}'"
                                    class="mt-2">
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                            </div>

                            <div>
                                <label for="add_password"
                                    class="block py-2 text-sm font-medium text-gray-700 dark:text-gray-200">Password</label>
                                <input type="password" name="password" id="add_password" autocomplete="new-password"
                                    required
                                    :class="(showError &&
                                        '{{ old('form_context') === 'add_akun' && $errors->has('password') }}') ?
                                    'border-red-500 focus:border-red-500 focus:ring-red-500' :
                                    'border-gray-300 dark:border-gray-600 focus:border-blue-500 focus:ring-blue-500'"
                                    class="w-full px-3 py-2 border rounded-md bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring">

                                <div x-show="showError && '{{ old('form_context') === 'add_akun' && $errors->has('password') }}'"
                                    class="mt-2">
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>
                            </div>

                            <div>
                                <label
                                    class="block py-2 text-sm font-medium text-gray-700 dark:text-gray-200">Role:</label>
                                <div class="flex flex-wrap gap-3">
                                    @foreach ($roles as $role)
                                        <label class="inline-flex items-center space-x-2"
                                            @if (old('form_context') === 'add_akun' && $errors->has('roles')) text-red-500 dark:text-red-400 @endif">
                                            <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                                id="add_role_{{ $role->id }}"
                                                class="text-blue-500 dark:text-blue-400"
                                                {{ old('form_context') === 'add_akun' && is_array(old('roles')) && in_array($role->name, old('roles')) ? 'checked' : '' }}>
                                            <span
                                                class="text-gray-700 dark:text-gray-200">{{ ucfirst($role->name) }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div x-show="showError && '{{ old('form_context') === 'add_akun' && $errors->has('roles') }}'"
                                    class="mt-2">
                                    <x-input-error :messages="$errors->get('roles')" class="mt-2" />
                                </div>
                            </div>

                            <div class="flex justify-end gap-3 mt-4">
                                <button type="button" @click="showModal = false; clearInput()"
                                    class="px-4 py-2 bg-red-600 text-white hover:bg-red-400 dark:hover:bg-red-500 rounded transition">
                                    <i class="fas fa-xmark"></i> Batal
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tabel Akun -->
            <div
                class="overflow-x-auto no-scrollbar rounded-lg shadow ring-1 ring-black ring-opacity-5 border border-gray-200 dark:border-gray-700">
                <table class="min-w-full text-sm divide-y divide-gray-200 dark:divide-gray-700 text-center">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr class="text-gray-700 dark:text-gray-300 divide-x divide-gray-200 dark:divide-gray-700">
                            <th class="px-4 py-3 font-semibold">No</th>
                            <th class="px-4 py-3 font-semibold">Nama</th>
                            <th class="px-4 py-3 font-semibold">NIP</th>
                            <th class="px-4 py-3 font-semibold">Email</th>
                            <th class="px-4 py-3 font-semibold">Role</th>
                            <th class="px-4 py-3 font-semibold text-center bg-gray-50 dark:bg-gray-700 z-5">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($users as $user)
                            <tr
                                class="hover:bg-gray-100 dark:hover:bg-gray-800 divide-x divide-gray-200 dark:divide-gray-700">
                                <td class="px-4 py-3 text-center text-gray-800 dark:text-gray-200">
                                    {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                                </td>
                                <td
                                    class="px-4 py-3 text-gray-800 dark:text-gray-200 text-left whitespace-nowrap sm:whitespace-normal">
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
                                <td class="px-4 py-2 text-center bg-white dark:bg-gray-900 z-5">
                                    <!-- Modal Edit dengan logika error handling per user -->
                                    <div x-data="{
                                        showModalEdit: false,
                                        showErrorEdit: @if ($errors->any() && old('form_context') === 'update_akun_' . $user->id) true @else false @endif,
                                        clearEditError() {
                                            this.showErrorEdit = false;
                                        },
                                        openEditModal() {
                                            this.$refs.dataNip.value = '{{ $user->nip }}';
                                            this.$refs.dataEmail.value = '{{ $user->email }}';
                                    
                                            this.showModalEdit = true;
                                        }
                                    }" x-init="@if ($errors->any() && old('form_context') === 'update_akun_' . $user->id) showModalEdit = true; @endif">

                                        <button @click="openEditModal()"
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded text-xs font-medium shadow-sm">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Modal Edit Akun -->
                                        <div x-show="showModalEdit"
                                            class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50 px-4">
                                            <div @click.away="showModalEdit = false; clearEditError()"
                                                class="bg-white dark:bg-gray-800 p-6 rounded-lg w-full max-w-xl shadow-lg relative overflow-auto max-h-[90vh]">
                                                <h2
                                                    class="text-xl font-bold text-gray-800 dark:text-white mb-4 text-left">
                                                    Edit Akun</h2>

                                                <form action="{{ route('update-akun', $user->id) }}" method="POST"
                                                    class="space-y-4">
                                                    @csrf
                                                    @method('POST')

                                                    <input type="hidden" name="form_context"
                                                        value="update_akun_{{ $user->id }}">
                                                    <input type="hidden" name="search"
                                                        value="{{ request('search') }}">
                                                    <input type="hidden" name="role"
                                                        value="{{ request('role') }}">
                                                    <input type="hidden" name="page"
                                                        value="{{ request('page') }}">
                                                    <input type="hidden" name="perPage"
                                                        value="{{ request('perPage', 10) }}">

                                                    <div>
                                                        <label for="edit_nip_{{ $user->id }}"
                                                            class="block py-2 text-sm font-medium text-gray-700 dark:text-gray-200 text-left">NIP</label>
                                                        <input type="text" name="nip" x-ref="dataNip"
                                                            id="edit_nip_{{ $user->id }}" maxlength="16"
                                                            value="{{ old('form_context') === 'update_akun_' . $user->id && $errors->any() ? old('nip') : $user->nip }}"
                                                            required
                                                            :class="(showErrorEdit &&
                                                                '{{ old('form_context') === 'update_akun_' . $user->id && $errors->has('nip') }}'
                                                            ) ?
                                                            'border-red-500 focus:border-red-500 focus:ring-red-500' :
                                                            'border-gray-300 dark:border-gray-600 focus:border-blue-500 focus:ring-blue-500'"
                                                            class="w-full px-3 py-2 border rounded-md bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring">

                                                        <div x-show="showErrorEdit && '{{ old('form_context') === 'update_akun_' . $user->id && $errors->has('nip') }}'"
                                                            class="mt-2">
                                                            <x-input-error :messages="$errors->get('nip')" class="mt-2" />
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <label for="edit_email_{{ $user->id }}"
                                                            class="block py-2 text-sm font-medium text-gray-700 dark:text-gray-200 text-left">Email</label>
                                                        <input type="email" name="email" x-ref="dataEmail"
                                                            id="edit_email_{{ $user->id }}"
                                                            value="{{ old('form_context') === 'update_akun_' . $user->id && $errors->any() ? old('email') : $user->email }}"
                                                            required
                                                            :class="(showErrorEdit &&
                                                                '{{ old('form_context') === 'update_akun_' . $user->id && $errors->has('email') }}'
                                                            ) ?
                                                            'border-red-500 focus:border-red-500 focus:ring-red-500' :
                                                            'border-gray-300 dark:border-gray-600 focus:border-blue-500 focus:ring-blue-500'"
                                                            class="w-full px-3 py-2 border rounded-md bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring">

                                                        <div x-show="showErrorEdit && '{{ old('form_context') === 'update_akun_' . $user->id && $errors->has('email') }}'"
                                                            class="mt-2">
                                                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                                        </div>
                                                    </div>


                                                    <div>
                                                        <label for="edit_password_{{ $user->id }}"
                                                            class="block py-2 text-sm font-medium text-gray-700 dark:text-gray-200 text-left">Password</label>
                                                        <input type="password" name="password"
                                                            id="edit_password_{{ $user->id }}"
                                                            placeholder="Password (kosongkan jika tidak ubah)"
                                                            class="w-full px-3 py-2 border rounded-md bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring">

                                                        <label for="edit_password_confirmation_{{ $user->id }}"
                                                            class="block py-2 text-sm font-medium text-gray-700 dark:text-gray-200 text-left mt-4">Konfirmasi
                                                            Password</label>
                                                        <input type="password" name="password_confirmation"
                                                            id="edit_password_confirmation_{{ $user->id }}"
                                                            placeholder="Konfirmasi Password"
                                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring focus:border-blue-500 focus:ring-blue-500">

                                                        <div x-show="showErrorEdit && '{{ old('form_context') === 'update_akun_' . $user->id && $errors->has('password') }}'"
                                                            class="mt-2">
                                                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                                        </div>
                                                    </div>


                                                    <div>
                                                        <label
                                                            class="block py-2 text-sm font-medium text-gray-700 dark:text-gray-200 text-left">Role:</label>
                                                        <div class="flex flex-wrap gap-3">
                                                            @foreach ($roles as $role)
                                                                <label class="inline-flex items-center space-x-2"
                                                                    @if (old('form_context') === 'update_akun_' . $user->id && $errors->has('roles')) text-red-500 dark:text-red-400 @endif>
                                                                    <input type="checkbox" name="roles[]"
                                                                        id="edit_role_{{ $user->id }}_{{ $role->id }}"
                                                                        value="{{ $role->name }}"
                                                                        class="text-blue-500 dark:text-blue-400"
                                                                        @if (old('form_context') === 'update_akun_' . $user->id && $errors->any()) {{ is_array(old('roles')) && in_array($role->name, old('roles')) ? 'checked' : '' }}
                                                                        @else
                                                                            {{ $user->roles->pluck('name')->contains($role->name) ? 'checked' : '' }} @endif>
                                                                    <span
                                                                        class="text-gray-700 dark:text-gray-200">{{ ucfirst($role->name) }}</span>
                                                                </label>
                                                            @endforeach
                                                        </div>
                                                        <div x-show="showErrorEdit && '{{ old('form_context') === 'update_akun_' . $user->id && $errors->has('roles') }}'"
                                                            class="mt-2">
                                                            <x-input-error :messages="$errors->get('roles')" class="mt-2" />
                                                        </div>
                                                    </div>

                                                    <div class="flex justify-end gap-3 mt-4">
                                                        <button type="button"
                                                            @click="showModalEdit = false; clearEditError()"
                                                            class="px-4 py-2 bg-red-600 text-white hover:bg-red-400 dark:hover:bg-red-500 rounded transition">
                                                            <i class="fas fa-xmark"></i> Batal
                                                        </button>
                                                        <button type="submit"
                                                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                                            Update
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-5 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada data akun yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- Pagination --}}
            <x-pagination-links :paginator="$users" />
        </div>
    </div>
</x-app-layout>
