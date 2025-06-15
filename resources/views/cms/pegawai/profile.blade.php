<x-app-layout>
    @section('title', 'Profil Saya')

    @if (session('success'))
        <x-alert type="success" :message="session('success')" :duration="3000" />
    @endif
    
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-10 px-4 sm:px-6 lg:px-8">
        <div class="relative max-w-5xl mx-auto bg-white dark:bg-gray-800 shadow-lg rounded-2xl overflow-hidden">

            {{-- Tombol Edit Desktop --}}
            <div class="hidden md:block absolute top-4 right-4 z-10">
                <a href="{{ route('view-edit-profile') }}"
                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-md shadow-md transition-all text-sm">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </div>

            {{-- Header --}}
            <div class="flex flex-col sm:flex-row items-center md:items-start gap-8 p-8 border-b dark:border-gray-700">

                {{-- Foto --}}
                <div
                    class="w-40 h-52 flex-shrink-0 border-4 border-white dark:border-gray-700 shadow-lg overflow-hidden rounded-md">
                    <img src="{{ $pegawai->foto ? asset('storage/' . $pegawai->foto) : asset('images/default-user.png`') }}"
                        alt="Foto Pegawai" class="w-full h-full object-cover">
                </div>

                {{-- Tombol Edit Mobile --}}
                <div class="mt-4 md:hidden">
                    <a href="{{ route('view-edit-profile') }}"
                        class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-md shadow-md transition-all text-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>

                {{-- Info --}}
                <div class="text-left sm:text-center space-y-1">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">{{ $pegawai->nama }}</h2>
                    <p class="text-lg text-gray-600 dark:text-gray-300">
                        {{ $pegawai->jabatan->name ?? '-' }}
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $pegawai->divisi->name ?? '-' }}
                    </p>
                </div>
            </div>

            {{-- Detail --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-8 text-gray-700 dark:text-gray-200">
                @php
                    $details = [
                        'NIP' => !empty($pegawai->nip_pegawai) ? $pegawai->nip_pegawai : '-',
                        'Tempat, Tgl Lahir' =>
                            !empty($pegawai->tempat_lahir) && !empty($pegawai->tgl_lahir)
                                ? $pegawai->tempat_lahir .
                                    ', ' .
                                    \Carbon\Carbon::parse($pegawai->tgl_lahir)->translatedFormat('d F Y')
                                : '-',
                        'Jenis Kelamin' => !empty($pegawai->gender) ? ucfirst($pegawai->gender) : '-',
                        'No. HP' => !empty($pegawai->no_hp) ? $pegawai->no_hp : '-',
                        'Tanggal Masuk' => !empty($pegawai->tgl_masuk)
                            ? \Carbon\Carbon::parse($pegawai->tgl_masuk)->translatedFormat('d F Y')
                            : '-',
                        'Status' => !empty($pegawai->status) ? ucfirst($pegawai->status) : '-',
                        'Alamat' => !empty($pegawai->alamat) ? $pegawai->alamat : '-',
                    ];
                @endphp


                @foreach ($details as $label => $value)
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-4 last:border-0">
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold uppercase tracking-wider">
                            {{ $label }}
                        </p>
                        <p class="text-lg font-semibold mt-1">{{ $value }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
