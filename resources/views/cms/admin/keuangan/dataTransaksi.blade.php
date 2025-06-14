<x-app-layout>
    @section('title', 'Data Transaksi')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200 tracking-tight">Data Transaksi</h1>

            @if (session('success'))
                <x-alert type="success" :message="session('success')" :duration="3000"/>
            @endif

            @if (session('error'))
                <x-modal-error :show="true" :message="session('error')" title="Akses Ditolak" closeRoute="view-transaksi" />
            @endif

            <div x-data="{
                showModal: false,
                showError: @if ($errors->any() && old('form_context') === 'add_transaksi') true @else false @endif,
                clearInput() {
                    document.getElementById('add_tanggal').value = '';
                    document.getElementById('add_name').value = '';
                    document.getElementById('kategori_id').value = '';
                    document.getElementById('jenis').value = '';
                    document.getElementById('add_jumlah').value = '';
                    document.getElementById('add_keterangan').value = '';
                    this.showError = false;
                }
            }" x-init="() => {
                @if($errors->any() && old('form_context') === 'add_transaksi')
                showModal = true;
                @endif
            }">

                <x-filter-form :action="route('view-transaksi')" :jenisList="$jenisList" :kategoriOptions="$kategoriOptions" :tahunList="$tahunList">
                    <div class="grid grid-cols-2 gap-2 items-center">
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center bg-blue-500 text-gray-200 hover:bg-blue-600 px-4 py-2 rounded text-sm shadow-sm transition">
                            Filter
                        </button>
                        @if (collect(request()->except('perPage'))->filter(fn($v) => !empty($v))->isNotEmpty())
                            <a href="{{ route('view-transaksi') . '?perPage=' . request('perPage', 10) }}"
                                class="inline-flex items-center justify-center bg-red-500 text-gray-200 hover:bg-red-600 px-4 py-2 rounded text-sm shadow-sm transition">
                                Reset
                            </a>
                        @endif
                    </div>
                    <div>
                        <button type="button" @click="showModal = true"
                            class="hidden md:block w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm shadow items-center justify-center">
                            <i class="fas fa-plus"></i> Tambah
                        </button>
                    </div>
                </x-filter-form>

                <div>
                    <button type="button" @click="showModal = true"
                        class="md:hidden block w-full my-4 bg-blue-600 text-white px-4 py-2.5 rounded-lg hover:bg-blue-700 text-sm shadow items-center justify-center">
                        <i class="fas fa-plus"></i> Tambah
                    </button>
                </div>

                <!-- Modal Tambah transaksi -->
                <div x-show="showModal"
                    class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50 px-4" x-cloak>
                    <div @click.away="showModal = false; clearInput()"
                        class="bg-white dark:bg-gray-800 p-6 rounded-lg w-full max-w-xl shadow-lg relative overflow-auto max-h-[90vh]">
                        <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Tambah Transaksi</h2>

                        <form action="{{ route('tambah-transaksi') }}" method="POST" enctype="multipart/form-data"
                            class="space-y-4">
                            @csrf
                            <input type="hidden" name="form_context" value="add_transaksi">

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="add_name"
                                        class="block py-2 text-sm font-medium text-gray-700 dark:text-gray-200">Nama
                                        Transaksi</label>
                                    <input type="text" name="nama_transaksi" id="add_name"
                                        value="{{ old('form_context') === 'add_transaksi' ? old('name') : '' }}"
                                        required
                                        :class="(showError &&
                                            '{{ old('form_context') === 'add_transaksi' && $errors->has('nama_transaksi') }}'
                                        ) ?
                                        'border-red-500 focus:border-red-500 focus:ring-red-500' :
                                        'border-gray-600 focus:border-blue-500 focus:ring-blue-500'"
                                        class="w-full px-3 py-2 border rounded-md bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring">

                                    <div x-show="showError && '{{ old('form_context') === 'add_transaksi' && $errors->has('nama_transaksi') }}'"
                                        class="mt-2">
                                        <x-input-error :messages="$errors->get('nama_transaksi')" class="mt-2" />
                                    </div>
                                </div>
                                <div>
                                    <label for="add_tanggal"
                                        class="block py-2 text-sm font-medium text-gray-700 dark:text-gray-200">Tanggal</label>
                                    <input type="date" name="tanggal" id="add_tanggal"
                                        value="{{ old('form_context') === 'add_transaksi' ? old('tanggal') : '' }}"
                                        required
                                        :class="(showError &&
                                            '{{ old('form_context') === 'add_transaksi' && $errors->has('tanggal') }}'
                                        ) ?
                                        'border-red-500 focus:border-red-500 focus:ring-red-500' :
                                        'border-gray-600 focus:border-blue-500 focus:ring-blue-500'"
                                        class="w-full px-3 py-2 border rounded-md bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring">

                                    <div x-show="showError && '{{ old('form_context') === 'add_transaksi' && $errors->has('tanggal') }}'"
                                        class="mt-2">
                                        <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                                    </div>
                                </div>

                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="kategori_id"
                                        class="block py-2 text-sm font-medium text-gray-700 dark:text-gray-200">Kategori</label>
                                    <select name="kategori_id" id="kategori_id" onchange="updateJenisField(this)"
                                        required
                                        class="w-full px-3 py-2 border-gray-600 rounded-md bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring">
                                        <option value="" disabled
                                            {{ (old('form_context') === 'add_transaksi' && old('kategori_id') == '') || old('form_context') !== 'add_transaksi' ? 'selected' : '' }}>
                                            -- Pilih Jenis --</option>
                                        @foreach ($kategoriAll as $kategori)
                                            <option value="{{ $kategori->id }}">{{ ucfirst($kategori->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="jenis"
                                        class="block py-2 text-sm font-medium text-gray-700 dark:text-gray-200">Jenis</label>
                                    <input type="text" id="jenis" name="jenis" readonly
                                        class="w-full px-3 py-2 border-gray-600 rounded-md bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 cursor-not-allowed"
                                        value="" />
                                </div>
                            </div>

                            <div>
                                <label for="add_jumlah"
                                    class="block py-2 text-sm font-medium text-gray-700 dark:text-gray-200">
                                    Nominal Transaksi
                                </label>
                                <div class="relative">
                                    <span
                                        class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 select-none pointer-events-none">
                                        Rp
                                    </span>
                                    <input type="number" name="jumlah" id="add_jumlah"
                                        value="{{ old('form_context') === 'add_transaksi' ? old('jumlah') : '' }}"
                                        required
                                        :class="(showError &&
                                            '{{ old('form_context') === 'add_transaksi' && $errors->has('jumlah') }}'
                                        ) ?
                                        'border-red-500 focus:border-red-500 focus:ring-red-500 pl-10' :
                                        'border-gray-600 focus:border-blue-500 focus:ring-blue-500 pl-10'"
                                        class="w-full px-3 py-2 border rounded-md bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring pl-10">
                                </div>

                                <div x-show="showError && '{{ old('form_context') === 'add_transaksi' && $errors->has('jumlah') }}'"
                                    class="mt-2">
                                    <x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
                                </div>
                            </div>

                            <div>
                                <label for="nota"
                                    class="block py-2 text-sm font-medium text-gray-700 dark:text-gray-200">Upload
                                    Nota</label>
                                <input type="file" name="nota" id="nota" accept="image/*"
                                    capture="environment"
                                    class="w-full px-3 py-2 border-gray-600 rounded-md bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring">
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

            <!-- Tabel Data Transaksi -->
            <div
                class="overflow-auto no-scrollbar rounded-lg shadow ring-1 ring-black ring-opacity-5 border border-gray-200 dark:border-gray-700 max-h-[60vh] md:max-h-[40vh]">
                <table class="min-w-full text-sm divide-y divide-gray-200 dark:divide-gray-700 text-center">
                    <thead class="bg-gray-100 dark:bg-gray-700 sticky top-0 z-10">
                        <tr class="text-gray-700 dark:text-gray-300 divide-x divide-gray-200 dark:divide-gray-700">
                            <th class="px-2 py-3 font-semibold">No</th>
                            <th class="px-4 py-3 font-semibold">Tanggal</th>
                            <th class="px-4 py-3 font-semibold">Nama Transaksi</th>
                            <th class="px-4 py-3 font-semibold">Nominal</th>
                            <th class="px-4 py-3 font-semibold">Kategori</th>
                            <th class="px-2 py-3 font-semibold">Jenis</th>
                            <th class="px-2 py-3 font-semibold">Nota</th>
                            <th class="px-4 py-3 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody
                        class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700 overflow-y-auto">
                        @forelse ($transaksis as $transaksi)
                            <tr
                                class="hover:bg-gray-100 dark:hover:bg-gray-800 divide-x divide-gray-200 dark:divide-gray-700">
                                <td class="px-2 py-3 text-gray-800 dark:text-gray-200">
                                    {{ ($transaksis->currentPage() - 1) * $transaksis->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-2 py-3 text-gray-800 dark:text-gray-200 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($transaksi->tanggal)->translatedFormat('d M Y') }}</td>
                                <td class="px-4 py-3 text-gray-800 dark:text-gray-200">
                                    {{ $transaksi->nama_transaksi }}</td>
                                <td class="px-4 py-3 text-gray-800 dark:text-gray-200 whitespace-nowrap">Rp
                                    {{ number_format($transaksi->jumlah, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-gray-800 dark:text-gray-200">
                                    {{ $transaksi->kategori->name ?? '-' }}</td>
                                <td class="px-2 py-3 text-gray-800 dark:text-gray-200">
                                    <span
                                        class="inline-block px-2 py-1 rounded text-xs font-semibold
                                        {{ $transaksi->kategori->jenis === 'pemasukan' ? 'bg-green-100 text-green-700 dark:bg-green-700 dark:text-green-100' : 'bg-red-100 text-red-700 dark:bg-red-700 dark:text-red-100' }}">
                                        {{ ucfirst($transaksi->kategori->jenis) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    @if ($transaksi->nota)
                                        <button type="button"
                                            onclick="showNotaModal('{{ asset('storage/' . $transaksi->nota) }}')"
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded shadow-sm">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td
                                    class="px-4 py-3 bg-white dark:bg-gray-900">
                                    <div x-data="{
                                        showModalEdit: false,
                                        showErrorEdit: @if ($errors->any() && old('form_context') === 'update_transaksi_' . $transaksi->id) true @else false @endif,
                                        clearEditError() {
                                            this.showErrorEdit = false;
                                        },
                                        openEditModal() {
                                            this.$refs.dataName.value = '{{ $transaksi->nama_transaksi }}';
                                            this.$refs.dataTanggal.value = '{{ $transaksi->tanggal }}';
                                            this.$refs.dataJumlah.value = '{{ (int) $transaksi->jumlah }}';
                                            this.$refs.dataKategori.value = '{{ $transaksi->kategori_id }}';
                                            this.showModalEdit = true;
                                        }
                                    }" x-init="@if ($errors->any() && old('form_context') === 'update_transaksi_' . $kategori->id) showModalEdit = true; @endif">
                                        <button @click="openEditModal()"
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded text-xs font-medium shadow-sm">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <div x-show="showModalEdit"
                                            class="fixed inset-0 flex items-center text-left justify-center z-50 bg-black bg-opacity-50 px-4">
                                            <div @click.away="showModalEdit = false; clearEditError()"
                                                class="bg-white dark:bg-gray-800 p-6 rounded-lg w-full max-w-md shadow-lg relative overflow-auto no-scrollbar max-h-[90vh]">
                                                <h2
                                                    class="text-xl font-bold text-gray-800 dark:text-white mb-4 text-left">
                                                    Edit Transaksi</h2>

                                                <form action="{{ route('update-transaksi', $transaksi->id) }}"
                                                    method="POST" class="space-y-4" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('POST')

                                                    <input type="hidden" name="form_context"
                                                        value="update_transaksi_{{ $transaksi->id }}">
                                                    <input type="hidden" name="search"
                                                        value="{{ request('search') }}">
                                                    <input type="hidden" name="page"
                                                        value="{{ request('page') }}">
                                                    <input type="hidden" name="jenis_transaksi"
                                                        value="{{ request('jenis_transaksi') }}">
                                                    <input type="hidden" name="kategori"
                                                        value="{{ request('kategori') }}">
                                                    <input type="hidden" name="filter_waktu"
                                                        value="{{ request('filter_waktu') }}">
                                                    <input type="hidden" name="tanggal_awal"
                                                        value="{{ request('tanggal_awal') }}">
                                                    <input type="hidden" name="tanggal_akhir"
                                                        value="{{ request('tanggal_akhir') }}">
                                                    <input type="hidden" name="bulan_awal"
                                                        value="{{ request('bulan_awal') }}">
                                                    <input type="hidden" name="bulan_akhir"
                                                        value="{{ request('bulan_akhir') }}">
                                                    <input type="hidden" name="tahun"
                                                        value="{{ request('tahun') }}">
                                                    <input type="hidden" name="jumlah_min"
                                                        value="{{ request('jumlah_min') }}">
                                                    <input type="hidden" name="jumlah_max"
                                                        value="{{ request('jumlah_max') }}">
                                                    <input type="hidden" name="perPage"
                                                        value="{{ request('perPage', 10) }}">

                                                    <div class="grid grid-cols-2 gap-4">
                                                        <div>
                                                            <label for="edit_name_{{ $transaksi->id }}"
                                                                class="block py-2 text-sm font-medium text-gray-700 dark:text-gray-200">Nama
                                                                Transaksi</label>
                                                            <input type="text" name="nama_transaksi"
                                                                x-ref="dataName" id="edit_name_{{ $transaksi->id }}"
                                                                value="{{ old('form_context') === 'update_transaksi_' . $transaksi->id && $errors->any() ? old('nama_transaksi') : $transaksi->nama_transaksi }}"
                                                                required
                                                                :class="(showErrorEdit &&
                                                                    '{{ old('form_context') === 'update_transaksi_' . $transaksi->id && $errors->has('nama_transaksi') }}'
                                                                ) ?
                                                                'border-red-500 focus:border-red-500 focus:ring-red-500' :
                                                                'border-gray-600 focus:border-blue-500 focus:ring-blue-500'"
                                                                class="w-full px-3 py-2 border rounded-md bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring">

                                                            <div x-show="showErrorEdit && '{{ old('form_context') === 'update_transaksi_' . $transaksi->id && $errors->has('nama_transaksi') }}'"
                                                                class="mt-2">
                                                                <x-input-error :messages="$errors->get('nama_transaksi')" class="mt-2" />
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <label for="edit_tanggal_{{ $transaksi->id }}"
                                                                class="block py-2 text-sm font-medium text-gray-700 dark:text-gray-200">Tanggal</label>
                                                            <input type="date" name="tanggal"
                                                                id="edit_tanggal_{{ $transaksi->id }}"
                                                                x-ref="dataTanggal"
                                                                value="{{ old('form_context') === 'update_transaksi_' . $transaksi->id && $errors->any() ? old('tanggal') : $transaksi->tanggal }}"
                                                                required
                                                                :class="(showErrorEdit &&
                                                                    '{{ old('form_context') === 'update_transaksi_' . $transaksi->id && $errors->has('tanggal') }}'
                                                                ) ?
                                                                'border-red-500 focus:border-red-500 focus:ring-red-500' :
                                                                'border-gray-600 focus:border-blue-500 focus:ring-blue-500'"
                                                                class="w-full px-3 py-2 border rounded-md bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring">

                                                            <div x-show="showErrorEdit && '{{ old('form_context') === 'update_transaksi_' . $transaksi->id && $errors->has('tanggal') }}'"
                                                                class="mt-2">
                                                                <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="grid grid-cols-2 gap-4">
                                                        <div>
                                                            <label for="kategori_id"
                                                                class="block py-2 text-sm font-medium text-gray-700 dark:text-gray-200">Kategori</label>
                                                            <select name="kategori_id"
                                                                id="kategori_id_{{ $transaksi->id }}"
                                                                x-ref="dataKategori"
                                                                onchange="updateJenisField(this, {{ $transaksi->id }})"
                                                                required
                                                                class="w-full px-3 py-2 border-gray-600 rounded-md bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring">
                                                                <option value="" disabled
                                                                    {{ (old('form_context') === 'add_transaksi' && old('kategori_id') == '') || old('form_context') !== 'add_transaksi' ? 'selected' : '' }}>
                                                                    -- Pilih Jenis --</option>
                                                                @foreach ($kategoriAll as $kategori)
                                                                    <option value="{{ $kategori->id }}"
                                                                        {{ $transaksi->kategori_id == $kategori->id ? 'selected' : '' }}>
                                                                        {{ $kategori->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label for="jenis"
                                                                class="block py-2 text-sm font-medium text-gray-700 dark:text-gray-200">Jenis</label>
                                                            <input type="text" id="jenis_{{ $transaksi->id }}"
                                                                name="jenis" readonly
                                                                class="w-full px-3 py-2 border rounded-md bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 cursor-not-allowed"
                                                                value="{{ ucfirst($transaksi->kategori->jenis) }}" />
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <label for="edit_jumlah_{{ $transaksi->id }}"
                                                            class="block py-2 text-sm font-medium text-gray-700 dark:text-gray-200">
                                                            Nominal Transaksi
                                                        </label>
                                                        <div class="relative">
                                                            <span
                                                                class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 select-none pointer-events-none">
                                                                Rp
                                                            </span>
                                                            <input type="number" name="jumlah"
                                                                id="edit_jumlah_{{ $transaksi->id }}"
                                                                x-ref="dataJumlah"
                                                                value="{{ old('form_context') === 'update_transaksi_' . $transaksi->id && $errors->any() ? old('jumlah') : (int) $transaksi->jumlah }}"
                                                                required
                                                                :class="(showErrorEdit &&
                                                                    '{{ old('form_context') === 'update_transaksi_' . $transaksi->id && $errors->has('jumlah') }}'
                                                                ) ?
                                                                'border-red-500 focus:border-red-500 focus:ring-red-500' :
                                                                'border-gray-600 focus:border-blue-500 focus:ring-blue-500'"
                                                                class="w-full px-3 py-2 border rounded-md bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring pl-10">

                                                            <div x-show="showErrorEdit && '{{ old('form_context') === 'update_transaksi_' . $transaksi->id && $errors->has('jumlah') }}'"
                                                                class="mt-2">
                                                                <x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
                                                            </div>
                                                        </div>

                                                        <div class="mt-4">
                                                            <label for="edit_nota_{{ $transaksi->id }}"
                                                                class="block py-2 text-sm font-medium text-gray-700 dark:text-gray-200">Upload
                                                                Nota</label>

                                                            <input type="file" name="nota" accept="image/*"
                                                                capture="environment"
                                                                id="edit_nota_{{ $transaksi->id }}"
                                                                class="w-full px-3 py-2 border border-gray-600 rounded-md bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring">

                                                            @if ($transaksi->nota)
                                                                <div class="mt-3">
                                                                    <p
                                                                        class="text-sm text-gray-600 dark:text-gray-300 mb-1">
                                                                        Nota saat ini:</p>
                                                                    <img src="{{ asset('storage/' . $transaksi->nota) }}"
                                                                        alt="Nota"
                                                                        class="w-32 h-auto rounded border shadow-sm">
                                                                </div>
                                                            @endif
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
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-5 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada data Transaksi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div id="notaModal"
                    class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center px-4 sm:px-0 hidden">
                    <div
                        class="bg-white dark:bg-gray-800 p-4 sm:p-6 rounded shadow-lg w-full max-w-md max-h-[90vh] overflow-y-auto">
                        <div class="flex justify-between items-center mb-2">
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Preview Nota</h2>
                            <button onclick="closeNota()"
                                class="text-red-600 dark:text-red-400 text-xl font-bold focus:outline-none">&times;</button>
                        </div>
                        <img id="notaImage" src="" alt="Nota"
                            class="w-full h-auto rounded border dark:border-gray-700">
                    </div>
                </div>

            </div>
            <x-pagination-links :paginator="$transaksis" />
        </div>
    </div>

    <script>
        // Data mapping kategori ke jenis
        const kategoriJenisMap = @json($kategoriAll->pluck('jenis', 'id'));

        function updateJenisField(select, id = null) {
            const selectedId = select.value;
            const jenis = kategoriJenisMap[selectedId] || '';

            // Terapkan ucfirst
            const ucfirstJenis = jenis.charAt(0).toUpperCase() + jenis.slice(1);

            // Update input jenis dengan nilai yang sudah diubah
            const targetId = id ? 'jenis_' + id : 'jenis';
            const jenisInput = document.getElementById(targetId);

            if (jenisInput) {
                jenisInput.value = ucfirstJenis;
            }
        }

        function showNotaModal(imageUrl) {
            const modal = document.getElementById('notaModal');
            const image = document.getElementById('notaImage');
            image.src = imageUrl;
            modal.classList.remove('hidden');
        }

        function closeNota() {
            const modal = document.getElementById('notaModal');
            const image = document.getElementById('notaImage');
            image.src = '';
            modal.classList.add('hidden');
        }
    </script>
</x-app-layout>
