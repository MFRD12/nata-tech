<x-guest-layout>
    @section('title', 'Login - SIM NATA')
    <!-- Session Status -->
    {{-- <x-auth-session-status class="mb-4" :status="session('status')" />
  </form> --}}

    @if (session('status'))
        <x-alert type="success" :message="session('status')" :duration="3000" />
    @endif
    <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800 my-6">
        <div class="flex flex-col overflow-y-auto md:flex-row">
            <div class="h-32 md:h-auto md:w-1/2">
                {{-- Theme light img --}}
                <img aria-hidden="true" class="object-cover w-full h-full block dark:hidden"
                    src="{{ asset('images/hero1.png') }}" alt="Office" />
                {{-- Theme dark img --}}
                <img aria-hidden="true" class="hidden object-cover w-full h-full dark:block"
                    src="{{ asset('images/dark-theme.jpg') }}" alt="Office" />
            </div>
            <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
                <div class="w-full">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Logo"
                        class="w-24 h-auto mb-4 mx-auto rounded-full" />
                    <h1 class="text-center text-xl font-semibold text-gray-700 dark:text-gray-200">
                        Silahkan Masuk
                    </h1>
                    <h1 class="mb-4 text-center text-sm text-gray-700 dark:text-gray-200">
                        Sistem Informasi Menajemen
                    </h1>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">NIP atau Email</span>
                            <input name="nip_or_email" type="text"
                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-purple text-gray-800 dark:text-white dark:focus:shadow-outline-gray form-input"
                                value="{{ old('email') }}" placeholder="Masukkan NIP atau Email" />
                            <x-input-error :messages="$errors->get('nip_or_email')" class="mt-2" />
                        </label>
                        <label class="block mt-4 text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Password</span>
                            <input name="password"
                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-purple text-gray-800 dark:text-white dark:focus:shadow-outline-gray form-input"
                                placeholder="***************" type="password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </label>

                        <label class="inline-flex items-center mt-4 text-sm text-gray-700 dark:text-gray-400">
                            <input type="checkbox" name="remember" class="form-checkbox" />
                            <span class="ml-2">Ingat Saya</span>
                        </label>

                        <button type="submit"
                            class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-purple"">
                            Masuk
                        </button>
                    </form>

                    <p class=" mt-4">
                        <a class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline"
                            href="{{ Route('password.request') }}">
                            Lupa Password?
                        </a>
                    </p>
                    <p class="mt-1">
                        {{-- <a class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline"
                  href="register">
                  Buat Akun
                </a> --}}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        localStorage.removeItem('openMenu');
        localStorage.removeItem('openMenuKepegawaian');
        localStorage.removeItem('openMenuKeuangan');
        localStorage.removeItem('openMenuPengaturan');
    </script>
</x-guest-layout>
