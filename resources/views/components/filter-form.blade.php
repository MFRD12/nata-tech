@props([
    // Data wajib
    'action', // URL tujuan form
    'jenisList',
    'kategoriOptions',
    'tahunList',

    // Props opsional dengan nilai default
    'showSearch' => true,
    'showJenis' => true,
    'showKategori' => true,
    'showFilterWaktu' => true,
    'showNominal' => true,
    'showPerPage' => true,
])

<form method="GET" action="{{ $action }}"
    class="grid grid-cols-2  sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-x-4 gap-y-5 mb-6 items-end">

    @if ($showSearch)
        <div>
            <label for="search" class="sr-only">Cari nama transaksi</label>
            <input type="text" name="search" id="search" placeholder="Cari nama transaksi"
                value="{{ request('search') }}"
                class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm shadow-sm">
        </div>
    @endif

    @if ($showJenis)
        <div>
            <label for="jenis_transaksi" class="sr-only">Pilih Jenis Transaksi</label>
            <select name="jenis_transaksi" id="jenis_transaksi" onchange="this.form.submit()"
                class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm shadow-sm">
                <option value="">-- Pilih Jenis --</option>
                @foreach ($jenisList as $jenis)
                    <option value="{{ $jenis }}" {{ request('jenis_transaksi') == $jenis ? 'selected' : '' }}>
                        {{ ucfirst($jenis) }}
                    </option>
                @endforeach
            </select>
        </div>
    @endif

    @if ($showKategori)
        <div>
            <label for="kategori" class="sr-only">Pilih Kategori</label>
            <select name="kategori" id="kategori" onchange="this.form.submit()"
                class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm shadow-sm">
                <option value="">-- Pilih Kategori --</option>
                @foreach ($kategoriOptions as $kategori)
                    <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->name }}
                    </option>
                @endforeach
            </select>
        </div>
    @endif

    @if ($showFilterWaktu)
        <div>
            <label for="filter_waktu" class="sr-only">Filter Waktu</label>
            <select name="filter_waktu" id="filter_waktu"
                class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm shadow-sm">
                <option value="">-- Filter Waktu --</option>
                <option value="tanggal" {{ request('filter_waktu') == 'tanggal' ? 'selected' : '' }}>Per Tanggal
                </option>
                <option value="bulan" {{ request('filter_waktu') == 'bulan' ? 'selected' : '' }}>Per Bulan</option>
                <option value="tahun" {{ request('filter_waktu') == 'tahun' ? 'selected' : '' }}>Tahun</option>
            </select>
        </div>

        @if (request('filter_waktu') == 'tanggal')
            <div>
                <label for="tanggal_awal" class="sr-only">Tanggal Awal</label>
                <input type="date" name="tanggal_awal" id="tanggal_awal" value="{{ request('tanggal_awal') }}"
                    class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm shadow-sm" />
            </div>
            <div>
                <label for="tanggal_akhir" class="sr-only">Tanggal Akhir</label>
                <input type="date" name="tanggal_akhir" id="tanggal_akhir" value="{{ request('tanggal_akhir') }}"
                    class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm shadow-sm" />
            </div>
        @elseif(request('filter_waktu') == 'bulan')
            <div>
                <label for="bulan_awal" class="sr-only">Bulan Awal</label>
                <select name="bulan_awal" id="bulan_awal"
                    class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm shadow-sm">
                    <option value="">Bulan Awal</option>
                    @foreach (range(1, 12) as $bulan)
                        <option value="{{ $bulan }}" {{ request('bulan_awal') == $bulan ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($bulan)->locale('id')->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="bulan_akhir" class="sr-only">Bulan Akhir</label>
                <select name="bulan_akhir" id="bulan_akhir"
                    class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm shadow-sm">
                    <option value="">Bulan Akhir</option>
                    @foreach (range(1, 12) as $bulan)
                        <option value="{{ $bulan }}" {{ request('bulan_akhir') == $bulan ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($bulan)->locale('id')->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="tahun_for_bulan" class="sr-only">Tahun untuk filter bulan</label>
                <select name="tahun" id="tahun_for_bulan"
                    class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm shadow-sm">
                    <option value="">Pilih Tahun</option>
                    @foreach ($tahunList as $tahunItem)
                        <option value="{{ $tahunItem }}" {{ request('tahun') == $tahunItem ? 'selected' : '' }}>
                            {{ $tahunItem }}
                        </option>
                    @endforeach
                </select>
            </div>
        @elseif(request('filter_waktu') == 'tahun')
            <div>
                <label for="tahun_filter_only" class="sr-only">Pilih Tahun</label>
                <select name="tahun" id="tahun_filter_only"
                    class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm shadow-sm">
                    <option value="">Pilih Tahun</option>
                    @foreach ($tahunList as $tahunItem)
                        <option value="{{ $tahunItem }}" {{ request('tahun') == $tahunItem ? 'selected' : '' }}>
                            {{ $tahunItem }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif
    @endif

    @if ($showNominal)
        <div class="flex flex-row items-center gap-2 col-span-2 xl:flex-col xl:col-span-2">
            <div class="w-full">
                <label for="jumlah_min" class="sr-only">Nominal Minimal</label>
                <input type="number" name="jumlah_min" id="jumlah_min" value="{{ request('jumlah_min') }}"
                    placeholder="Nominal Min"
                    class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm shadow-sm"
                    min="0" />
            </div>
            <span class="text-center py-1 sm:py-0 text-gray-800 dark:text-gray-200">-</span>
            <div class="w-full">
                <label for="jumlah_max" class="sr-only">Nominal Maksimal</label>
                <input type="number" name="jumlah_max" id="jumlah_max" value="{{ request('jumlah_max') }}"
                    placeholder="Nominal Max"
                    class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm shadow-sm"
                    min="0" />
            </div>
        </div>
    @endif

    @if ($showPerPage)
        <div>
            <select name="perPage" id="perPage" onchange="this.form.submit()"
                class="w-20 max-w-[8rem] rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm shadow-sm">
                @foreach ([10, 20, 50, 100] as $size)
                    <option value="{{ $size }}" {{ request('perPage', 10) == $size ? 'selected' : '' }}>
                        {{ $size }}
                    </option>
                @endforeach
            </select>
        </div>
    @endif

    {{-- Slot untuk tombol tambahan seperti 'Reset,Filter,Tambah, --}}
    {{ $slot }}

</form>

<script>
    document.getElementById('filter_waktu').addEventListener('change', function() {
        const selected = this.value;
        const url = new URL(window.location.href);
        url.searchParams.set('filter_waktu', selected);

        // Hapus parameter lain agar tidak error filter campur
        url.searchParams.delete('tanggal_awal');
        url.searchParams.delete('tanggal_akhir');
        url.searchParams.delete('bulan_awal');
        url.searchParams.delete('bulan_akhir');
        url.searchParams.delete('tahun');

        window.location.href = url.toString();

    });
</script>
