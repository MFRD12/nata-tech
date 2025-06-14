<x-app-layout>
    @section('title', 'Kelola Kategori')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">

            <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200 tracking-tight">Kelola Kategori</h1>

            @if (session('success'))
                <x-alert type="success" :message="session('success')" :duration="3000" />
            @endif

            @if (session('error'))
                <x-modal-error :show="true" :message="session('error')" title="Akses Ditolak" closeRoute="view-kategori" />
            @endif

            <div x-data="{
                showModal: false,
                showError: @if ($errors->any() && old('form_context') === 'add_kategori') true @else false @endif,
                clearInput() {
                    document.getElementById('add_name').value = '';
                    document.getElementById('add_jenis').value = '';
                    this.showError = false;
                }
            }" x-init="() => {
                @if($errors->any() && old('form_context') === 'add_kategori')
                showModal = true;
                @endif
            }">

                <!-- Form Filter dan Tambah Button -->
                <form method="GET" action="{{ route('view-kategori') }}" class="mb-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                        <div class="flex flex-col gap-3 w-full md:flex-row md:items-center md:flex-1">
                            <!-- Search -->
                            <input type="text" id="search-input" name="search" value="{{ request('search') }}"
                                placeholder="Cari Nama Kategori"
                                class="w-full md:w-64 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm shadow-sm">

                            <!-- Filter Jenis -->
                            <select name="filter_jenis" onchange="this.form.submit()"
                                class="w-full md:w-52 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm shadow-sm">
                                <option value="">-- Filter Jenis --</option>
                                <option value="pemasukan"
                                    {{ request('filter_jenis') === 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                                <option value="pengeluaran"
                                    {{ request('filter_jenis') === 'pengeluaran' ? 'selected' : '' }}>Pengeluaran
                                </option>
                            </select>

                            <!-- Reset -->
                            @if (request('search') || request('filter_jenis'))
                                <a href="{{ route('view-kategori') }}"
                                    class="inline-flex items-center justify-center bg-red-500 text-white hover:bg-red-600 px-4 py-2 rounded text-sm shadow-sm transition">
                                    Reset
                                </a>
                            @endif
                        </div>

                        <!-- Kanan: Tombol Tambah -->
                        <div class="flex justify-end md:justify-start">
                            <button type="button" @click="showModal = true"
                                class="w-full md:w-auto bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm shadow">
                                <i class="fas fa-plus"></i> Tambah
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Modal Tambah Kategori -->
                <div x-show="showModal"
                    class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50 px-4" x-cloak>
                    <div @click.away="showModal = false; clearInput()"
                        class="bg-white dark:bg-gray-800 p-6 rounded-lg w-full max-w-xl shadow-lg relative overflow-auto max-h-[90vh]">
                        <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Tambah Kategori</h2>

                        <form action="{{ route('tambah-kategori') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="form_context" value="add_kategori">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <input type="hidden" name="filter_jenis" value="{{ request('filter_jenis') }}">

                            <div>
                                <label for="add_name"
                                    class="block py-2 text-sm font-medium text-gray-700 dark:text-gray-200">Nama
                                    Kategori</label>
                                <input type="text" name="name" id="add_name"
                                    value="{{ old('form_context') === 'add_kategori' ? old('name') : '' }}" required
                                    :class="(showError &&
                                        '{{ old('form_context') === 'add_kategori' && $errors->has('name') }}') ?
                                    'border-red-500 focus:border-red-500 focus:ring-red-500' :
                                    'border-gray-600 focus:border-blue-500 focus:ring-blue-500'"
                                    class="w-full px-3 py-2 border rounded-md bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring">

                                <div x-show="showError && '{{ old('form_context') === 'add_kategori' && $errors->has('name') }}'"
                                    class="mt-2">
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                            </div>

                            <div>
                                <label for="add_jenis"
                                    class="block py-2 text-sm font-medium text-gray-700 dark:text-gray-200">Jenis</label>
                                <select name="jenis" id="add_jenis" required
                                    :class="(showError &&
                                        '{{ old('form_context') === 'add_kategori' && $errors->has('jenis') }}') ?
                                    'border-red-500 focus:border-red-500 focus:ring-red-500' :
                                    'border-gray-600 focus:border-blue-500 focus:ring-blue-500'"
                                    class="w-full px-3 py-2 border rounded-md bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring">
                                    <option value="" disabled
                                        {{ (old('form_context') === 'add_kategori' && old('jenis') == '') || old('form_context') !== 'add_kategori' ? 'selected' : '' }}>
                                        -- Pilih Jenis --</option>
                                    <option value="pemasukan"
                                        {{ old('form_context') === 'add_kategori' && old('jenis') === 'pemasukan' ? 'selected' : '' }}>
                                        Pemasukan</option>
                                    <option value="pengeluaran"
                                        {{ old('form_context') === 'add_kategori' && old('jenis') === 'pengeluaran' ? 'selected' : '' }}>
                                        Pengeluaran</option>
                                </select>

                                <div x-show="showError && '{{ old('form_context') === 'add_kategori' && $errors->has('jenis') }}'"
                                    class="mt-2">
                                    <x-input-error :messages="$errors->get('jenis')" class="mt-2" />
                                </div>
                            </div>
                            <div class="flex justify-end gap-3 mt-4">
                                <button type="button" @click="showModal = false; clearInput()"
                                    class="px-4 py-2 bg-red-600 text-white hover:bg-red-400 dark:hover:bg-red-500 rounded transition">
                                    <i class="fas fa-xmark"></i> Batal
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tabel Kategori -->
            <div
                class="overflow-auto no-scrollbar rounded-lg shadow ring-1 ring-black ring-opacity-5 border border-gray-200 dark:border-gray-700 max-h-[60vh]">
                <table class="min-w-full text-sm divide-y divide-gray-200 dark:divide-gray-700 text-center">
                    <thead class="bg-gray-100 dark:bg-gray-700 sticky top-0 z-10">
                        <tr class="text-gray-700 dark:text-gray-300 divide-x divide-gray-200 dark:divide-gray-700">
                            <th class="px-2 py-3 font-semibold">No</th>
                            <th class="px-4 py-3 font-semibold">Nama Kategori</th>
                            <th class="px-2 py-3 font-semibold">Jenis</th>
                            <th class="px-4 py-3 font-semibold z-10">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($kategoris as $kategori)
                            <tr
                                class="hover:bg-gray-100 dark:hover:bg-gray-800 divide-x divide-gray-200 dark:divide-gray-700">
                                <td class="px-2 py-3 text-gray-800 dark:text-gray-200">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-4 py-3 text-gray-800 dark:text-gray-200">{{ $kategori->name }}</td>
                                <td class="px-2 py-3 text-gray-800 dark:text-gray-200">
                                    <span
                                        class="inline-block px-2 py-1 rounded text-xs font-semibold
                                        {{ $kategori->jenis === 'pemasukan' ? 'bg-green-100 text-green-700 dark:bg-green-700 dark:text-green-100' : 'bg-red-100 text-red-700 dark:bg-red-700 dark:text-red-100' }}">
                                        {{ ucfirst($kategori->jenis) }}
                                    </span>
                                </td>
                                <td
                                    class="flex gap-2 justify-center items-center px-2 py-2 text-center bg-white dark:bg-gray-900">
                                    <div x-data="{
                                        showModalEdit: false,
                                        showErrorEdit: @if ($errors->any() && old('form_context') === 'update_kategori_' . $kategori->id) true @else false @endif,
                                        clearEditError() {
                                            this.showErrorEdit = false;
                                        },
                                        openEditModal() {
                                            this.$refs.dataName.value = '{{ $kategori->name }}';
                                            this.$refs.dataJenis.value = '{{ $kategori->jenis }}';
                                            this.showModalEdit = true;
                                        }
                                    }" x-init="@if ($errors->any() && old('form_context') === 'update_kategori_' . $kategori->id) showModalEdit = true; @endif">
                                        <button @click="openEditModal()"
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded text-xs font-medium shadow-sm">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <!-- Modal Edit Kategori -->
                                        <div x-show="showModalEdit"
                                            class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50 px-4">
                                            <div @click.away="showModalEdit = false; clearEditError()"
                                                class="bg-white dark:bg-gray-800 p-6 rounded-lg w-full max-w-md shadow-lg relative overflow-auto max-h-[90vh]">
                                                <h2
                                                    class="text-xl font-bold text-gray-800 dark:text-white mb-4 text-left">
                                                    Edit kategori</h2>

                                                <form action="{{ route('update-kategori', $kategori->id) }}"
                                                    method="POST" class="space-y-4">
                                                    @csrf
                                                    @method('POST')

                                                    <input type="hidden" name="form_context"
                                                        value="update_kategori_{{ $kategori->id }}">
                                                    <input type="hidden" name="search"
                                                        value="{{ request('search') }}">
                                                    <input type="hidden" name="filter_jenis"
                                                        value="{{ request('filter_jenis') }}">

                                                    <div>
                                                        <label for="edit_name_{{ $kategori->id }}"
                                                            class="block py-2 text-sm font-medium text-gray-700 dark:text-gray-200 text-left">Nama
                                                            kategori</label>
                                                        <input type="text" name="name" x-ref="dataName"
                                                            id="edit_name_{{ $kategori->id }}"
                                                            value="{{ old('form_context') === 'update_kategori_' . $kategori->id && $errors->any() ? old('name') : $kategori->name }}"
                                                            required
                                                            :class="(showErrorEdit &&
                                                                '{{ old('form_context') === 'update_kategori_' . $kategori->id && $errors->has('name') }}'
                                                            ) ?
                                                            'border-red-500 focus:border-red-500 focus:ring-red-500' :
                                                            'border-gray-600 focus:border-blue-500 focus:ring-blue-500'"
                                                            class="w-full px-3 py-2 border rounded-md bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring">

                                                        <div x-show="showErrorEdit && '{{ old('form_context') === 'update_kategori_' . $kategori->id && $errors->has('name') }}'"
                                                            class="mt-2">
                                                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <label for="edit_jenis_{{ $kategori->id }}"
                                                            class="block py-2 text-sm font-medium text-gray-700 dark:text-gray-200 text-left">Jenis</label>
                                                        <select name="jenis" id="edit_jenis_{{ $kategori->id }}"
                                                            x-ref="dataJenis" required
                                                            :class="(showErrorEdit &&
                                                                '{{ old('form_context') === 'update_kategori_' . $kategori->id && $errors->has('jenis') }}'
                                                            ) ?
                                                            'border-red-500 focus:border-red-500 focus:ring-red-500' :
                                                            'border-gray-600 focus:border-blue-500 focus:ring-blue-500'"
                                                            class="w-full px-3 py-2 border rounded-md bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring">
                                                            <option value="pemasukan"
                                                                {{ (old('form_context') === 'update_kategori_' . $kategori->id ? old('jenis') : $kategori->jenis) === 'pemasukan' ? 'selected' : '' }}>
                                                                Pemasukan</option>
                                                            <option value="pengeluaran"
                                                                {{ (old('form_context') === 'update_kategori_' . $kategori->id ? old('jenis') : $kategori->jenis) === 'pengeluaran' ? 'selected' : '' }}>
                                                                Pengeluaran</option>
                                                        </select>
                                                        <div x-show="showErrorEdit && '{{ old('form_context') === 'update_kategori_' . $kategori->id && $errors->has('jenis') }}'"
                                                            class="mt-2">
                                                            <x-input-error :messages="$errors->get('jenis')" class="mt-2" />
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
                                                            <i class="fas fa-save"></i> Simpan
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <form action="{{ route('hapus-kategori', $kategori->id) }}" method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-xs font-medium shadow-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-5 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada data kategori.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
