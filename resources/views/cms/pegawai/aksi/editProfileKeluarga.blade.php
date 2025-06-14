<x-app-layout>
    @section('title', 'Edit Profile Keluarga')

    <div class="min-h-screen bg-white dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto bg-white dark:bg-gray-800 rounded-xl shadow-md p-8">
            <h2 class="text-3xl font-semibold text-gray-800 dark:text-white mb-8">Edit Profile Keluarga</h2>

            @if (session('error'))
                <x-alert type="error" :message="session('error')" :duration="7000" />
            @endif

            <form id="keluargaForm" action="{{ route('update-profile-keluarga') }}" method="POST">
                @csrf
                @method('POST')

                <div class="mb-8">
                    <input type="hidden" id="pegawai_id" value="{{ $keluarga->pegawai_id }}">
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-3">Status Pernikahan</label>
                    <div class="flex space-x-6">
                        <label class="flex items-center">
                            <input type="radio" name="status_pernikahan" value="belum menikah"
                                   {{ old('status_pernikahan', $keluarga->status_pernikahan) == 'belum menikah' ? 'checked' : '' }}
                                   onchange="toggleMarriageFields()" class="text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:border-gray-600">
                            <span class="ml-2 text-gray-700 dark:text-gray-200">Belum Menikah</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="status_pernikahan" value="menikah"
                                   {{ old('status_pernikahan', $keluarga->status_pernikahan) == 'menikah' ? 'checked' : '' }}
                                   onchange="toggleMarriageFields()" class="text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:border-gray-600">
                            <span class="ml-2 text-gray-700 dark:text-gray-200">Menikah</span>
                        </label>
                    </div>
                </div>

                <div class="mb-6" id="no_kk_section" style="display: none;">
                    <label for="no_kk" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">No. Kartu Keluarga</label>
                    <input type="text" name="no_kk" id="no_kk" value="{{ old('no_kk', $keluarga->no_kk) }}" maxlength="16"
                           class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required disabled>
                </div>

                <div id="pasangan_section" style="display: none;" class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4 border-b border-gray-200 dark:border-gray-600 pb-2">Data Pasangan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nama_pasangan" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Nama Pasangan</label>
                            <input type="text" name="nama_pasangan" id="nama_pasangan" value="{{ old('nama_pasangan', $keluarga->nama_pasangan ?? '') }}" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required disabled>
                        </div>
                        <div>
                            <label for="nik_pasangan" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">NIK Pasangan</label>
                            <input type="text" name="nik_pasangan" id="nik_pasangan" value="{{ old('nik_pasangan', $keluarga->nik_pasangan ?? '') }}" maxlength="16" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required disabled>
                        </div>
                        <div>
                            <label for="gender_pasangan" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Jenis Kelamin</label>
                            <select name="gender" id="gender_pasangan" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required disabled>
                                <option value="">-- Pilih --</option>
                                <option value="laki-laki" {{ old('gender_pasangan', $keluarga->gender ?? '') == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="perempuan" {{ old('gender_pasangan', $keluarga->gender ?? '') == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label for="agama_pasangan" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Agama</label>
                            <select name="agama" id="agama_pasangan" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required disabled>
                                <option value="">-- Pilih --</option>
                                @foreach (['Islam', 'Katolik', 'Kristen', 'Hindu', 'Buddha', 'Konghucu'] as $agama)
                                <option value="{{ $agama }}" {{ old('agama', $keluarga->agama ?? '') == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="no_telp_pasangan" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">No. Telepon Pasangan</label>
                            <input type="text" name="no_telp_pasangan" id="no_telp_pasangan" value="{{ old('no_telp_pasangan', $keluarga->no_telp_pasangan ?? '') }}" maxlength="15" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required disabled>
                        </div>
                        <div>
                            <label for="pendidikan_terakhir_pasangan" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Pendidikan Terakhir</label>
                            <select name="pendidikan_terakhir" id="pendidikan_terakhir_pasangan" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required disabled>
                                 <option value="">-- Pilih --</option>
                                @foreach (['sd'=>'SD', 'smp'=>'SMP', 'sma'=>'SMA', 'd3'=>'D3', 's1'=>'S1', 's2'=>'S2', 's3'=>'S3', 'lainnya'=>'Lainnya'] as $val => $label)
                                <option value="{{ $val }}" {{ old('pendidikan_terakhir', $keluarga->pendidikan_terakhir ?? '') == $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="status_bekerja_pasangan" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Status Bekerja</label>
                            <select name="status_bekerja_pasangan" id="status_bekerja_pasangan" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required disabled>
                                <option value="">-- Pilih --</option>
                                <option value="bekerja" {{ old('status_bekerja_pasangan', $keluarga->status_bekerja_pasangan ?? '') == 'bekerja' ? 'selected' : '' }}>Bekerja</option>
                                <option value="tidak bekerja" {{ old('status_bekerja_pasangan', $keluarga->status_bekerja_pasangan ?? '') == 'tidak bekerja' ? 'selected' : '' }}>Tidak Bekerja</option>
                            </select>
                        </div>
                        <div>
                            <label for="status_pasangan" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Status Pasangan</label>
                            <select name="status_pasangan" id="status_pasangan" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required disabled>
                                <option value="">-- Pilih --</option>
                                <option value="hidup" {{ old('status_pasangan', $keluarga->status_pasangan ?? '') == 'hidup' ? 'selected' : '' }}>Hidup</option>
                                <option value="meninggal" {{ old('status_pasangan', $keluarga->status_pasangan ?? '') == 'meninggal' ? 'selected' : '' }}>Meninggal</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div id="orangtua_section" style="display: none;" class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4 border-b border-gray-200 dark:border-gray-600 pb-2">Data Orang Tua</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2"><h4 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-3">Data Ayah</h4></div>
                        <div>
                            <label for="nama_ayah" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Nama Ayah</label>
                            <input type="text" name="nama_ayah" id="nama_ayah" value="{{ old('nama_ayah', $keluarga->nama_ayah ?? '') }}" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required disabled>
                        </div>
                        <div>
                            <label for="no_telp_ayah" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">No. Telepon Ayah</label>
                            <input type="text" name="no_telp_ayah" id="no_telp_ayah" value="{{ old('no_telp_ayah', $keluarga->no_telp_ayah ?? '') }}" maxlength="15" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required disabled>
                        </div>
                         <div>
                            <label for="status_bekerja_ayah" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Status Bekerja Ayah</label>
                            <select name="status_bekerja_ayah" id="status_bekerja_ayah" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required disabled>
                                <option value="">-- Pilih --</option>
                                <option value="bekerja" {{ old('status_bekerja_ayah', $keluarga->status_bekerja_ayah ?? '') == 'bekerja' ? 'selected' : '' }}>Bekerja</option>
                                <option value="tidak bekerja" {{ old('status_bekerja_ayah', $keluarga->status_bekerja_ayah ?? '') == 'tidak bekerja' ? 'selected' : '' }}>Tidak Bekerja</option>
                            </select>
                        </div>
                        <div>
                            <label for="status_ayah" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Status Ayah</label>
                            <select name="status_ayah" id="status_ayah" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required disabled>
                                 <option value="">-- Pilih --</option>
                                <option value="hidup" {{ old('status_ayah', $keluarga->status_ayah ?? '') == 'hidup' ? 'selected' : '' }}>Hidup</option>
                                <option value="meninggal" {{ old('status_ayah', $keluarga->status_ayah ?? '') == 'meninggal' ? 'selected' : '' }}>Meninggal</option>
                            </select>
                        </div>

                        <div class="md:col-span-2 mt-6"><h4 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-3">Data Ibu</h4></div>
                        <div>
                            <label for="nama_ibu" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Nama Ibu</label>
                            <input type="text" name="nama_ibu" id="nama_ibu" value="{{ old('nama_ibu', $keluarga->nama_ibu ?? '') }}" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required disabled>
                        </div>
                        <div>
                            <label for="no_telp_ibu" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">No. Telepon Ibu</label>
                            <input type="text" name="no_telp_ibu" id="no_telp_ibu" value="{{ old('no_telp_ibu', $keluarga->no_telp_ibu ?? '') }}" maxlength="15" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required disabled>
                        </div>
                        <div>
                            <label for="status_bekerja_ibu" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Status Bekerja Ibu</label>
                            <select name="status_bekerja_ibu" id="status_bekerja_ibu" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required disabled>
                                <option value="">-- Pilih --</option>
                                <option value="bekerja" {{ old('status_bekerja_ibu', $keluarga->status_bekerja_ibu ?? '') == 'bekerja' ? 'selected' : '' }}>Bekerja</option>
                                <option value="tidak bekerja" {{ old('status_bekerja_ibu', $keluarga->status_bekerja_ibu ?? '') == 'tidak bekerja' ? 'selected' : '' }}>Tidak Bekerja</option>
                            </select>
                        </div>
                        <div>
                            <label for="status_ibu" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Status Ibu</label>
                            <select name="status_ibu" id="status_ibu" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required disabled>
                                <option value="">-- Pilih --</option>
                                <option value="hidup" {{ old('status_ibu', $keluarga->status_ibu ?? '') == 'hidup' ? 'selected' : '' }}>Hidup</option>
                                <option value="meninggal" {{ old('status_ibu', $keluarga->status_ibu ?? '') == 'meninggal' ? 'selected' : '' }}>Meninggal</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label for="alamat_ortu" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Alamat Orang Tua</label>
                            <textarea name="alamat_ortu" id="alamat_ortu" rows="3" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required disabled>{{ old('alamat_ortu', $keluarga->alamat_ortu ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                <div id="existing_children_forms_container">
                    @if($keluarga->anak && $keluarga->anak->count() > 0)
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4 border-b border-gray-200 dark:border-gray-600 pb-2 mt-8">Data Anak Tersimpan</h3>
                        @foreach ($keluarga->anak as $anak_item)
                            <div id="child-form-existing-{{ $anak_item->id }}" class="mb-8 p-6 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 relative">
                                <input type="hidden" name="anak[{{ $anak_item->id }}][id]" value="{{ $anak_item->id }}">
                                
                                <div class="flex justify-between items-center mb-4">
                                    <h4 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-3">Data Anak ke - {{ $loop->iteration }}</h4>
                                    <button type="button" onclick="removeChildForm('child-form-existing-{{ $anak_item->id }}', true, {{ $anak_item->id }})"
                                            class="text-red-600 hover:text-red-800 font-semibold">✕ Hapus</button>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Nama Anak</label>
                                        <input type="text" name="anak[{{ $anak_item->id }}][nama]" value="{{ old('anak.'.$anak_item->id.'.nama', $anak_item->nama) }}" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">NIK</label>
                                        <input type="text" name="anak[{{ $anak_item->id }}][nik]" value="{{ old('anak.'.$anak_item->id.'.nik', $anak_item->nik) }}" maxlength="16" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Tempat Lahir</label>
                                        <input type="text" name="anak[{{ $anak_item->id }}][tempat_lahir]" value="{{ old('anak.'.$anak_item->id.'.tempat_lahir', $anak_item->tempat_lahir) }}" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Tanggal Lahir</label>
                                        <input type="date" name="anak[{{ $anak_item->id }}][tgl_lahir]" value="{{ old('anak.'.$anak_item->id.'.tgl_lahir', $anak_item->tgl_lahir ? \Carbon\Carbon::parse($anak_item->tgl_lahir)->format('Y-m-d') : '') }}" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Jenis Kelamin</label>
                                        <select name="anak[{{ $anak_item->id }}][gender]" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                                            <option value="">-- Pilih --</option>
                                            <option value="laki-laki" {{ old('anak.'.$anak_item->id.'.gender', $anak_item->gender) == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="perempuan" {{ old('anak.'.$anak_item->id.'.gender', $anak_item->gender) == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Status Bekerja</label>
                                        <select name="anak[{{ $anak_item->id }}][status_bekerja]" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                                            <option value="">-- Pilih --</option>
                                            <option value="bekerja" {{ old('anak.'.$anak_item->id.'.status_bekerja', $anak_item->status_bekerja) == 'bekerja' ? 'selected' : '' }}>Bekerja</option>
                                            <option value="tidak bekerja" {{ old('anak.'.$anak_item->id.'.status_bekerja', $anak_item->status_bekerja) == 'tidak bekerja' ? 'selected' : '' }}>Tidak Bekerja</option>
                                            <option value="pelajar" {{ old('anak.'.$anak_item->id.'.status_bekerja', $anak_item->status_bekerja) == 'pelajar' ? 'selected' : '' }}>Pelajar</option>
                                        </select>
                                    </div>
                                     <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Status Hidup</label>
                                        <select name="anak[{{ $anak_item->id }}][status_hidup]" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                                            <option value="">-- Pilih --</option>
                                            <option value="hidup" {{ old('anak.'.$anak_item->id.'.status_hidup', $anak_item->status_hidup) == 'hidup' ? 'selected' : '' }}>Hidup</option>
                                            <option value="meninggal" {{ old('anak.'.$anak_item->id.'.status_hidup', $anak_item->status_hidup) == 'meninggal' ? 'selected' : '' }}>Meninggal</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Status Anak</label>
                                        <select name="anak[{{ $anak_item->id }}][status_anak]" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                                            <option value="">-- Pilih --</option>
                                            <option value="kandung" {{ old('anak.'.$anak_item->id.'.status_anak', $anak_item->status_anak) == 'kandung' ? 'selected' : '' }}>Kandung</option>
                                            <option value="tiri" {{ old('anak.'.$anak_item->id.'.status_anak', $anak_item->status_anak) == 'tiri' ? 'selected' : '' }}>Tiri</option>
                                            <option value="angkat" {{ old('anak.'.$anak_item->id.'.status_anak', $anak_item->status_anak) == 'angkat' ? 'selected' : '' }}>Angkat</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Status Pernikahan Anak</label>
                                        <select name="anak[{{ $anak_item->id }}][status_pernikahan]" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                                            <option value="">-- Pilih --</option>
                                            <option value="belum menikah" {{ old('anak.'.$anak_item->id.'.status_pernikahan', $anak_item->status_pernikahan) == 'belum menikah' ? 'selected' : '' }}>Belum Menikah</option>
                                            <option value="menikah" {{ old('anak.'.$anak_item->id.'.status_pernikahan', $anak_item->status_pernikahan) == 'menikah' ? 'selected' : '' }}>Menikah</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Status Tanggungan</label>
                                        <select name="anak[{{ $anak_item->id }}][status_tanggungan]" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                                            <option value="1" {{ (old('anak.'.$anak_item->id.'.status_tanggungan', $anak_item->status_tanggungan) ?? "1") == "1" ? 'selected' : '' }}>Ya</option>
                                            <option value="0" {{ (old('anak.'.$anak_item->id.'.status_tanggungan', $anak_item->status_tanggungan) ?? "1") == "0" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div id="new_children_forms_container" class="mt-4"></div>

                <div id="anak_button_section" style="display: none;" class="my-6">
                    <button type="button" onclick="addNewChildForm()"
                            class="inline-flex items-center px-4 py-2 rounded-md bg-green-600 text-white hover:bg-green-700 transition-colors">
                        <span class="mr-2">+</span> Tambah Data Anak
                    </button>
                </div>

                <div class="mt-10 flex justify-end space-x-4">
                    <a href="{{ route('view-profile-keluarga') }}" {{-- Sesuaikan rute ini --}}
                       class="inline-block px-6 py-2 rounded-md bg-gray-300 dark:bg-gray-600 text-gray-200 hover:bg-gray-400 dark:hover:bg-gray-500 transition">
                        Batal
                    </a>
                    <button type="submit" id="submit-btn"
                            class="inline-block px-6 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700 transition disabled:opacity-50 disabled:cursor-not-allowed">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let newChildTempCounter = 0; 
        let newChildrenFormDomIds = []; 

        function updateNewChildFormTitles() {
            newChildrenFormDomIds.forEach((domId, index) => {
                const formElement = document.getElementById(domId);
                if (formElement) {
                    const titleElement = formElement.querySelector('h3.new-child-title'); 
                    if (titleElement) titleElement.textContent = `Data Anak Baru ke-${index + 1}`;
                }
            });
        }
        
        function enableStatusPernikahan() {
            const statusRadios = document.querySelectorAll('input[name="status_pernikahan"]');
            statusRadios.forEach(radio => {
                radio.disabled = false;
            });
        }

        function hideAllSections() {
            const sections = ['no_kk_section', 'pasangan_section', 'orangtua_section', 'anak_button_section'];
            sections.forEach(sectionId => {
                const sectionElement = document.getElementById(sectionId);
                if (sectionElement) {
                    sectionElement.style.display = 'none';
                    const fieldsInSec = sectionElement.querySelectorAll('input:not([type="hidden"]), select, textarea');
                    fieldsInSec.forEach(field => field.disabled = true);
                }
            });
        }

        function enableFields(fieldIds) {
            fieldIds.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (field) field.disabled = false;
            });
        }

        function toggleMarriageFields() {
            const statusPernikahan = document.querySelector('input[name="status_pernikahan"]:checked')?.value;
            const noKkSection = document.getElementById('no_kk_section');
            const pasanganSection = document.getElementById('pasangan_section');
            const orangtuaSection = document.getElementById('orangtua_section');
            const anakButtonSection = document.getElementById('anak_button_section');
            const submitBtn = document.getElementById('submit-btn');

            hideAllSections(); 

            if (statusPernikahan) {
                noKkSection.style.display = 'block';
                enableFields(['no_kk']);

                orangtuaSection.style.display = 'block';
                enableFields(['nama_ayah', 'no_telp_ayah', 'status_bekerja_ayah', 'status_ayah',
                    'nama_ibu', 'no_telp_ibu', 'status_bekerja_ibu', 'status_ibu', 'alamat_ortu'
                ]);

                anakButtonSection.style.display = 'block'; 

                if (statusPernikahan === 'menikah') {
                    pasanganSection.style.display = 'block';
                    enableFields(['nama_pasangan', 'nik_pasangan', 'gender_pasangan', 'agama_pasangan',
                        'no_telp_pasangan', 'pendidikan_terakhir_pasangan', 'status_bekerja_pasangan', 'status_pasangan'
                    ]);
                }
                submitBtn.disabled = false;
            } else {
                submitBtn.disabled = true;
            }
        }

        function removeChildForm(containerDomId, isExistingChild = false, childDatabaseId = null) {
            if (confirm('Anda yakin ingin menghapus data anak ini? Jika data sudah tersimpan, anak ini akan dihapus dari database setelah Anda menyimpan perubahan form utama.')) {
                const childFormContainer = document.getElementById(containerDomId);
                if (childFormContainer) {
                    if (isExistingChild && childDatabaseId !== null) {
                        let deleteFlagInput = childFormContainer.querySelector('input[name="anak[' + childDatabaseId + '][_delete]"]');
                        if (!deleteFlagInput) { 
                            deleteFlagInput = document.createElement('input');
                            deleteFlagInput.type = 'hidden';
                            deleteFlagInput.name = `anak[${childDatabaseId}][_delete]`;
                            childFormContainer.appendChild(deleteFlagInput);
                        }
                        deleteFlagInput.value = '1'; 
                        
                        childFormContainer.style.display = 'none'; 
                        
                        const fieldsToDisable = childFormContainer.querySelectorAll('input:not([type="hidden"]), select, textarea');
                        fieldsToDisable.forEach(field => field.disabled = true);

                    } else {
                        childFormContainer.remove();
                        const index = newChildrenFormDomIds.indexOf(containerDomId);
                        if (index > -1) {
                            newChildrenFormDomIds.splice(index, 1);
                        }
                        updateNewChildFormTitles(); 
                    }
                }
            }
        }

        function addNewChildForm() {
            newChildTempCounter++;
            const tempKey = `new_${newChildTempCounter}`; 
            const newFormDomId = `child-form-new-${tempKey}`;

            const container = document.getElementById('new_children_forms_container');
            const childFormDiv = document.createElement('div');
            childFormDiv.className = 'mb-8 p-6 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 relative new-child-instance'; 
            childFormDiv.id = newFormDomId;

            childFormDiv.innerHTML = getChildFormTemplateForNew(tempKey);
            container.appendChild(childFormDiv);

            newChildrenFormDomIds.push(newFormDomId);
            updateNewChildFormTitles();
        }

        function getChildFormTemplateForNew(tempKey) {
            return `
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-3 new-child-title">Data Anak Baru</h3>
                    <button type="button" onclick="removeChildForm('child-form-new-${tempKey}', false, null)"
                            class="text-red-600 hover:text-red-800 font-semibold">✕ Hapus Anak Baru</button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Nama Anak</label>
                        <input type="text" name="anak[${tempKey}][nama]" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">NIK</label>
                        <input type="text" name="anak[${tempKey}][nik]" maxlength="16" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Tempat Lahir</label>
                        <input type="text" name="anak[${tempKey}][tempat_lahir]" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Tanggal Lahir</label>
                        <input type="date" name="anak[${tempKey}][tgl_lahir]" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Jenis Kelamin</label>
                        <select name="anak[${tempKey}][gender]" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                            <option value="">-- Pilih --</option>
                            <option value="laki-laki">Laki-laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Status Bekerja</label>
                        <select name="anak[${tempKey}][status_bekerja]" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                            <option value="">-- Pilih --</option>
                            <option value="bekerja">Bekerja</option>
                            <option value="tidak bekerja">Tidak Bekerja</option>
                            <option value="pelajar">Pelajar</option>
                        </select>
                    </div>
                     <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Status Hidup</label>
                        <select name="anak[${tempKey}][status_hidup]" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                            <option value="">-- Pilih --</option>
                            <option value="hidup" selected>Hidup</option>
                            <option value="meninggal">Meninggal</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Status Anak</label>
                        <select name="anak[${tempKey}][status_anak]" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                            <option value="">-- Pilih --</option>
                            <option value="kandung" selected>Kandung</option>
                            <option value="tiri">Tiri</option>
                            <option value="angkat">Angkat</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Status Pernikahan Anak</label>
                        <select name="anak[${tempKey}][status_pernikahan]" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                            <option value="">-- Pilih --</option>
                            <option value="belum menikah" selected>Belum Menikah</option>
                            <option value="menikah">Menikah</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Status Tanggungan</label>
                        <select name="anak[${tempKey}][status_tanggungan]" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                            <option value="1" selected>Ya</option>
                            <option value="0">Tidak</option>
                        </select>
                    </div>
                </div>
            `;
        }

        document.addEventListener('DOMContentLoaded', function() {
            enableStatusPernikahan(); 
            toggleMarriageFields();   
            updateNewChildFormTitles(); 
        });
    </script>
</x-app-layout>