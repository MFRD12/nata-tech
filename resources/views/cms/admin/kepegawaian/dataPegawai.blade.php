<x-app-layout>
    @section('title', 'Data Pegawai')
    <div class="px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">

            <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200 tracking-tight">Data Pegawai</h1>

            @if (session('success'))
                <x-alert type="success" :message="session('success')" :duration="3000" />
            @endif

            @if (session('error_user'))
                <x-modal-error :show="true" :message="session('error_user')" title="Terjadi Kesalahan Sistem"
                    closeRoute="view-pegawai" />
            @endif

            @if (session('error'))
                <x-modal-error :show="true" :message="session('error')" title="Akses Ditolak" closeRoute="view-pegawai" />
            @endif

            <form method="GET" action="{{ route('view-pegawai') }}" class="mb-6 space-y-4 md:space-y-0">
                <div class="mb-6 space-y-4 md:space-y-0">
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
                                placeholder="Cari Nama atau NIP"
                                class="w-full sm:w-64 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm shadow-sm">

                            <!-- Filter Status -->
                            <select name="status" onchange="this.form.submit()"
                                class="w-full sm:w-52 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm shadow-sm">
                                <option value="">-- Filter Status --</option>
                                <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif
                                </option>
                                <option value="tidak aktif" {{ request('status') === 'tidak aktif' ? 'selected' : '' }}>
                                    Tidak Aktif
                                </option>
                            </select>

                            <!-- Filter Jabatan -->
                            <select name="jabatan" onchange="this.form.submit()"
                                class="w-full sm:w-52 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm shadow-sm">
                                <option value="">-- Filter Jabatan --</option>
                                <option value="kosong" {{ request('jabatan') === 'kosong' ? 'selected' : '' }}>Jabatan
                                    Kosong</option>
                                @foreach ($jabatans as $jabatan)
                                    <option value="{{ $jabatan->id }}"
                                        {{ request('jabatan') == $jabatan->id ? 'selected' : '' }}>
                                        {{ $jabatan->name }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- Filter Divisi -->
                            <select name="divisi" onchange="this.form.submit()"
                                class="w-full sm:w-52 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm shadow-sm">
                                <option value="">-- Filter Divisi --</option>
                                <option value="kosong" {{ request('divisi') === 'kosong' ? 'selected' : '' }}>Divisi
                                    Kosong</option>
                                @foreach ($divisi as $data)
                                    <option value="{{ $data->id }}"
                                        {{ request('divisi') == $data->id ? 'selected' : '' }}>
                                        {{ $data->name }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- Reset -->
                            @if (request('search') || request('status') || request('jabatan') || request('divisi'))
                                <a href="{{ route('view-pegawai', ['perPage' => request('perPage', 10)]) }}"
                                    class="inline-flex items-center justify-center bg-red-500 text-gray-200 hover:bg-red-600 px-4 py-2 rounded text-sm shadow-sm">
                                    Reset
                                </a>
                            @endif
                            <!-- Tambah button-->
                            <a href="{{ route('tambah-view-pegawai') }}"
                                class="whitespace-nowrap inline-flex items-center justify-center bg-blue-600 text-gray-200 hover:bg-blue-700 px-4 py-2 rounded text-sm shadow-sm">
                                <i class="fas fa-plus"></i> Tambah
                            </a>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Tabel Data Pegawai -->
            <div
                class="overflow-x-auto no-scrollbar rounded-lg shadow ring-1 ring-black ring-opacity-5 border border-gray-200 dark:border-gray-700">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr
                            class="text-gray-700 dark:text-gray-300 divide-x divide-gray-200 dark:divide-gray-700 text-center">
                            <th class="px-4 py-3 font-semibold">No</th>
                            <th class="px-4 py-3 font-semibold">Foto</th>
                            <th class="px-4 py-3 font-semibold">NIP</th>
                            <th class="px-4 py-3 font-semibold">Nama</th>
                            <th class="px-4 py-3 font-semibold">Tanggal Masuk</th>
                            <th class="px-4 py-3 font-semibold">Status</th>
                            <th class="px-4 py-3 font-semibold sticky right-0 bg-gray-50 dark:bg-gray-700 z-5">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($pegawais as $data)
                            <tr x-data="{ open: false }"
                                class="hover:bg-gray-100 dark:hover:bg-gray-800 divide-x divide-gray-200 dark:divide-gray-700 text-center">
                                <td class="px-4 py-3 text-center text-gray-800 dark:text-gray-200">
                                    {{ ($pegawais->currentPage() - 1) * $pegawais->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-4 py-3">
                                    @if ($data->foto)
                                        <div class="flex justify-center">
                                            <img src="{{ asset('storage/' . $data->foto) }}" alt="Foto"
                                                class="sm:w-8 sm:h-8 rounded-full object-cover md:w-10 md:h-10">
                                        </div>
                                    @else
                                        <div class="flex justify-center">
                                            <img src="{{ asset('images/profile.jpg') }}" alt="Foto"
                                                class="sm:w-8 sm:h-8 rounded-full object-cover md:w-10 md:h-10">
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-gray-800 dark:text-gray-200">{{ $data->nip_pegawai }}</td>
                                <td
                                    class="px-4 py-3 text-gray-800 dark:text-gray-200 text-left whitespace-nowrap sm:whitespace-normal">
                                    {{ $data->nama }}</td>
                                <td class="px-4 py-3 text-gray-800 dark:text-gray-200">
                                    {{ \Carbon\Carbon::parse($data->tgl_masuk)->format('d M Y') }}
                                </td>
                                <td class="px-4 py-3 text-gray-800 dark:text-gray-200">
                                    <span
                                        class="inline-block px-2 py-1 rounded text-xs font-semibold 
                                    {{ $data->status == 'aktif' ? 'bg-green-100 text-green-700 dark:bg-green-700 dark:text-green-100' : 'bg-red-100 text-red-700 dark:bg-red-700 dark:text-red-100' }}">
                                        {{ ucfirst($data->status) }}
                                    </span>
                                </td>
                                <td
                                    class="px-4 py-5 text-center sticky right-0 bg-white dark:bg-gray-900 z-5 flex justify-center gap-2">
                                    <button onclick="toggleDetail({{ $data->id }})"
                                        class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded shadow-sm"
                                        title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="{{ route('edit-view-pegawai', $data->id) }}"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white p-2 rounded shadow-sm"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>

                            <!-- Row untuk dropdown detail -->
                            <tr id="detail-{{ $data->id }}" style="display: none;">
                                <td colspan="7"
                                    class="bg-gray-50 dark:bg-gray-800 px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div><strong>Tempat Lahir:</strong> {{ $data->tempat_lahir ?? '-' }}</div>
                                        <div><strong>Tanggal Lahir:</strong>
                                            {{ $data->tgl_lahir ? \Carbon\Carbon::parse($data->tgl_lahir)->format('d M Y') : '-' }}
                                        </div>
                                        <div><strong>Jenis Kelamin:</strong>
                                            {{ $data->gender ? ucfirst($data->gender) : '-' }}</div>
                                        <div><strong>No HP:</strong> {{ $data->no_hp ?? '-' }}</div>
                                        <div><strong>Alamat:</strong> {{ $data->alamat ?? '-' }}</div>
                                        <div><strong>Jabatan:</strong> {{ $data->jabatan->name ?? '-' }}</div>
                                        <div><strong>Divisi:</strong> {{ $data->divisi->name ?? '-' }}</div>
                                        <div><strong>Status:</strong>
                                            {{ $data->status ? ucfirst($data->status) : '-' }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-5 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada data Pegawai.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <x-pagination-links :paginator="$pegawais" />


            <!-- Script toggle dropdown -->
            <script>
                function toggleDetail(id) {
                    const detailRow = document.getElementById('detail-' + id);
                    if (detailRow.style.display === 'none') {
                        detailRow.style.display = '';
                    } else {
                        detailRow.style.display = 'none';
                    }
                }
            </script>
        </div>
    </div>
</x-app-layout>
