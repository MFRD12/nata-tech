<x-app-layout>
    @section('title', 'Riwayat Absensi')
    <div class="px-4 sm:px-6 lg:px-8 py-6">

        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 space-y-6">

            {{-- Header dan Identitas --}}
            <div class="flex justify-between items-center flex-wrap gap-4">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-2">Riwayat Absensi</h2>
                    <div class="text-sm text-gray-600 dark:text-gray-300 space-y-1">
                        <div>Nama: <strong>{{ $pegawai->nama }}</strong></div>
                        <div>NIP: <strong>{{ $pegawai->nip_pegawai }}</strong></div>
                    </div>
                </div>

                {{-- Form Filter --}}
                <form method="GET" class="flex flex-row flex-wrap items-end gap-2 sm:gap-4">
                    <div class="flex flex-col">
                        <label for="bulan"
                            class="text-sm text-gray-600 dark:text-gray-300 font-medium mb-1">Bulan</label>
                        <select name="bulan" id="bulan"
                            class="rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @foreach (range(1, 12) as $b)
                                <option value="{{ str_pad($b, 2, '0', STR_PAD_LEFT) }}"
                                    {{ $bulan == str_pad($b, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::createFromDate(null, $b, 1)->locale('id')->translatedFormat('F') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col">
                        <label for="tahun"
                            class="text-sm text-gray-600 dark:text-gray-300 font-medium mb-1">Tahun</label>
                        <select name="tahun" id="tahun"
                            class="w-20 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @foreach ($tahunList as $tahunItem)
                                <option value="{{ $tahunItem }}" {{ $tahun == $tahunItem ? 'selected' : '' }}>
                                    {{ $tahunItem }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition font-semibold">
                            Filter
                        </button>

                        @if (request()->has('bulan') || request()->has('tahun'))
                            <a href="{{ route('view-riwayat-absen') }}"
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md transition font-semibold">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Tabel Riwayat --}}
            <div
                class="overflow-auto no-scrollbar rounded-lg border border-gray-300 dark:border-gray-700  max-h-[60vh] md:max-h-[80vh]">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600 text-sm text-center">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100 sticky top-0 z-10">
                        <tr>
                            <th class="px-4 py-2">Hari</th>
                            <th class="px-4 py-2">Tanggal</th>
                            <th class="px-4 py-2">Absen Masuk</th>
                            <th class="px-4 py-2">Absen Pulang</th>
                            <th class="px-4 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody
                        class="bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($riwayat as $absen)
                            <tr>
                                <td class="px-4 py-2">
                                    {{ \Carbon\Carbon::parse($absen->tanggal)->locale('id')->translatedFormat('l') }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ \Carbon\Carbon::parse($absen->tanggal)->locale('id')->translatedFormat('d F Y') }}
                                </td>
                                <td class="px-4 py-2">
                                    @if ($absen->jam_masuk)
                                        <span
                                            class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">
                                            {{ $absen->jam_masuk }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    @if ($absen->jam_pulang)
                                        <span
                                            class="inline-block bg-red-100 text-red-800 text-xs font-semibold px-2 py-1 rounded">
                                            {{ $absen->jam_pulang }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 capitalize whitespace-nowrap">
                                    @php
                                        $color = match ($absen->status) {
                                            'hadir' => 'green',
                                            'izin' => 'blue',
                                            'sakit' => 'blue',
                                            'alpha' => 'red',
                                            'terlambat masuk' => 'orange',
                                            'pulang awal' => 'purple',
                                            default => 'gray',
                                        };
                                    @endphp
                                    <span
                                        class="inline-block bg-{{ $color }}-600  text-gray-200 bg- text-xs font-semibold px-2 py-1 rounded">
                                        {{ ucfirst($absen->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-4 text-gray-500 dark:text-gray-400">Tidak ada data absensi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app-layout>
