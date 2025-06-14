<x-app-layout>
    @section('title', 'Absensi Pegawai')

    @if (session('success'))
        <x-alert type="success" :message="session('success')" :duration="3000" />
    @endif

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 p-6">
        <div class="max-w-6xl mx-auto">
            <div
                class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 sm:mb-6 space-y-2 sm:space-y-0">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Absensi Pegawai</h1>
                <a href="{{ route('view-riwayat-absen') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    <i class="fas fa-clock-rotate-left"></i> Riwayat
                </a>
            </div>


            <div class="overflow-x-auto  no-scrollbar bg-white dark:bg-gray-800 shadow rounded-lg whitespace-nowrap">
                <table class="w-full text-center text-sm">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Hari</th>
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3">Absen Masuk</th>
                            <th class="px-6 py-3">Absen Pulang</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-t border-gray-300 dark:border-gray-700 text-gray-800 dark:text-gray-100">
                            {{-- Status Icon --}}
                            <td class="px-6 py-4">
                                @if (!$absen)
                                    <i class="fas fa-triangle-exclamation text-yellow-500 text-lg"
                                        title="Belum Absen"></i>
                                @elseif($absen->jam_masuk && !$absen->jam_pulang)
                                    <i class="fas fa-clock text-green-500 text-lg"
                                        title="Sudah Masuk, Belum Pulang"></i>
                                @elseif($absen->jam_masuk && $absen->jam_pulang)
                                    <i class="fas fa-check-circle text-green-500 text-lg"
                                        title="Sudah Absen Lengkap"></i>
                                @endif
                            </td>

                            {{-- Hari --}}
                            <td class="px-6 py-4">
                                {{ now()->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('l') }}</td>
                            {{-- Tanggal --}}
                            <td class="px-6 py-4">
                                {{ now()->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('j F Y') }}</td>


                            {{-- Absen Masuk --}}
                            <td class="px-6 py-4">
                                @if (!$absen && $isAbsensiOpen)
                                    <form method="POST" action="{{ route('absen-masuk') }}">
                                        @csrf
                                        <button type="submit"
                                            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                                            <i class="fas fa-sign-in-alt"></i> Masuk
                                        </button>
                                    </form>
                                @else
                                    <button class="bg-gray-400 text-white px-4 py-2 rounded cursor-not-allowed"
                                        disabled>
                                        <i class="fas fa-sign-in-alt"></i> Masuk
                                    </button>
                                @endif
                            </td>

                            {{-- Absen Pulang --}}
                            <td class="px-6 py-4">
                                @if ($absen && $absen->jam_masuk && !$absen->jam_pulang && $isAbsensiOpen)
                                    <form method="POST" action="{{ route('absen-pulang') }}">
                                        @csrf
                                        <button type="submit"
                                            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                                            <i class="fas fa-sign-out-alt"></i> Pulang
                                        </button>
                                    </form>
                                @else
                                    <button class="bg-gray-400 text-white px-4 py-2 rounded cursor-not-allowed"
                                        disabled>
                                        <i class="fas fa-sign-out-alt"></i> Pulang
                                    </button>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app-layout>
