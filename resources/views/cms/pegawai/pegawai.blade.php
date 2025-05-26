<x-app-layout>
{{-- <div x-data="{ isModalOpen: false, modalType: null, openModaledit() { this.modalType = 'edit'; this.isModalOpen = true }, openModalhapus() { this.modalType = 'hapus'; this.isModalOpen = true }, closeModal() { this.isModalOpen = false; this.modalType = null } }">

  <!-- Tombol -->
  <button @click="openModaledit"
    class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-yellow-600 border border-transparent rounded-lg active:bg-yellow-700 hover:bg-yellow-700 focus:outline-none focus:shadow-outline-yellow">
    Open edit
  </button>
  <button @click="openModalhapus"
    class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg active:bg-red-700 hover:bg-red-700 focus:outline-none focus:shadow-outline-red">
    Open hapus
  </button>

  <!-- Modal -->
  <div x-show="isModalOpen"
    x-transition:enter="transition ease-out duration-150"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center">

    <div x-show="isModalOpen"
      x-transition:enter="transition ease-out duration-150"
      x-transition:enter-start="opacity-0 transform translate-y-1/2"
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition ease-in duration-150"
      x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0 transform translate-y-1/2"
      @click.away="closeModal" @keydown.escape="closeModal"
      class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl"
      role="dialog" id="modal">

      <!-- Header -->
      <header class="flex justify-end">
        <button @click="closeModal"
          class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover:text-gray-700"
          aria-label="close">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
            <path
              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
              clip-rule="evenodd" fill-rule="evenodd"></path>
          </svg>
        </button>
      </header>

      <!-- Body -->
      <div class="mt-4 mb-6">
        <template x-if="modalType === 'edit'">
          <div>
            <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">Edit Data</p>
            <p class="text-sm text-gray-700 dark:text-gray-400">
              Anda akan mengedit data ini. Pastikan perubahan sudah benar.
            </p>
          </div>
        </template>

        <template x-if="modalType === 'hapus'">
          <div>
            <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">Hapus Data</p>
            <p class="text-sm text-gray-700 dark:text-gray-400">
              Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.
            </p>
          </div>
        </template>
      </div>

      <!-- Footer -->
      <footer
        class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
        <button @click="closeModal"
          class="w-full px-5 py-3 text-sm font-medium text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto hover:border-gray-500 focus:outline-none focus:shadow-outline-gray">
          Batal
        </button>
        <button
          class="w-full px-5 py-3 text-sm font-medium text-white transition-colors duration-150"
          :class="modalType === 'edit' ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-red-600 hover:bg-red-700'"
          @click="closeModal"
          >
          <span x-text="modalType === 'edit' ? 'Simpan Perubahan' : 'Hapus'"></span>
        </button>
      </footer>

    </div>
  </div>
</div> --}}
</x-app-layout>