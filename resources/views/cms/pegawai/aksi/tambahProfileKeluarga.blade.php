<x-app-layout>
    @section('title', 'Tambah Data Keluarga')
    <div class="min-h-screen bg-white dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto bg-white dark:bg-gray-800 rounded-xl shadow-md p-8">
            <h2 class="text-3xl font-semibold text-gray-800 dark:text-white mb-8">Tambah Data Keluarga</h2>

            @if (session('error'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 7000)" x-show="show" x-transition
                    class="mb-4 px-4 py-3 rounded-md bg-red-100 border border-red-400 text-red-700" role="alert">
                    <p class="font-bold">Terjadi Kesalahan!</p>
                    <p class="text-sm">{{ session('error') }}</p>
                </div>
            @endif

            <form id="keluargaForm" action="{{ route('tambah-profile-keluarga') }}" method="POST">
                @csrf
                <div class="mb-8">
                    <label for="pegawai_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
                        Nama Pegawai
                    </label>
                    <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                    <input type="text" value="{{ $pegawai->nama }}" disabled
                        class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200 cursor-not-allowed">
                </div>

                <!-- Status Pernikahan -->
                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-3">
                        Status Pernikahan
                    </label>
                    <div class="flex space-x-6">
                        <label class="flex items-center">
                            <input type="radio" name="status_pernikahan" value="belum menikah"
                                onchange="toggleMarriageFields()"
                                class="text-blue-600 focus:ring-blue-500 disabled:opacity-50">
                            <span class="ml-2 text-gray-700 dark:text-gray-200">Belum Menikah</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="status_pernikahan" value="menikah"
                                onchange="toggleMarriageFields()"
                                class="text-blue-600 focus:ring-blue-500 disabled:opacity-50">
                            <span class="ml-2 text-gray-700 dark:text-gray-200">Menikah</span>
                        </label>
                    </div>
                </div>

                <!-- No KK -->
                <div class="mb-6" id="no_kk_section" style="display: none;">
                    <label for="no_kk" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                        No. Kartu Keluarga
                    </label>
                    <input type="text" name="no_kk" id="no_kk" maxlength="16 value"
                        class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required
                        disabled>
                </div>

                <!-- Data Pasangan -->
                <div id="pasangan_section" style="display: none;" class="mb-8">
                    <h3
                        class="text-xl font-semibold text-gray-800 dark:text-white mb-4 border-b border-gray-200 dark:border-gray-600 pb-2">
                        Data Pasangan
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nama_pasangan"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                Nama Pasangan
                            </label>
                            <input type="text" name="nama_pasangan" id="nama_pasangan"
                                class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required
                                disabled>
                        </div>
                        <div>
                            <label for="nik_pasangan"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                NIK Pasangan
                            </label>
                            <input type="text" name="nik_pasangan" id="nik_pasangan" maxlength="16"
                                class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required
                                disabled>
                        </div>
                        <div>
                            <label for="gender_pasangan"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                Jenis Kelamin
                            </label>
                            <select name="gender" id="gender_pasangan"
                                class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required
                                disabled>
                                <option value="">-- Pilih --</option>
                                <option value="laki-laki">Laki-laki</option>
                                <option value="perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label for="agama"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                Agama
                            </label>
                            <select name="agama" id="agama"
                                class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required
                                disabled>
                                <option value="">-- Pilih --</option>
                                <option value="Islam">Islam</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Buddha">Buddha</option>
                                <option value="Konghucu">Konghucu</option>
                            </select>
                        </div>
                        <div>
                            <label for="no_telp_pasangan"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                No. Telepon Pasangan
                            </label>
                            <input type="text" name="no_telp_pasangan" id="no_telp_pasangan" maxlength="14"
                                class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required
                                disabled>
                        </div>
                        <div>
                            <label for="pendidikan_terakhir"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                Pendidikan Terakhir
                            </label>
                            <select name="pendidikan_terakhir" id="pendidikan_terakhir"
                                class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required
                                disabled>
                                <option value="">-- Pilih --</option>
                                <option value="sd">SD</option>
                                <option value="smp">SMP</option>
                                <option value="sma">SMA</option>
                                <option value="s1">S1</option>
                                <option value="s2">S2</option>
                                <option value="s3">S3</option>
                            </select>
                        </div>
                        <div>
                            <label for="status_bekerja_pasangan"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                Status Bekerja
                            </label>
                            <select name="status_bekerja_pasangan" id="status_bekerja_pasangan"
                                class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required
                                disabled>
                                <option value="">-- Pilih --</option>
                                <option value="bekerja">Bekerja</option>
                                <option value="tidak bekerja">Tidak Bekerja</option>
                            </select>
                        </div>
                        <div>
                            <label for="status_pasangan"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                Status Pasangan
                            </label>
                            <select name="status_pasangan" id="status_pasangan"
                                class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required
                                disabled>
                                <option value="">-- Pilih --</option>
                                <option value="hidup">Hidup</option>
                                <option value="meninggal">Meninggal</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Data Orang Tua -->
                <div id="orangtua_section" style="display: none;" class="mb-8">
                    <h3
                        class="text-xl font-semibold text-gray-800 dark:text-white mb-4 border-b border-gray-200 dark:border-gray-600 pb-2">
                        Data Orang Tua
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Data Ayah -->
                        <div class="md:col-span-2">
                            <h4 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-3">Data Ayah</h4>
                        </div>
                        <div>
                            <label for="nama_ayah"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                Nama Ayah
                            </label>
                            <input type="text" name="nama_ayah" id="nama_ayah"
                                class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required
                                disabled>
                        </div>
                        <div>
                            <label for="no_telp_ayah"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                No. Telepon Ayah
                            </label>
                            <input type="text" name="no_telp_ayah" id="no_telp_ayah" maxlength="14"
                                class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required
                                disabled>
                        </div>
                        <div>
                            <label for="status_bekerja_ayah"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                Status Bekerja Ayah
                            </label>
                            <select name="status_bekerja_ayah" id="status_bekerja_ayah"
                                class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required
                                disabled>
                                <option value="">-- Pilih --</option>
                                <option value="bekerja">Bekerja</option>
                                <option value="tidak bekerja">Tidak Bekerja</option>
                            </select>
                        </div>
                        <div>
                            <label for="status_ayah"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                Status Ayah
                            </label>
                            <select name="status_ayah" id="status_ayah"
                                class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required
                                disabled>
                                <option value="">-- Pilih --</option>
                                <option value="hidup">Hidup</option>
                                <option value="meninggal">Meninggal</option>
                            </select>
                        </div>

                        <!-- Data Ibu -->
                        <div class="md:col-span-2 mt-6">
                            <h4 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-3">Data Ibu</h4>
                        </div>
                        <div>
                            <label for="nama_ibu"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                Nama Ibu
                            </label>
                            <input type="text" name="nama_ibu" id="nama_ibu"
                                class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required
                                disabled>
                        </div>
                        <div>
                            <label for="no_telp_ibu"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                No. Telepon Ibu
                            </label>
                            <input type="text" name="no_telp_ibu" id="no_telp_ibu" maxlength="14"
                                class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required
                                disabled>
                        </div>
                        <div>
                            <label for="status_bekerja_ibu"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                Status Bekerja Ibu
                            </label>
                            <select name="status_bekerja_ibu" id="status_bekerja_ibu"
                                class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required
                                disabled>
                                <option value="">-- Pilih --</option>
                                <option value="bekerja">Bekerja</option>
                                <option value="tidak bekerja">Tidak Bekerja</option>
                            </select>
                        </div>
                        <div>
                            <label for="status_ibu"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                Status Ibu
                            </label>
                            <select name="status_ibu" id="status_ibu"
                                class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required
                                disabled>
                                <option value="">-- Pilih --</option>
                                <option value="hidup">Hidup</option>
                                <option value="meninggal">Meninggal</option>
                            </select>
                        </div>

                        <!-- Alamat Orang Tua -->
                        <div class="md:col-span-2">
                            <label for="alamat_ortu"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                Alamat Orang Tua
                            </label>
                            <textarea name="alamat_ortu" id="alamat_ortu" rows="3"
                                class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                disabled></textarea>
                        </div>
                    </div>
                </div>


                <!-- Container untuk Form Anak -->
                <div id="children_container"></div>

                <!-- Tombol Tambah Anak -->
                <div id="anak_button_section" style="display: none;" class="mb-6">
                    <button type="button" onclick="addChildForm()"
                        class="inline-flex items-center px-4 py-2 rounded-md bg-green-600 text-white hover:bg-green-700 transition-colors">
                        <span class="mr-2">+</span> Tambah Data Anak
                    </button>
                </div>

                <!-- Tombol Submit -->
                <div class="mt-10 flex justify-end space-x-4">
                    <button type="submit" id="submit-btn" disabled
                        class="inline-block px-6 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700 transition disabled:opacity-50 disabled:cursor-not-allowed">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let childCounter = 0;
        let childrenForms = [];

        function enableStatusPernikahan() {
            const pegawaiSelect = document.getElementById('pegawai_id');
            const statusRadios = document.querySelectorAll('input[name="status_pernikahan"]');
            const selected = pegawaiSelect.value;

            statusRadios.forEach(radio => {
                radio.disabled = !selected;
            });

            if (!selected) {
                statusRadios.forEach(radio => radio.checked = false);
                hideAllSections();
            }
        }

        function toggleMarriageFields() {
            const statusPernikahan = document.querySelector('input[name="status_pernikahan"]:checked')?.value;
            const noKkSection = document.getElementById('no_kk_section');
            const pasanganSection = document.getElementById('pasangan_section');
            const orangtuaSection = document.getElementById('orangtua_section');
            const anakButtonSection = document.getElementById('anak_button_section');
            const submitBtn = document.getElementById('submit-btn');

            // Reset semua section
            hideAllSections();

            if (statusPernikahan) {
                // Tampilkan No KK
                noKkSection.style.display = 'block';
                enableFields(['no_kk']);

                // Tampilkan Data Orang Tua
                orangtuaSection.style.display = 'block';
                enableFields(['nama_ayah', 'no_telp_ayah', 'status_bekerja_ayah', 'status_ayah',
                    'nama_ibu', 'no_telp_ibu', 'status_bekerja_ibu', 'status_ibu', 'alamat_ortu'
                ]);

                // Tampilkan tombol tambah anak
                anakButtonSection.style.display = 'block';

                if (statusPernikahan === 'menikah') {
                    // Tampilkan Data Pasangan
                    pasanganSection.style.display = 'block';
                    enableFields(['nama_pasangan', 'nik_pasangan', 'gender_pasangan', 'agama',
                        'no_telp_pasangan', 'pendidikan_terakhir', 'status_bekerja_pasangan', 'status_pasangan'
                    ]);
                }

                submitBtn.disabled = false;
            } else {
                submitBtn.disabled = true;
            }
        }

        function hideAllSections() {
            const sections = ['no_kk_section', 'pasangan_section', 'orangtua_section', 'anak_button_section'];
            sections.forEach(sectionId => {
                document.getElementById(sectionId).style.display = 'none';
            });

            // Disable semua field
            const allInputs = document.querySelectorAll(
                'input:not([name="pegawai_id"]):not([name="status_pernikahan"]):not([name="_token"]), select:not(#pegawai_id), textarea'
            );
            allInputs.forEach(input => input.disabled = true);
        }

        function enableFields(fieldIds) {
            fieldIds.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (field) field.disabled = false;
            });
        }

        function addChildForm() {
            childCounter++;
            const container = document.getElementById('children_container');

            const newId = `child-form-${childCounter}`;
            childrenForms.push(newId);

            const childForm = document.createElement('div');
            childForm.className =
                'mb-8 p-6 border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700';
            childForm.id = newId;

            childForm.innerHTML = getChildFormTemplate(childCounter, newId);
            container.appendChild(childForm);
            updateChildFormTitles();
        }

        function removeChildForm(idNumber) {
            const formId = `child-form-${idNumber}`;
            const index = childrenForms.indexOf(formId);
            if (index > -1) {
                childrenForms.splice(index, 1);
                const childForm = document.getElementById(formId);
                if (childForm) childForm.remove();
                updateChildFormTitles();
            }
        }

        function updateChildFormTitles() {
            childrenForms.forEach((formId, index) => {
                const form = document.getElementById(formId);
                if (form) {
                    const title = form.querySelector('h3');
                    if (title) title.textContent = `Data Anak ke - ${index + 1}`;
                }
            });
        }

        function getChildFormTemplate(idNumber, formId) {
            return `
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Data Anak ke - ?</h3>
                <button type="button" onclick="removeChildForm(${idNumber})"
                        class="text-red-600 hover:text-red-800 font-semibold">✕ Hapus</button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Nama Anak</label>
                    <input type="text" name="anak[${idNumber}][nama]" 
                        class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">NIK</label>
                    <input type="text" name="anak[${idNumber}][nik]" maxlength="16"
                        class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Tempat Lahir</label>
                    <input type="text" name="anak[${idNumber}][tempat_lahir]"
                        class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Tanggal Lahir</label>
                    <input type="date" name="anak[${idNumber}][tgl_lahir]"
                        class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Jenis Kelamin</label>
                    <select name="anak[${idNumber}][gender]"
                        class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                        <option value="">-- Pilih --</option>
                        <option value="laki-laki">Laki-laki</option>
                        <option value="perempuan">Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Status Bekerja</label>
                    <select name="anak[${idNumber}][status_bekerja]"
                        class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                        <option value="">-- Pilih --</option>
                        <option value="bekerja">Bekerja</option>
                        <option value="tidak bekerja">Tidak Bekerja</option>
                        <option value="pelajar">Pelajar</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Status Hidup</label>
                    <select name="anak[${idNumber}][status_hidup]"
                        class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                        <option value="">-- Pilih --</option>
                        <option value="hidup" selected>Hidup</option>
                        <option value="meninggal">Meninggal</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Status Anak</label>
                    <select name="anak[${idNumber}][status_anak]"
                        class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                        <option value="">-- Pilih --</option>
                        <option value="kandung" selected>Kandung</option>
                        <option value="tiri">Tiri</option>
                        <option value="angkat">Angkat</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Status Pernikahan</label>
                    <select name="anak[${idNumber}][status_pernikahan]"
                        class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                        <option value="">-- Pilih --</option>
                        <option value="belum menikah" selected>Belum Menikah</option>
                        <option value="menikah">Menikah</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Status Tanggungan</label>
                    <select name="anak[${idNumber}][status_tanggungan]"
                        class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                        <option value="1" selected>Ya</option>
                        <option value="0">Tidak</option>
                    </select>
                </div>
            </div>
        `;
        }

        document.addEventListener('DOMContentLoaded', function() {
            hideAllSections();
        });
    </script>
</x-app-layout>
