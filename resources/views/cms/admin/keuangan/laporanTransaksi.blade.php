<x-app-layout>
    @section('title', 'Laporan Transaksi')

    @if (session('error'))
        <x-modal-error :show="true" :message="session('error')" title="Akses Ditolak" closeRoute="view-laporan" />
    @endif

    <div class="px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 tracking-tight">
                    Laporan Transaksi
                </h1>

                <div class="flex flex-wrap gap-2">
                    <form method="GET" action="{{ route('export-excel') }}">
                        @foreach (request()->all() as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        <button type="submit"
                            class="bg-green-600 text-white px-4 py-2 rounded text-sm shadow-sm hover:bg-green-700 transition flex items-center gap-2"
                            title="Export Excel">
                            <i class="fas fa-file-excel"></i> Excel
                        </button>
                    </form>

                    <form method="GET" action="{{ route('export-pdf') }}">
                        @foreach (request()->all() as $key => $val)
                            <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                        @endforeach
                        <button type="submit"
                            class="bg-red-600 text-white px-4 py-2 rounded text-sm shadow-sm hover:bg-red-700 transition flex items-center gap-2"
                            title="Export PDF">
                            <i class="fas fa-file-pdf"></i> PDF
                        </button>
                    </form>
                </div>
            </div>

            <x-filter-form :action="route('view-laporan')" :jenisList="$jenisList" :kategoriOptions="$kategoriOptions" :tahunList="$tahunList" :showPerPage="false">
                <div class="grid grid-cols-2 gap-2 items-center">
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center bg-blue-500 text-gray-200 hover:bg-blue-600 px-4 py-2 rounded text-sm shadow-sm transition">
                        Filter
                    </button>
                    @if (collect(request())->filter(fn($v) => !empty($v))->isNotEmpty())
                        <a href="{{ route('view-laporan') }}"
                            class="inline-flex items-center justify-center bg-red-500 text-gray-200 hover:bg-red-600 px-4 py-2 rounded text-sm shadow-sm transition">
                            Reset
                        </a>
                    @endif
                </div>
            </x-filter-form>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div class="bg-green-100 dark:bg-green-900 p-4 rounded shadow text-center">
                    <p class="text-green-700 dark:text-green-400 text-sm">Total Pemasukan</p>
                    <p class="text-lg font-bold text-green-700 dark:text-green-400">
                        Rp{{ number_format($totalPemasukan, 0, ',', '.') }}</p>
                </div>
                <div class="bg-red-100 dark:bg-red-900 p-4 rounded shadow text-center">
                    <p class="text-red-700 dark:text-red-400 text-sm">Total Pengeluaran</p>
                    <p class="text-lg font-bold text-red-600 dark:text-red-400">
                        Rp{{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
                </div>
                <div class="bg-blue-100 dark:bg-blue-900 p-4 rounded shadow text-center">
                    <p class="text-blue-700 dark:text-blue-400 text-sm">Saldo Akhir</p>
                    <p class="text-lg font-bold text-blue-700 dark:text-blue-400">
                        Rp{{ number_format($saldoAkhir, 0, ',', '.') }}</p>
                </div>
            </div>
            {{-- Hasil Laporan --}}
            @if ($sudahFilter)
                <div
                    class="overflow-auto no-scrollbar rounded-lg shadow ring-1 ring-black ring-opacity-5 border border-gray-200 dark:border-gray-700 max-h-[60vh] md:max-h-[70vh]">
                    <table class="min-w-full text-sm divide-y divide-gray-200 dark:divide-gray-700 text-center">
                        <thead class="bg-gray-50 dark:bg-gray-700 sticky top-0 z-10">
                            <tr class="text-gray-700 dark:text-gray-300 divide-x divide-gray-200 dark:divide-gray-700">
                                <th class="px-2 py-3 font-semibold">No</th>
                                <th class="px-4 py-3 font-semibold">Tanggal</th>
                                <th class="px-4 py-3 font-semibold">Nama Transaksi</th>
                                <th class="px-4 py-3 font-semibold">Kategori</th>
                                <th class="px-4 py-3 font-semibold">Pemasukan</th>
                                <th class="px-2 py-3 font-semibold">Pengeluaran</th>
                            </tr>
                        </thead>
                        <tbody
                            class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700 overflow-y-auto">
                            @forelse ($transaksis as $transaksi)
                                <tr
                                    class="hover:bg-gray-100 dark:hover:bg-gray-800 divide-x divide-gray-200 dark:divide-gray-700">
                                    <td class="px-2 py-3 text-gray-800 dark:text-gray-200">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-4 py-3 text-gray-800 dark:text-gray-200 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d M Y') }}</td>
                                    <td class="px-4 py-3 text-gray-800 dark:text-gray-200">
                                        {{ $transaksi->nama_transaksi }}</td>
                                    <td class="px-4 py-3 text-gray-800 dark:text-gray-200">
                                        {{ $transaksi->kategori->name ?? '-' }}</td>
                                    <td class="px-4 py-3 text-green-600 dark:text-green-500">
                                        {{ $transaksi->kategori->jenis === 'pemasukan' ? 'Rp' . number_format($transaksi->jumlah, 0, ',', '.') : '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-red-600 dark:text-red-500">
                                        {{ $transaksi->kategori->jenis === 'pengeluaran' ? 'Rp' . number_format($transaksi->jumlah, 0, ',', '.') : '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-gray-500">Tidak ada data untuk
                                        ditampilkan.</td>
                                </tr>
                            @endforelse
                            <tr
                                class="bg-gray-100 dark:bg-gray-800 font-semibold divide-x divide-gray-300 dark:divide-gray-700">
                                <td colspan="4" class="px-4 py-3 text-gray-700 dark:text-gray-300">Total
                                    Pemasukan</td>
                                <td class="px-4 py-3 text-green-600 dark:text-green-400">
                                    Rp{{ number_format($totalPemasukan, 0, ',', '.') }}</td>
                                <td></td>
                            </tr>
                            <tr
                                class="bg-gray-100 dark:bg-gray-800 font-semibold divide-x divide-gray-300 dark:divide-gray-700">
                                <td colspan="4" class="px-4 py-3 text-gray-700 dark:text-gray-300">Total
                                    Pengeluaran</td>
                                <td></td>
                                <td class="px-4 py-3 text-red-600 dark:text-red-400">
                                    Rp{{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
                            </tr>
                            <tr
                                class="bg-blue-50 dark:bg-gray-700 font-bold divide-x divide-gray-300 dark:divide-gray-700">
                                <td colspan="4" class="px-4 py-3 text-blue-800 dark:text-blue-300">Saldo
                                    Akhir</td>
                                <td colspan="2" class="px-4 py-3 text-blue-800 dark:text-blue-300">
                                    Rp{{ number_format($saldoAkhir, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center text-gray-500 mt-8">Silakan gunakan filter untuk menampilkan laporan transaksi.
                </p>
            @endif
        </div>
    </div>
</x-app-layout>
