<x-app-layout>
    @section('title', 'Detail Absensi')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="mb-6">
            <a href="{{ route('view-rekap-absensi') }}"
                class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600">
                ← Kembali
            </a>
        </div>

        @if (session('success'))
            <x-alert type="success" :message="session('success')" :duration="3000" />
        @endif

        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 space-y-8">
            {{-- Header --}}
            <div class="flex justify-between flex-wrap gap-4 items-center">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-2">Detail Absensi</h2>
                    <div class="text-sm text-gray-600 dark:text-gray-300 space-y-1">
                        <div>Nama: <strong>{{ $pegawai->nama }}</strong></div>
                        <div>NIP: <strong>{{ $pegawai->nip_pegawai }}</strong></div>
                    </div>
                </div>

                {{-- Filter --}}
                <form method="GET" class="flex flex-wrap gap-2 items-end">
                    <div>
                        <label for="bulan" class="text-sm text-gray-600 dark:text-gray-300">Bulan</label>
                        <select name="bulan" id="bulan"
                            class="mt-1 block rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white px-3 py-2">
                            <option value="">Pilih</option>
                            @foreach (range(1, 12) as $bulan)
                                <option value="{{ $bulan }}" {{ request('bulan') == $bulan ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($bulan)->locale('id')->translatedFormat('F') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="tahun" class="text-sm text-gray-600 dark:text-gray-300">Tahun</label>
                        <select name="tahun" id="tahun"
                            class="w-20 mt-1 block rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white px-3 py-2">
                            <option value="">Pilih</option>
                            @foreach ($tahunList as $tahunItem)
                                <option value="{{ $tahunItem }}"
                                    {{ request('tahun') == $tahunItem ? 'selected' : '' }}>
                                    {{ $tahunItem }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="status" class="text-sm text-gray-600 dark:text-gray-300">Status</label>
                        <select name="status" id="status" onchange="this.form.submit()"
                            class="mt-1 block rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white px-3 py-2">
                            <option value="">Semua</option>
                            @foreach (['hadir', 'izin', 'sakit', 'terlambat masuk', 'pulang awal', 'alpha'] as $s)
                                <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>
                                    {{ ucfirst($s) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-semibold">
                            Filter
                        </button>
                        @if (request('bulan') || request('tahun') || request('status'))
                            <a href="{{ route('view-rekap-detail', $pegawai->id) }}"
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md font-semibold">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Tabel --}}
            <div
                class="overflow-auto no-scrollbar rounded-lg border border-gray-300 dark:border-gray-700 max-h-[60vh] md:max-h-[80vh]">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600 text-sm text-center">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white sticky top-0 z-10">
                        <tr>
                            <th class="px-4 py-2">Hari</th>
                            <th class="px-4 py-2">Tanggal</th>
                            <th class="px-4 py-2">Masuk</th>
                            <th class="px-4 py-2">Pulang</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Keterangan</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody
                        class="bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($riwayat as $absen)
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
                                        class="bg-{{ $color }}-600 text-gray-200 px-2 py-1 rounded text-xs font-semibold">
                                        {{ $absen->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">
                                    {{ $absen->keterangan ?? '-' }}
                                </td>
                                <td
                                    class="flex gap-2 justify-center items-center px-2 py-2 text-center bg-white dark:bg-gray-800">
                                    <div x-data="{
                                        showModalEdit: false,
                                        openEditModal() {
                                            this.$refs.status.value = '{{ $absen->status }}';
                                            this.$refs.keterangan.value = '{{ $absen->keterangan }}';
                                            this.showModalEdit = true;
                                        }
                                    }" x-init="@if ($errors->any() && session('modal') == 'edit-' . $absen->id) showModalEdit = true @endif">
                                        <button @click="openEditModal()"
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded text-xs font-medium shadow-sm">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Modal Edit Absensi -->
                                        <div x-show="showModalEdit"
                                            class="fixed inset-0 flex items-center justify-center z-50 bg-black/50 px-4">
                                            <div @click.away="showModalEdit = false"
                                                class="bg-white dark:bg-gray-800 p-6 rounded-lg w-full max-w-md shadow-lg relative overflow-auto max-h-[90vh]">
                                                <h2
                                                    class="text-xl font-bold text-gray-800 dark:text-white mb-4 text-left">
                                                    Edit Absensi
                                                </h2>

                                                <form action="{{ route('update-rekap-detail', $absen->id) }}"
                                                    method="POST" class="space-y-4">
                                                    @csrf
                                                    @method('POST')

                                                    <div>
                                                        <label for="status"
                                                            class="block py-2 text-sm font-medium text-gray-700 dark:text-gray-200 text-left">
                                                            Status
                                                        </label>
                                                        <select name="status" id="status" x-ref='status'
                                                            class="w-full px-3 py-2 border-gray-600 rounded-md bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring">
                                                            <option value="hadir"
                                                                {{ old('status', $absen->status) == 'hadir' ? 'selected' : '' }}>
                                                                Hadir</option>
                                                            <option value="izin"
                                                                {{ old('status', $absen->status) == 'izin' ? 'selected' : '' }}>
                                                                Izin</option>
                                                            <option value="sakit"
                                                                {{ old('status', $absen->status) == 'sakit' ? 'selected' : '' }}>
                                                                Sakit</option>
                                                            <option value="terlambat masuk"
                                                                {{ old('status', $absen->status) == 'terlambat masuk' ? 'selected' : '' }}>
                                                                Terlambat masuk</option>
                                                            <option value="pulang awal"
                                                                {{ old('status', $absen->status) == 'pulang awal' ? 'selected' : '' }}>
                                                                Pulang awal</option>
                                                            <option value="alpha"
                                                                {{ old('status', $absen->status) == 'alpha' ? 'selected' : '' }}>
                                                                Alpha</option>
                                                        </select>
                                                    </div>

                                                    <div>
                                                        <label for="keterangan"
                                                            class="block py-2 text-sm font-medium text-gray-700 dark:text-gray-200 text-left">
                                                            Keterangan
                                                        </label>
                                                        <textarea name="keterangan" id="keterangan" rows="3" x-ref='keterangan'
                                                            class="w-full px-3 py-2 border-gray-600 rounded-md bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring">{{ old('keterangan', $absen->keterangan) }}</textarea>
                                                    </div>

                                                    <div class="flex justify-end gap-3 mt-4">
                                                        <button type="button" @click="showModalEdit = false"
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
                                <td colspan="6" class="py-4 text-gray-500 dark:text-gray-400">Tidak ada data absensi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
