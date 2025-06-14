<x-app-layout>
    @section('title', 'Kelola Divisi')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">

            <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200 tracking-tight">Kelola Divisi</h1>

            @if (session('success'))
                <x-alert type="success" :message="session('success')" :duration="3000" />
            @endif

            <div x-data="{
                showModal: false,
                showError: @if ($errors->any() && old('form_context') === 'add_divisi') true @else false @endif,
                clearInput() {
                    document.getElementById('add_name').value = '';
                    this.showError = false;
                }
            }" x-init="@if ($errors->any() && old('form_context') === 'add_divisi') showModal = true; @endif">
                <div class="flex justify-end mb-4">
                    <button @click="showModal = true"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm shadow w-full sm:w-auto">
                        <i class="fas fa-plus"></i> Tambah
                    </button>
                </div>
                <!-- Modal Tambah Divisi -->
                <div x-show="showModal"
                    class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50 px-4">
                    <div @click.away="showModal = false; clearInput()"
                        class="bg-white dark:bg-gray-800 p-6 rounded-lg w-full max-w-md shadow-lg relative overflow-auto max-h-[90vh]">
                        <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Tambah Divisi</h2>

                        <form action="{{ route('tambah-divisi') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="form_context" value="add_divisi">
                            <div>
                                <label for="add_name"
                                    class="block py-2 text-sm font-medium text-gray-700 dark:text-gray-200">Nama
                                    Divisi</label>
                                <input type="text" name="name" id="add_name"
                                    value="{{ old('form_context') === 'add_divisi' ? old('name') : '' }}" required
                                    :class="(showError &&
                                    '{{ old('form_context') === 'add_divisi' && $errors->has('name') }}') ?
                                    'border-red-500 focus:border-red-500 focus:ring-red-500' :
                                    'border-gray-600 focus:border-blue-500 focus:ring-blue-500'"
                                    class="w-full px-3 py-2 border rounded-md bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring">

                                <div x-show="showError && '{{ old('form_context') === 'add_divisi' && $errors->has('name') }}'"
                                    class="mt-2">
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
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

            <div
                class="overflow-auto no-scrollbar rounded-lg shadow ring-1 ring-black ring-opacity-5 border border-gray-200 dark:border-gray-700 max-h-[60vh]">
                <table class="min-w-full text-sm divide-y divide-gray-200 dark:divide-gray-700 text-center">
                    <thead class="bg-gray-100 dark:bg-gray-700 sticky top-0 z-10">
                        <tr class="text-gray-700 dark:text-gray-300 divide-x divide-gray-200 dark:divide-gray-700">
                            <th class="px-2 py-3 font-semibold">No</th>
                            <th class="px-4 py-3 font-semibold">Nama Divisi</th>
                            <th class="px-2 py-3 font-semibold">Jumlah</th>
                            <th class="px-4 py-3 font-semibold text-center">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($divisi as $data)
                            <tr
                                class="hover:bg-gray-100 dark:hover:bg-gray-800 divide-x divide-gray-200 dark:divide-gray-700">
                                <td class="px-2 py-3 text-center text-gray-800 dark:text-gray-200">
                                    {{ $loop->iteration }}
                                </td>
                                <td
                                    class="px-4 py-3 text-gray-800 dark:text-gray-200 whitespace-nowrap sm:whitespace-normal">
                                    {{ $data->name }}
                                </td>
                                <td class="px-2 py-3 text-gray-800 dark:text-gray-200">
                                    {{ $data->pegawai_count }}
                                </td>
                                <td
                                    class="flex gap-2 justify-center items-center px-2 py-2 text-center bg-white dark:bg-gray-900">
                                    <div x-data="{
                                        showModalEdit: false,
                                        showErrorEdit: @if ($errors->any() && old('form_context') === 'update_divisi_' . $data->id) true @else false @endif,
                                        clearEditError() {
                                            this.showErrorEdit = false;
                                        },
                                        openEditModal() {
                                            this.$refs.dataName.value = '{{ $data->name }}';
                                            this.showModalEdit = true;
                                        }
                                    }" x-init="@if ($errors->any() && old('form_context') === 'update_divisi_' . $data->id) showModalEdit = true; @endif">
                                        <button @click="openEditModal()"
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded text-xs font-medium shadow-sm">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <!-- Modal Edit divisi -->
                                        <div x-show="showModalEdit"
                                            class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50 px-4">
                                            <div @click.away="showModalEdit = false; clearEditError()"
                                                class="bg-white dark:bg-gray-800 p-6 rounded-lg w-full max-w-md shadow-lg relative overflow-auto max-h-[90vh]">
                                                <h2
                                                    class="text-xl font-bold text-gray-800 dark:text-white mb-4 text-left">
                                                    Edit Divisi</h2>

                                                <form action="{{ route('update-divisi', $data->id) }}"
                                                    method="POST" class="space-y-4">
                                                    @csrf
                                                    @method('POST')

                                                    <input type="hidden" name="form_context"
                                                        value="update_divisi_{{ $data->id }}">

                                                    <div>
                                                        <label for="edit_name_{{ $data->id }}"
                                                            class="block py-2 text-sm font-medium text-gray-700 dark:text-gray-200 text-left">Nama
                                                            Divisi</label>
                                                        <input type="text" name="name" x-ref="dataName"
                                                            id="edit_name_{{ $data->id }}"
                                                            value="{{ old('form_context') === 'update_divisi_' . $data->id && $errors->any() ? old('name') : $data->name }}"
                                                            required
                                                            :class="(showErrorEdit &&
                                                                '{{ old('form_context') === 'update_divisi_' . $data->id && $errors->has('name') }}'
                                                                ) ?
                                                            'border-red-500 focus:border-red-500 focus:ring-red-500' :
                                                            'border-gray-600 focus:border-blue-500 focus:ring-blue-500'"
                                                            class="w-full px-3 py-2 border rounded-md bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring">

                                                        {{-- Kondisi x-show disesuaikan --}}
                                                        <div x-show="showErrorEdit && '{{ old('form_context') === 'update_divisi_' . $data->id && $errors->has('name') }}'"
                                                            class="mt-2">
                                                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                                        </div>
                                                    </div>

                                                    <div class="flex justify-end gap-3 mt-4">
                                                        <button type="button"
                                                            @click="showModalEdit = false; clearEditError()"
                                                            class="px-4 py-2 bg-gray-300 dark:bg-gray-600 dark:text-white rounded hover:bg-gray-400 dark:hover:bg-gray-700 transition">
                                                            Batal
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

                                    <div>
                                        <form action="{{ route('hapus-divisi', $data->id) }}" method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('Yakin ingin menghapus divisi ini?')">
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
                                <td colspan="4" class="px-4 py-12 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada data divisi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
