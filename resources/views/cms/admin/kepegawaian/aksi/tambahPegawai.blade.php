<x-app-layout>
    @section('title', 'Tambah Pegawai')

    <div class="min-h-screen bg-white dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto bg-white dark:bg-gray-800 rounded-xl shadow-md p-8">
            <h2 class="text-3xl font-semibold text-gray-800 dark:text-white mb-8">Tambah Data Pegawai</h2>

            <form action="{{ route('tambah-pegawai') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- NIP -->
                    <div class="col-span-1 md:col-span-2">
                        <label for="nip_pegawai"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">NIP</label>
                        <select id="nip_pegawai" name="nip_pegawai" required onchange="enableForm()"
                            class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            <option value="">-- Pilih NIP --</option>
                            @foreach ($availableNips as $nip)
                                <option value="{{ $nip }}">{{ $nip }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Fields -->
                    @php
                        $fields = [
                            ['foto', 'Foto', 'file'],
                            ['nama', 'Nama', 'text'],
                            ['tempat_lahir', 'Tempat Lahir', 'text'],
                            ['tgl_lahir', 'Tanggal Lahir', 'date'],
                            ['gender', 'Jenis Kelamin', 'select', ['laki-laki', 'perempuan']],
                            ['no_hp', 'No. HP', 'text'],
                            ['alamat', 'Alamat', 'textarea'],
                            ['tgl_masuk', 'Tanggal Masuk', 'date'],
                            ['jabatan_id', 'Jabatan', 'relation', $jabatans],
                            ['divisi_id', 'Divisi', 'relation', $divisi],
                            ['status', 'Status', 'select', ['aktif', 'tidak aktif']],
                        ];
                    @endphp

                    @foreach ($fields as $field)
                        <div class="{{ $field[0] === 'alamat' || $field[0] === 'foto' ? 'md:col-span-2' : '' }}">
                            <label for="{{ $field[0] }}"
                                class="block text-sm font-medium text-gray-800 dark:text-gray-200 mb-1">
                                {{ $field[1] }}
                            </label>

                            @if ($field[0] === 'foto')
                                <div class="mb-2">
                                    <img id="preview-foto" src="" alt="Preview Foto"
                                        class="w-[151px] h-[227px] object-cover hidden">
                                </div>
                                <input type="{{ $field[2] }}" name="{{ $field[0] }}" id="{{ $field[0] }}"
                                    onchange="previewFoto(event)"
                                    class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200"
                                    disabled>
                            @elseif ($field[2] === 'select')
                                <select name="{{ $field[0] }}" id="{{ $field[0] }}"
                                    class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200"
                                    disabled>
                                    <option value="">-- Pilih --</option>
                                    @foreach ($field[3] as $option)
                                        <option value="{{ $option }}">{{ ucfirst($option) }}</option>
                                    @endforeach
                                </select>
                            @elseif ($field[2] === 'relation')
                                <select name="{{ $field[0] }}" id="{{ $field[0] }}" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200" disabled>
                                    <option value="">-- Pilih {{ $field[1] }} --</option>
                                    @foreach ($field[3] as $option)
                                        <option value="{{ $option->id }}">{{ $option->name }}</option>
                                    @endforeach
                                </select>
                            @elseif ($field[2] === 'textarea')
                                <textarea name="{{ $field[0] }}" id="{{ $field[0] }}" rows="3"
                                    class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200"
                                    @if ($field[0] === 'nama' || $field[0] === 'tgl_masuk') required @endif disabled></textarea>
                            @else
                                <input type="{{ $field[2] }}" name="{{ $field[0] }}" id="{{ $field[0] }}"
                                    class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200"
                                    @if ($field[0] === 'no_hp') maxlength="13" @endif
                                    @if ($field[0] === 'nama' || $field[0] === 'tgl_masuk') required @endif disabled>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Tombol -->
                <div class="mt-10 flex justify-end space-x-4">
                    <a href="{{ route('view-pegawai') }}"
                        class="inline-block px-6 py-2 rounded-md bg-red-600 text-white hover:bg-red-400 dark:hover:bg-red-500 transition">
                        <i class="fas fa-xmark"></i> Batal
                    </a>
                    <button type="submit" id="submit-btn" disabled
                        class="inline-block px-6 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700 transition disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- aktifkan form dan preview foto -->
    <script>
        function enableForm() {
            const selected = document.getElementById('nip_pegawai').value;
            const inputs = document.querySelectorAll('input, select, textarea');
            const submitBtn = document.getElementById('submit-btn');

            inputs.forEach(el => {
                if (el.id !== 'nip_pegawai') {
                    el.disabled = !selected;
                }
            });

            submitBtn.disabled = !selected;
        }

        function previewFoto(event) {
            const input = event.target;
            const preview = document.getElementById('preview-foto');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>
