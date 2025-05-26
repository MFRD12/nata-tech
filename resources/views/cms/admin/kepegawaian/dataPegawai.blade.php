<x-app-layout>
    @section('title', 'Data Pegawai')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200 tracking-tight">Data Pegawai</h1>

        @if (session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 2000)" x-show="show" x-transition
                class="bg-green-100 text-green-800 p-3 rounded mb-4 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div id="errorModal" class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center px-4">
                <div
                    class="bg-white dark:bg-gray-900 text-red-600 dark:text-red-400 rounded-xl shadow-lg w-full max-w-md p-6 text-center">
                    <h3 class="text-xl font-semibold mb-4">Error</h3>
                    <p>{{ session('error') }}</p>
                    <div class="mt-6">
                        <a href="{{ route('view-pegawai') }}"
                            class="px-4 py-2 rounded-lg bg-gray-500 hover:bg-gray-600 text-white text-sm">
                            Tutup
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <form method="GET" action="{{ route('view-pegawai') }}" class="mb-6 space-y-4 md:space-y-0">
            <!-- Tambah button -->
            <div class="mb-6 space-y-4 md:space-y-0">
                <div class="md:hidden">
                    <a href="{{ route('tambah-view-pegawai') }}"
                        class="w-full block text-center bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm shadow">
                        + Tambah
                    </a>
                </div>

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto md:flex-1">
                        <!-- Search -->
                        <input type="text" id="search-input" name="search" value="{{ request('search') }}"
                            placeholder="Cari Nama atau NIP"
                            class="w-full sm:w-64 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm shadow-sm">

                        <!-- Filter Status -->
                        <select name="status" onchange="this.form.submit()"
                            class="w-full sm:w-52 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm shadow-sm">
                            <option value="">-- Filter berdasarkan status --</option>
                            <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="tidak aktif" {{ request('status') === 'tidak aktif' ? 'selected' : '' }}>
                                Tidak Aktif
                            </option>
                        </select>

                        <!-- Reset -->
                        @if (request('search') || request('status'))
                            <a href="{{ route('view-pegawai') }}"
                                class="inline-flex items-center justify-center bg-red-500 text-gray-200 hover:bg-red-600 px-4 py-2 rounded text-sm shadow-sm transition">
                                Reset
                            </a>
                        @endif
                    </div>

                    <!-- Tambah button-->
                    <div class="hidden md:block">
                        <a href="{{ route('tambah-view-pegawai') }}"
                            class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm shadow">
                            + Tambah
                        </a>
                    </div>
                </div>
            </div>
        </form>

        <!-- Tabel Data Pegawai -->
        <div class="overflow-x-auto no-scrollbar rounded-lg shadow ring-1 ring-black ring-opacity-5">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr class="text-gray-700 dark:text-gray-300 text-left">
                        <th class="px-4 py-3 font-semibold">No</th>
                        <th class="px-4 py-3 font-semibold">Foto</th>
                        <th class="px-4 py-3 font-semibold">NIP</th>
                        <th class="px-4 py-3 font-semibold">Nama</th>
                        <th class="px-4 py-3 font-semibold">Tanggal Masuk</th>
                        <th class="px-4 py-3 font-semibold">Status</th>
                        <th class="px-4 py-3 font-semibold text-center sticky right-0 bg-gray-50 dark:bg-gray-700 z-5">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($pegawais as $data)
                        <tr x-data="{ open: false }" class="hover:bg-gray-100 dark:hover:bg-gray-800">
                            <td class="px-4 py-3 text-center text-gray-800 dark:text-gray-200">
                                {{ ($pegawais->currentPage() - 1) * $pegawais->perPage() + $loop->iteration }}
                            </td>
                            <td class="px-4 py-3">
                                @if ($data->foto)
                                    <img src="{{ asset('storage/' . $data->foto) }}" alt="Foto"
                                        class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <div
                                        class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-600">
                                        N/A</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-800 dark:text-gray-200">{{ $data->nip_pegawai }}</td>
                            <td class="px-4 py-3 text-gray-800 dark:text-gray-200">{{ $data->nama }}</td>
                            <td class="px-4 py-3 text-gray-800 dark:text-gray-200">
                                {{ \Carbon\Carbon::parse($data->tgl_masuk)->format('d M Y') }}
                            </td>
                            <td class="px-4 py-3 text-gray-800 dark:text-gray-200">
                                <span
                                    class="inline-block px-2 py-1 rounded text-xs font-semibold
                {{ $data->status == 'aktif' ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                    {{ ucfirst($data->status) }}
                                </span>
                            </td>
                            <td
                                class="px-4 py-5 text-center sticky right-0 bg-white dark:bg-gray-900 z-5 flex justify-center gap-2">
                                <button onclick="toggleDetail({{ $data->id }})"
                                    class="bg-blue-600
                                    hover:bg-blue-700 text-white px-3 py-1.5 rounded text-xs font-medium shadow-sm">
                                    View
                                </button>
                                <a href="{{ route('edit-view-pegawai', $data->id) }}"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1.5 rounded text-xs font-medium shadow-sm">
                                    Edit
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
                                    <div><strong>Jabatan:</strong> {{ $data->jabatan ?? '-' }}</div>
                                    <div><strong>Divisi:</strong> {{ $data->divisi ?? '-' }}</div>
                                    <div><strong>Status:</strong> {{ $data->status ? ucfirst($data->status) : '-' }}
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @php
            $currentPage = $pegawais->currentPage();
            $lastPage = $pegawais->lastPage();
            $start = max($currentPage - 1, 2);
            $end = min($currentPage + 1, $lastPage - 1);
        @endphp

        <div
            class="flex flex-col md:flex-row justify-between items-start md:items-center mt-4 text-sm text-gray-700 dark:text-gray-300 space-y-2 md:space-y-0">
            <div>
                Tampil {{ $pegawais->firstItem() }} sampai {{ $pegawais->lastItem() }} dari {{ $pegawais->total() }}
                data
            </div>

            @if ($lastPage > 1)
                <div class="flex items-center space-x-1">
                    {{-- Previous --}}
                    @if ($pegawais->onFirstPage())
                        <span
                            class="px-3 py-1 rounded border bg-white dark:bg-gray-900 text-gray-400 dark:text-gray-500 cursor-not-allowed">&lt;</span>
                    @else
                        <a href="{{ $pegawais->previousPageUrl() }}"
                            class="px-3 py-1 rounded border bg-white text-gray-700 border-gray-300 hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600">
                            &lt;
                        </a>
                    @endif

                    {{-- First page --}}
                    <a href="{{ $pegawais->url(1) }}"
                        class="px-3 py-1 rounded border {{ $currentPage == 1 ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600' }}">
                        1
                    </a>

                    {{-- Ellipsis before --}}
                    @if ($start > 2)
                        <span class="px-2 text-gray-500 dark:text-gray-400">...</span>
                    @endif

                    {{-- Page range --}}
                    @for ($i = $start; $i <= $end; $i++)
                        <a href="{{ $pegawais->url($i) }}"
                            class="px-3 py-1 rounded border {{ $currentPage == $i ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600' }}">
                            {{ $i }}
                        </a>
                    @endfor

                    {{-- Ellipsis after --}}
                    @if ($end < $lastPage - 1)
                        <span class="px-2 text-gray-500 dark:text-gray-400">...</span>
                    @endif

                    {{-- Last page --}}
                    <a href="{{ $pegawais->url($lastPage) }}"
                        class="px-3 py-1 rounded border {{ $currentPage == $lastPage ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600' }}">
                        {{ $lastPage }}
                    </a>

                    {{-- Next --}}
                    @if ($pegawais->hasMorePages())
                        <a href="{{ $pegawais->nextPageUrl() }}"
                            class="px-3 py-1 rounded border bg-white text-gray-700 border-gray-300 hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600">
                            &gt;
                        </a>
                    @else
                        <span
                            class="px-3 py-1 rounded border bg-white dark:bg-gray-900 text-gray-400 dark:text-gray-500 cursor-not-allowed">&gt;</span>
                    @endif
                </div>
            @endif
        </div>


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
</x-app-layout>
