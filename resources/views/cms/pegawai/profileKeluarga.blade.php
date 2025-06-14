<x-app-layout>
    @section('title', 'Profile Keluarga')

    @if (session('success'))
        <x-alert type="success" :message="session('success')" :duration="3000" />
    @endif

    @php
        function displayValue($value, $default = '-')
        {
            return !empty($value) ? $value : $default;
        }

        $pendidikanLabels = [
            'sd' => 'SD',
            'smp' => 'SMP',
            'sma' => 'SMA',
            'd3' => 'D3',
            's1' => 'S1',
            's2' => 'S2',
            's3' => 'S3',
        ];
        $statusBekerjaLabels = [
            'bekerja' => 'Bekerja',
            'tidak bekerja' => 'Tidak Bekerja',
            'pelajar' => 'Pelajar',
        ];
    @endphp

    <div class="py-10 px-4 sm:px-6 lg:px-8 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-5xl mx-auto">

            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden mb-8">
                <div
                    class="px-6 py-5 bg-gray-100 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-xl leading-6 font-semibold text-black dark:text-white">
                        Profile Keluarga
                    </h3>
                    <a href="{{ route('view-edit-profile-keluarga') }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
                        Edit
                    </a>
                </div>
                <div class="border-t border-gray-200 dark:border-gray-700 px-6 py-5">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Pegawai</dt>
                            <dd class="mt-1 text-black dark:text-white">
                                {{ displayValue($keluarga->pegawai->nama ?? null) }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Pernikahan</dt>
                            <dd class="mt-1 text-black dark:text-white">
                                {{ displayValue(ucfirst($keluarga->status_pernikahan)) }}</dd>
                        </div>
                        @if (!empty($keluarga->status_pernikahan) && !empty($keluarga->no_kk))
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">No. Kartu Keluarga</dt>
                                <dd class="mt-1 text-black dark:text-white">{{ displayValue($keluarga->no_kk) }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>
            </div>

            @if ($keluarga->status_pernikahan == 'menikah')
                <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden mb-8">
                    <div class="px-6 py-5 bg-gray-100 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-xl leading-6 font-semibold text-black dark:text-white">Data Pasangan</h3>
                    </div>
                    <div class="border-t border-gray-200 dark:border-gray-700 px-6 py-5">
                        <dl class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-6">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Pasangan</dt>
                                <dd class="mt-1 text-black dark:text-white">{{ displayValue($keluarga->nama_pasangan) }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">NIK Pasangan</dt>
                                <dd class="mt-1 text-black dark:text-white">{{ displayValue($keluarga->nik_pasangan) }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Jenis Kelamin</dt>
                                <dd class="mt-1 text-black dark:text-white">
                                    {{ displayValue(ucfirst($keluarga->gender)) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Agama</dt>
                                <dd class="mt-1 text-black dark:text-white">{{ displayValue($keluarga->agama) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">No. Telepon</dt>
                                <dd class="mt-1 text-black dark:text-white">
                                    {{ displayValue($keluarga->no_telp_pasangan) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Pendidikan Terakhir
                                </dt>
                                <dd class="mt-1 text-black dark:text-white">
                                    {{ displayValue($pendidikanLabels[$keluarga->pendidikan_terakhir] ?? ucfirst($keluarga->pendidikan_terakhir)) }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Bekerja</dt>
                                <dd class="mt-1 text-black dark:text-white">
                                    {{ displayValue(ucfirst($keluarga->status_bekerja_pasangan)) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Pasangan</dt>
                                <dd class="mt-1 text-black dark:text-white">
                                    {{ displayValue(ucfirst($keluarga->status_pasangan)) }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden mb-8">
                <div class="px-6 py-5 bg-gray-100 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-xl leading-6 font-semibold text-black dark:text-white">Data Orang Tua</h3>
                </div>
                <div class="border-t border-gray-200 dark:border-gray-700 px-6 py-5">
                    <div class="mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
                        <h4 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-3">Data Ayah</h4>
                        <dl class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-6">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Ayah</dt>
                                <dd class="mt-1 text-black dark:text-white">{{ displayValue($keluarga->nama_ayah) }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">No. Telepon Ayah</dt>
                                <dd class="mt-1 text-black dark:text-white">{{ displayValue($keluarga->no_telp_ayah) }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Bekerja Ayah
                                </dt>
                                <dd class="mt-1 text-black dark:text-white">
                                    {{ displayValue(ucfirst($keluarga->status_bekerja_ayah)) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Ayah</dt>
                                <dd class="mt-1 text-black dark:text-white">
                                    {{ displayValue(ucfirst($keluarga->status_ayah)) }}</dd>
                            </div>
                        </dl>
                    </div>
                    <div>
                        <h4 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-3">Data Ibu</h4>
                        <dl class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-6">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Ibu</dt>
                                <dd class="mt-1 text-black dark:text-white">{{ displayValue($keluarga->nama_ibu) }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">No. Telepon Ibu</dt>
                                <dd class="mt-1 text-black dark:text-white">{{ displayValue($keluarga->no_telp_ibu) }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Bekerja Ibu</dt>
                                <dd class="mt-1 text-black dark:text-white">
                                    {{ displayValue(ucfirst($keluarga->status_bekerja_ibu)) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Ibu</dt>
                                <dd class="mt-1 text-black dark:text-white">
                                    {{ displayValue(ucfirst($keluarga->status_ibu)) }}</dd>
                            </div>
                        </dl>
                    </div>
                    @if (!empty($keluarga->alamat_ortu))
                        <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Alamat Orang Tua</dt>
                            <dd class="mt-1 text-black dark:text-white whitespace-pre-line">
                                {{ displayValue($keluarga->alamat_ortu) }}</dd>
                        </div>
                    @endif
                </div>
            </div>

            @if ($keluarga->anak && $keluarga->anak->isNotEmpty())
                <div class="mb-8">
                    <h3 class="text-2xl font-semibold text-black dark:text-white mb-6">Data Anak</h3>
                    <div class="space-y-6">
                        @foreach ($keluarga->anak as $index => $anak)
                            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
                                <div
                                    class="px-6 py-5 bg-gray-100 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-700">
                                    <h4 class="text-lg leading-6 font-medium text-black dark:text-white">
                                        Anak Ke - {{ $index + 1 }}: {{ displayValue($anak->nama) }}
                                    </h4>
                                </div>
                                <div class="border-t border-gray-200 dark:border-gray-700 px-6 py-5">
                                    <dl class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-6">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">NIK</dt>
                                            <dd class="mt-1 text-black dark:text-white">{{ displayValue($anak->nik) }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tempat
                                                Lahir</dt>
                                            <dd class="mt-1 text-black dark:text-white">
                                                {{ displayValue($anak->tempat_lahir) }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal
                                                Lahir</dt>
                                            <dd class="mt-1 text-black dark:text-white">
                                                {{ $anak->tgl_lahir ? \Carbon\Carbon::parse($anak->tgl_lahir)->isoFormat('D MMMM YYYY') : '-' }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Jenis
                                                Kelamin</dt>
                                            <dd class="mt-1 text-black dark:text-white">
                                                {{ displayValue(ucfirst($anak->gender)) }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status
                                                Bekerja</dt>
                                            <dd class="mt-1 text-black dark:text-white">
                                                {{ displayValue($statusBekerjaLabels[$anak->status_bekerja] ?? ucfirst($anak->status_bekerja)) }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status
                                                Hidup</dt>
                                            <dd class="mt-1 text-black dark:text-white">
                                                {{ displayValue(ucfirst($anak->status_hidup)) }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Anak
                                            </dt>
                                            <dd class="mt-1 text-black dark:text-white">
                                                {{ displayValue(ucfirst($anak->status_anak)) }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status
                                                Pernikahan Anak</dt>
                                            <dd class="mt-1 text-black dark:text-white">
                                                {{ displayValue(ucfirst($anak->status_pernikahan)) }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status
                                                Tanggungan</dt>
                                            <dd class="mt-1 text-black dark:text-white">
                                                {{ $anak->status_tanggungan ?? false ? 'Ya' : 'Tidak' }}</dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @elseif(!empty($keluarga->status_pernikahan))
                <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg p-6 mb-8 text-center">
                    <p class="text-gray-600 dark:text-gray-400">Belum ada data anak yang dimasukkan.</p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
