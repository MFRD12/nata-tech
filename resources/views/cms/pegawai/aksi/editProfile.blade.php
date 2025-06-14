<x-app-layout>
    @section('title', 'Edit Profil Saya')
    <div class="min-h-screen bg-white dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto bg-white dark:bg-gray-800 rounded-xl shadow-md p-8">
            <h2 class="text-3xl font-semibold text-gray-800 dark:text-white mb-8">Edit Profil Saya</h2>

            <form action="{{ route('update-profile') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Form Field --}}
                    @php
                        $fields = [
                            ['foto', 'Foto', 'file'],
                            ['nama', 'Nama', 'text'],
                            ['tempat_lahir', 'Tempat Lahir', 'text'],
                            ['tgl_lahir', 'Tanggal Lahir', 'date'],
                            ['gender', 'Jenis Kelamin', 'select', ['laki-laki', 'perempuan']],
                            ['no_hp', 'No. HP', 'text'],
                            ['alamat', 'Alamat', 'textarea'],
                        ];
                    @endphp

                    @foreach ($fields as $field)
                        <div class="{{ $field[0] === 'alamat' || $field[0] === 'foto' ? 'md:col-span-2' : '' }}">
                            <label for="{{ $field[0] }}"
                                class="block text-sm font-medium text-gray-800 dark:text-gray-200 mb-1">{{ $field[1] }}</label>

                            @if ($field[0] === 'foto')
                                <div class="mb-2">
                                    <img id="preview-foto"
                                        src="{{ $pegawai->foto ? asset('storage/' . $pegawai->foto) : '' }}"
                                        alt="Preview Foto Pegawai"
                                        class="w-[151px] h-[227px] object-cover {{ $pegawai->foto ? '' : 'hidden' }}">

                                </div>
                                <input type="file" name="foto" id="foto" onchange="previewFoto(event)"
                                    class="w-full px-3 py-2 rounded-md border bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                            @elseif ($field[2] === 'select')
                                <select name="{{ $field[0] }}" id="{{ $field[0] }}"
                                    class="w-full px-3 py-2 rounded-md border bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200"
                                    required>
                                    <option value="">-- Pilih --</option>
                                    @foreach ($field[3] as $option)
                                        <option value="{{ $option }}"
                                            {{ old($field[0], $pegawai->{$field[0]}) == $option ? 'selected' : '' }}>
                                            {{ ucfirst($option) }}
                                        </option>
                                    @endforeach
                                </select>
                            @elseif($field[2] === 'textarea')
                                <textarea name="{{ $field[0] }}" id="{{ $field[0] }}" rows="3"
                                    class="w-full px-3 py-2 rounded-md border bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200" required>{{ old($field[0], $pegawai->{$field[0]}) }}</textarea>
                            @else
                                <input type="{{ $field[2] }}" name="{{ $field[0] }}" id="{{ $field[0] }}"
                                    value="{{ old($field[0], $pegawai->{$field[0]}) }}"
                                    class="w-full px-3 py-2 rounded-md border bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200"
                                    required>
                            @endif
                        </div>
                    @endforeach
                </div>

                {{-- Tombol --}}
                <div class="mt-10 flex justify-end space-x-4">
                    <a href="{{ route('view-profile') }}"
                        class="inline-block px-6 py-2 rounded-md bg-red-600 text-white hover:bg-red-400 dark:hover:bg-red-500">
                        <i class="fas fa-xmark"></i> Batal
                    </a>
                    <button type="submit"
                        class="inline-block px-6 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Script preview foto --}}
    <script>
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
