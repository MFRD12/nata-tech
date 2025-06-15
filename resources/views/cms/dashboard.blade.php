<x-app-layout>
    @section('title', 'Dashboard')

    @if (session('error'))
        <x-modal-error :message="session('error')" title="Akses Ditolak" type="error" closeRoute="view-kategori" />
    @endif
    
    @php
        $activeRole = session('active_role');
    @endphp
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Dashboard
        </h2>

        @if (in_array($activeRole, ['super admin', 'hrd']))
            {{-- Kepegawaian --}}
            <!-- Cards -->
            <div class="grid gap-6 mb-8 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Card -->
                <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div
                        class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Total Pegawai
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            {{ $totalPegawai }}
                        </p>
                    </div>
                </div>
                <!-- Card -->
                <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div
                        class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path
                                d="M5.25 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM2.25 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM18.75 7.5a.75.75 0 0 0-1.5 0v2.25H15a.75.75 0 0 0 0 1.5h2.25v2.25a.75.75 0 0 0 1.5 0v-2.25H21a.75.75 0 0 0 0-1.5h-2.25V7.5Z" />
                        </svg>

                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Total Pegawai Aktif
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            {{ $pegawaiAktif ?: '-' }}
                        </p>
                    </div>
                </div>
                <!-- Card -->
                <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div class="p-3 mr-4 rounded-full bg-red-100 text-red-700 dark:bg-red-700 dark:text-red-100">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path
                                d="M10.375 2.25a4.125 4.125 0 1 0 0 8.25 4.125 4.125 0 0 0 0-8.25ZM10.375 12a7.125 7.125 0 0 0-7.124 7.247.75.75 0 0 0 .363.63 13.067 13.067 0 0 0 6.761 1.873c2.472 0 4.786-.684 6.76-1.873a.75.75 0 0 0 .364-.63l.001-.12v-.002A7.125 7.125 0 0 0 10.375 12ZM16 9.75a.75.75 0 0 0 0 1.5h6a.75.75 0 0 0 0-1.5h-6Z" />
                        </svg>

                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Total Pegawai Tidak Aktif
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            {{ $pegawaiTidakAktif ?: '-' }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if (in_array($activeRole, ['super admin', 'keuangan']))
            {{-- Keuangan --}}
            <!-- Cards -->
            <div class="grid gap-6 mb-8 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Card -->
                <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div
                        class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd"
                                d="M15.22 6.268a.75.75 0 0 1 .968-.431l5.942 2.28a.75.75 0 0 1 .431.97l-2.28 5.94a.75.75 0 1 1-1.4-.537l1.63-4.251-1.086.484a11.2 11.2 0 0 0-5.45 5.173.75.75 0 0 1-1.199.19L9 12.312l-6.22 6.22a.75.75 0 0 1-1.06-1.061l6.75-6.75a.75.75 0 0 1 1.06 0l3.606 3.606a12.695 12.695 0 0 1 5.68-4.974l1.086-.483-4.251-1.632a.75.75 0 0 1-.432-.97Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Total Pemasukan Hari Ini
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            {{ $totalPemasukanHariIni > 0 ? 'Rp ' . number_format($totalPemasukanHariIni, 0, ',', '.') : '-' }}
                        </p>
                    </div>
                </div>
                <!-- Card -->
                <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div class="p-3 mr-4 rounded-full bg-red-100 text-red-700 dark:bg-red-700 dark:text-red-100">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd"
                                d="M1.72 5.47a.75.75 0 0 1 1.06 0L9 11.69l3.756-3.756a.75.75 0 0 1 .985-.066 12.698 12.698 0 0 1 4.575 6.832l.308 1.149 2.277-3.943a.75.75 0 1 1 1.299.75l-3.182 5.51a.75.75 0 0 1-1.025.275l-5.511-3.181a.75.75 0 0 1 .75-1.3l3.943 2.277-.308-1.149a11.194 11.194 0 0 0-3.528-5.617l-3.809 3.81a.75.75 0 0 1-1.06 0L1.72 6.53a.75.75 0 0 1 0-1.061Z"
                                clip-rule="evenodd" />
                        </svg>

                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Total Pengeluaran Hari Ini
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            {{ $totalPengeluaranHariIni > 0 ? 'Rp ' . number_format($totalPengeluaranHariIni, 0, ',', '.') : '-' }}
                        </p>
                    </div>
                </div>
                <!-- Card -->
                <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd"
                                d="M12 2.25a.75.75 0 0 1 .75.75v.756a49.106 49.106 0 0 1 9.152 1 .75.75 0 0 1-.152 1.485h-1.918l2.474 10.124a.75.75 0 0 1-.375.84A6.723 6.723 0 0 1 18.75 18a6.723 6.723 0 0 1-3.181-.795.75.75 0 0 1-.375-.84l2.474-10.124H12.75v13.28c1.293.076 2.534.343 3.697.776a.75.75 0 0 1-.262 1.453h-8.37a.75.75 0 0 1-.262-1.453c1.162-.433 2.404-.7 3.697-.775V6.24H6.332l2.474 10.124a.75.75 0 0 1-.375.84A6.723 6.723 0 0 1 5.25 18a6.723 6.723 0 0 1-3.181-.795.75.75 0 0 1-.375-.84L4.168 6.241H2.25a.75.75 0 0 1-.152-1.485 49.105 49.105 0 0 1 9.152-1V3a.75.75 0 0 1 .75-.75Zm4.878 13.543 1.872-7.662 1.872 7.662h-3.744Zm-9.756 0L5.25 8.131l-1.872 7.662h3.744Z"
                                clip-rule="evenodd" />
                        </svg>

                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Total Saldo Hari ini
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            {{ $saldoHariIni > 0 ? 'Rp ' . number_format($saldoHariIni, 0, ',', '.') : '-' }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Charts -->
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Grafik
        </h2>
        <div class="grid gap-6 mb-8 md:grid-cols-2">
            @if (in_array($activeRole, ['super admin', 'hrd']))
                <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                        Statistik Absensi Bulan {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
                    </h4>
                    <div class="relative h-72">
                        <canvas id="pie-absensi" style="height: 300px;"
                            data-absensi='@json($dataAbsensiPie)'></canvas>
                    </div>
                </div>

                <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                        Jumlah Pegawai per Divisi
                    </h4>
                    <div class="relative h-72">
                        <canvas id="chartDivisi" style="height: 300px;" data-labels='@json($divisiLabels)'
                            data-counts='@json($divisiCounts)'></canvas>
                    </div>
                </div>
            @endif

            @if (in_array($activeRole, ['super admin', 'keuangan']))
                {{-- grafil bar chart pemasukan dan pengeluaran --}}
                <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                        Grafik Keuangan Bulanan Tahun {{ $year_bar }}
                    </h4>
                    <!-- Dropdown Tahun -->
                    <form method="GET" action="{{ route('dashboard') }}" class="mb-4">
                        <div class="flex items-center gap-2">
                            <label for="filter_tahun_bar" class="text-sm text-gray-700 dark:text-gray-300">Pilih
                                Tahun:</label>
                            <select name="filter_tahun_bar" id="filter_tahun_bar"
                                class=" w-20 px-3 py-1 text-sm border rounded-md bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-white dark:border-gray-600"
                                onchange="this.form.submit()">
                                @foreach ($tahunTersedia as $tahun)
                                    <option value="{{ $tahun }}" {{ $year_bar == $tahun ? 'selected' : '' }}>
                                        {{ $tahun }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                    <!-- Bar Chart -->
                    <canvas id="bars" data-labels='@json($bulanLabels)'
                        data-pemasukan='@json($pemasukan)' data-pengeluaran='@json($pengeluaran)'
                        data-tahun="{{ $year_bar }}"></canvas>
                </div>

                {{-- grafik line chart saldo --}}
                <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                        Grafik Keuangan Bulanan Tahun {{ $year_line }}
                    </h4>
                    <!-- Dropdown Tahun -->
                    <form method="GET" action="{{ route('dashboard') }}" class="mb-4">
                        <div class="flex items-center gap-2">
                            <label for="filter_tahun_line" class="text-sm text-gray-700 dark:text-gray-300">Pilih
                                Tahun:</label>
                            <select name="filter_tahun_line" id="filter_tahun_line"
                                class=" w-20 px-3 py-1 text-sm border rounded-md bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-white dark:border-gray-600"
                                onchange="this.form.submit()">
                                @foreach ($tahunTersedia as $tahun)
                                    <option value="{{ $tahun }}" {{ $year_line == $tahun ? 'selected' : '' }}>
                                        {{ $tahun }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                    <!-- Line Chart -->
                    <canvas id="saldoLine" data-labels='@json($saldoBulanLabels)'
                        data-values='@json($saldoBulanValues)' data-tahun="{{ $year_line }}"></canvas>
                </div>
        </div>

        {{-- tabel --}}
        <div class="flex justify-between items-center mb-4">
            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Transaksi Terbaru</h4>
            <a href="{{ route('view-transaksi') }}" class="text-sm text-blue-600 hover:underline dark:text-blue-400">
                Lihat Semua
            </a>
        </div>
        <!-- Tabel -->
        <div class="overflow-auto no-scrollbar rounded border border-gray-700">
            <table class="min-w-full text-sm divide-y divide-gray-200 dark:divide-gray-700 text-center">
                <thead class="bg-gray-100 dark:bg-gray-700 sticky top-0 z-10">
                    <tr class="text-gray-700 dark:text-gray-300">
                        <th class="px-3 py-3 font-semibold">No</th>
                        <th class="px-4 py-3 font-semibold">Tanggal</th>
                        <th class="px-4 py-3 font-semibold">Nama Transaksi</th>
                        <th class="px-4 py-3 font-semibold">Nominal</th>
                        <th class="px-4 py-3 font-semibold">Kategori</th>
                        <th class="px-3 py-3 font-semibold">Jenis</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($transaksiTerbaru as $transaksi)
                        <tr
                            class="hover:bg-gray-100 dark:hover:bg-gray-800 divide-x divide-gray-200 dark:divide-gray-700 transition-all duration-150">
                            <td class="px-3 py-3 text-gray-800 dark:text-gray-200">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-4 py-3 text-gray-800 dark:text-gray-200 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($transaksi->tanggal)->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-4 py-3 text-gray-800 dark:text-gray-200">
                                {{ $transaksi->nama_transaksi }}
                            </td>
                            <td class="px-4 py-3 text-gray-800 dark:text-gray-200 whitespace-nowrap">
                                Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-gray-800 dark:text-gray-200">
                                {{ $transaksi->kategori->name ?? '-' }}
                            </td>
                            <td class="px-3 py-3 text-gray-800 dark:text-gray-200">
                                <span
                                    class="inline-block px-2 py-1 rounded text-xs font-semibold
                                {{ $transaksi->kategori->jenis === 'pemasukan'
                                    ? 'bg-green-100 text-green-700 dark:bg-green-700 dark:text-green-100'
                                    : 'bg-red-100 text-red-700 dark:bg-red-700 dark:text-red-100' }}">
                                    {{ ucfirst($transaksi->kategori->jenis) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-5 text-center text-gray-500 dark:text-gray-400">
                                Tidak ada data Transaksi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @endif
    </div>
</x-app-layout>
