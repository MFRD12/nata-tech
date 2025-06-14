<x-app-layout>
    @section('title', 'Data Pegawai')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">

            <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200 tracking-tight">Rekap Absensi</h1>

            @if (session('success'))
                <x-alert type="success" :message="session('success')" :duration="3000" />
            @endif

            @if (session('error_user'))
                <x-modal-error :show="true" :message="session('error_user')" title="Terjadi Kesalahan Sistem"
                    closeRoute="view-rekap-absensi" />
            @endif

            @if (session('error'))
                <x-modal-error :show="true" :message="session('error')" title="Akses Ditolak"
                    closeRoute="view-rekap-absensi" />
            @endif

            <form method="GET" action="{{ route('view-rekap-absensi') }}" class="mb-6 space-y-4 md:space-y-0">
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

                            <!-- Reset -->
                            @if (request('search'))
                                <a href="{{ route('view-rekap-absensi', ['perPage' => request('perPage', 10)]) }}"
                                    class="inline-flex items-center justify-center bg-red-500 text-gray-200 hover:bg-red-600 px-4 py-2 rounded text-sm shadow-sm">
                                    Reset
                                </a>
                            @endif
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
                                <td
                                    class="px-4 py-5 text-center sticky right-0 bg-white dark:bg-gray-900 z-5 flex justify-center gap-2 whitespace-nowrap">
                                    <a href="{{ route('view-rekap-detail', $data->id) }}"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-xs font-medium shadow-sm flex items-center gap-1"
                                        title="Detail Absen">
                                        <i class="fas fa-calendar-check"></i> Detail
                                    </a>
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
        </div>
    </div>
</x-app-layout>
