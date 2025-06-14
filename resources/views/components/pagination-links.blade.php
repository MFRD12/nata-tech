@props(['paginator'])

{{-- Hanya proses jika variabel $paginator ada/dikirim --}}
@if ($paginator)
    <div
        class="flex flex-col md:flex-row justify-between items-start md:items-center mt-4 text-sm text-gray-700 dark:text-gray-300 space-y-2 md:space-y-0">
        <div>
            {{-- Bagian ini akan selalu tampil jika $paginator ada --}}
            Tampil {{ $paginator->firstItem() ?? 0 }} sampai {{ $paginator->lastItem() ?? 0 }} dari
            {{ $paginator->total() }} data
        </div>

        {{-- Tombol-tombol navigasi halaman hanya tampil jika ada lebih dari satu halaman --}}
        @if ($paginator->hasPages())
            @php
                $currentPage = $paginator->currentPage();
                $lastPage = $paginator->lastPage();

                if ($lastPage <= 5) {
                    $start = 2;
                    $end = $lastPage - 1;
                } elseif ($currentPage <= 3) {
                    $start = 2;
                    $end = 4;
                } elseif ($currentPage >= $lastPage - 2) {
                    $start = $lastPage - 3;
                    $end = $lastPage - 1;
                } else {
                    $start = $currentPage - 1;
                    $end = $currentPage + 1;
                }

            @endphp

            <div class="flex items-center space-x-1">
                {{-- Tombol Previous --}}
                @if ($paginator->onFirstPage())
                    <span
                        class="px-3 py-1 rounded border bg-white dark:bg-gray-900 text-gray-400 dark:text-gray-500 cursor-not-allowed">&lt;</span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}"
                        class="px-3 py-1 rounded border bg-white text-gray-700 border-gray-300 hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600">
                        &lt;
                    </a>
                @endif

                {{-- Tombol Halaman Pertama --}}
                <a href="{{ $paginator->url(1) }}"
                    class="px-3 py-1 rounded border {{ $currentPage == 1 ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600' }}">
                    1
                </a>

                {{-- Ellipsis sebelum rentang halaman tengah --}}
                @if ($start > 2)
                    <span class="px-2 text-gray-500 dark:text-gray-400">...</span>
                @endif

                {{-- Rentang Halaman Tengah --}}
                @for ($i = $start; $i <= $end; $i++)
                    @if ($i > 1 && $i < $lastPage)
                        {{-- Pastikan tidak duplikat dengan link hal 1 atau terakhir --}}
                        <a href="{{ $paginator->url($i) }}"
                            class="px-3 py-1 rounded border {{ $currentPage == $i ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600' }}">
                            {{ $i }}
                        </a>
                    @endif
                @endfor

                {{-- Ellipsis setelah rentang halaman tengah --}}
                @if ($end < $lastPage - 1)
                    <span class="px-2 text-gray-500 dark:text-gray-400">...</span>
                @endif

                {{-- Tombol Halaman Terakhir (hanya jika lebih dari 1 halaman dan tidak sama dengan halaman 1) --}}
                @if ($lastPage > 1)
                    <a href="{{ $paginator->url($lastPage) }}"
                        class="px-3 py-1 rounded border {{ $currentPage == $lastPage ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600' }}">
                        {{ $lastPage }}
                    </a>
                @endif

                {{-- Tombol Next --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}"
                        class="px-3 py-1 rounded border bg-white text-gray-700 border-gray-300 hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600">
                        &gt;
                    </a>
                @else
                    <span
                        class="px-3 py-1 rounded border bg-white dark:bg-gray-900 text-gray-400 dark:text-gray-500 cursor-not-allowed">&gt;</span>
                @endif
            </div>
        @endif {{-- Akhir dari @if ($paginator->hasPages()) --}}
    </div>
@endif {{-- Akhir dari @if ($paginator) --}}
