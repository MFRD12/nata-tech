<x-app-layout>
    @section('title', 'Data Keluarga Pegawai')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">

            <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200 tracking-tight">Data Keluarga Pegawai
            </h1>

            @if (session('success'))
                <x-alert type="success" :message="session('success')" :duration="3000" />
            @endif

            @if (session('error_user'))
                <x-modal-error :show="true" :message="session('error_user')" title="Terjadi Kesalahan Sistem"
                    closeRoute="view-keluarga" />
            @endif

             @if (session('error'))
                <x-modal-error :show="true" :message="session('error')" title="Akses Ditolak" closeRoute="view-pegawai" />
            @endif

            <!-- Tombol dan filter -->
            <form method="GET" action="" class="mb-6 space-y-4 md:space-y-0">
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
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari Nama Pegawai atau Pasangan"
                                class="w-full sm:w-64 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm shadow-sm">

                            <select name="status_pernikahan" onchange="this.form.submit()"
                                class="w-full sm:w-52 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm shadow-sm">
                                <option value="">-- Filter Status Pernikahan --</option>
                                <option value="menikah"
                                    {{ request('status_pernikahan') == 'menikah' ? 'selected' : '' }}>
                                    Menikah</option>
                                <option value="belum menikah"
                                    {{ request('status_pernikahan') == 'belum menikah' ? 'selected' : '' }}>Belum
                                    Menikah
                                </option>
                            </select>

                            @if (request('search') || request('status_pernikahan'))
                                <a href="{{ route('view-keluarga',['perPage' => request('perPage', 10)]) }}"
                                    class="inline-flex items-center justify-center bg-red-500 text-gray-200 hover:bg-red-600 px-4 py-2 rounded text-sm shadow-sm transition">
                                    Reset
                                </a>
                            @endif
                            <!-- Tambah button-->
                            <a href="{{ route('tambah-view-keluarga') }}"
                                class="whitespace-nowrap inline-flex items-center justify-center bg-blue-600 text-gray-200 hover:bg-blue-700 px-4 py-2 rounded text-sm shadow-sm">
                                + Tambah
                            </a>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Tabel -->
            <div
                class="overflow-x-auto no-scrollbar rounded-lg shadow ring-1 ring-black ring-opacity-5 border border-gray-200 dark:border-gray-700">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr
                            class="text-gray-700 dark:text-gray-300 divide-x divide-gray-200 dark:divide-gray-700 text-center">
                            <th class="px-4 py-3 font-semibold">No</th>
                            <th class="px-4 py-3 font-semibold">Nama Pegawai</th>
                            <th class="px-4 py-3 font-semibold">No Kartu Keluarga</th>
                            <th class="px-4 py-3 font-semibold">Status Pernikahan</th>
                            <th class="px-4 py-3 font-semibold">Nama Pasangan</th>
                            <th class="px-4 py-3 font-semibold">Jumlah Anak</th>
                            <th class="px-4 py-3 font-semibold sticky right-0 bg-gray-50 dark:bg-gray-700 z-5">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($keluargas as $data)
                            <tr
                                class="hover:bg-gray-100 dark:hover:bg-gray-800 divide-x divide-gray-200 dark:divide-gray-700 text-center">
                                <td class="px-4 py-3 text-gray-800 dark:text-gray-200">
                                    {{ ($keluargas->currentPage() - 1) * $keluargas->perPage() + $loop->iteration }}
                                </td>
                                <td
                                    class="px-4 py-3 text-left text-gray-800 dark:text-gray-200 whitespace-nowrap sm:whitespace-normal">
                                    {{ $data->pegawai->nama }}
                                </td>
                                <td class="px-4 py-3 text-gray-800 dark:text-gray-200">{{ $data->no_kk ?? '-' }}</td>
                                <td class="px-4 py-3 text-gray-800 dark:text-gray-200 whitespace-nowrap">
                                    <span
                                        class="inline-block px-2 py-1 rounded text-xs font-semibold 
                                    {{ $data->status_pernikahan == 'menikah' ? 'bg-green-100 text-green-700 dark:bg-green-700 dark:text-green-100' : 'bg-red-100 text-red-700 dark:bg-red-700 dark:text-red-100' }}">
                                        {{ ucfirst($data->status_pernikahan) }}
                                    </span>
                                </td>
                                <td
                                    class="px-4 py-3 text-gray-800 dark:text-gray-200 whitespace-nowrap sm:whitespace-normal">
                                    {{ $data->nama_pasangan ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-gray-800 dark:text-gray-200">{{ $data->anak->count() }}</td>
                                <td
                                    class="px-4 py-5 text-center sticky right-0 bg-white dark:bg-gray-900 z-5 flex justify-center gap-2">
                                    <a href="{{ route('detail-view-keluarga', $data->id) }}"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-xs font-medium shadow-sm">
                                        View
                                    </a>
                                    <a href="{{ route('edit-view-keluarga', $data->id) }}"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1.5 rounded text-xs font-medium shadow-sm">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-5 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada data keluarga.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <x-pagination-links :paginator="$keluargas" />
        </div>
    </div>

</x-app-layout>
