<x-guest-layout>
    @section('title', 'Lupa Password - SIM')

    @if (session('status'))
        <x-alert type="success" :message="session('status')" :duration="3000" />
    @endif

    <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
        <div class="flex flex-col overflow-y-auto md:flex-row">
            <div class="h-32 md:h-auto md:w-1/2">
                <img aria-hidden="true" class="object-cover w-full h-full block dark:hidden"
                    src="{{ asset('images/hero1.png') }}" alt="Office" />
                <img aria-hidden="true" class="hidden object-cover w-full h-full dark:block"
                    src="{{ asset('images/dark-theme.jpg') }}" alt="Office" />
            </div>
            <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
                <div class="w-full">
                    <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
                        Lupa password
                    </h1>
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">NIP atau Email</span>
                            <input name="nip_or_email" type="text" value="{{ old('nip_or_email') }}"
                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                placeholder="Masukkan NIP atau Email Anda" />
                            <x-input-error :messages="$errors->get('nip_or_email')" class="mt-2" />
                        </label>

                        <button type="submit"
                            class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-purple">
                            Kirim Email Verifikasi
                        </button>

                        <p class="mt-4">
                            <a class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline"
                                href="{{ route('login') }}">
                                Kembali Login
                            </a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
