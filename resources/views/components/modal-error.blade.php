@props([
    'message', // Pesan error yang akan ditampilkan (wajib)
    'title' => 'Error!', // Judul modal, default "Error!"
    'show' => false, // Properti untuk mengontrol visibilitas modal dari parent
    'closeRoute' => null, // Nama rute untuk tombol tutup (opsional)
    'closeButtonText' => 'Tutup', // Teks untuk tombol tutup
])

{{-- Hanya tampilkan modal jika 'show' adalah true --}}
@if ($show)
    <div x-data="{ open: true }" x-show="open" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/60 z-[999] flex items-center justify-center px-4" style="display: flex;"
        aria-labelledby="modal-title-{{ Str::slug($title) }}" role="dialog" aria-modal="true">
        <div @click.away="open = false" x-show="open" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-md p-6 text-center transform transition-all"
            {{-- Klik di luar modal untuk menutup (opsional) --}} {{-- @click.away="open = false"  --}}>
            {{-- Ikon Error (Opsional, contoh menggunakan Heroicons) --}}
            <div
                class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-800/30 mb-4">
                <svg class="h-6 w-6 text-red-600 dark:text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                </svg>
            </div>

            <h3 id="modal-title-{{ Str::slug($title) }}"
                class="text-xl font-semibold mb-3 text-gray-800 dark:text-white">{{ $title }}</h3>

            <div class="text-sm text-gray-600 dark:text-gray-300">
                @if ($message instanceof \Illuminate\Contracts\Support\Htmlable)
                    {!! $message !!}
                @else
                    <p>{{ $message }}</p>
                @endif
            </div>

            <div class="mt-6">
                @if ($closeRoute)
                    <a href="{{ route($closeRoute) }}"
                        class="px-5 py-2.5 rounded-lg bg-red-600 hover:bg-red-700 text-white text-sm font-medium shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition duration-150 ease-in-out">
                        {{ $closeButtonText }}
                    </a>
                @else
                    {{-- Tombol default untuk menutup modal via Alpine.js jika tidak ada route spesifik --}}
                    <button @click="open = false" type="button"
                        class="px-5 py-2.5 rounded-lg bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition duration-150 ease-in-out">
                        {{ $closeButtonText }}
                    </button>
                @endif
            </div>
        </div>
    </div>
@endif
