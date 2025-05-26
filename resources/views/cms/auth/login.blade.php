<x-guest-layout>
  @section('title', 'Login - SIM')
  <!-- Session Status -->
  {{-- <x-auth-session-status class="mb-4" :status="session('status')" />

  <form method="POST" action="{{ route('login') }}">
    @csrf

    <!-- Email Address -->
    <div>
      <x-input-label for="email" :value="__('Email')" />
      <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
        autofocus autocomplete="username" />
      <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <!-- Password -->
    <div class="mt-4">
      <x-input-label for="password" :value="__('Password')" />

      <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
        autocomplete="current-password" />

      <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <!-- Remember Me -->
    <div class="block mt-4">
      <label for="remember_me" class="inline-flex items-center">
        <input id="remember_me" type="checkbox"
          class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
      </label>
    </div>

    <div class="flex items-center justify-end mt-4">
      @if (Route::has('password.request'))
      <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        href="{{ route('password.request') }}">
        {{ __('Forgot your password?') }}
      </a>
      @endif

      <x-primary-button class="ms-3">
        {{ __('Log in') }}
      </x-primary-button>
    </div>
  </form> --}}

  <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
    <div class="flex flex-col overflow-y-auto md:flex-row">
      <div class="h-32 md:h-auto md:w-1/2">
        {{-- Theme light img --}}
        <img aria-hidden="true" class="object-cover w-full h-full dark:hidden" src="{{asset('images/hero1.png')}}"
          alt="Office" />
        {{-- Theme dark img --}}
        <img aria-hidden="true" class="hidden object-cover w-full h-full dark:block" src="{{asset('images/hero1.png')}}"
          alt="Office" />
      </div>
      <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
        <div class="w-full">
          <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="w-24 h-auto mb-4 mx-auto rounded-full" />
          <h1 class="text-center text-xl font-semibold text-gray-700 dark:text-gray-200">
            Silahkan Masuk
          </h1>
          <h1 class="mb-4 text-center text-sm text-gray-700 dark:text-gray-200">
            Sistem Informasi Menajemen
          </h1>
          <form method="post" action="{{ route('login') }}">
            @csrf
            <label class="block text-sm">
              <span class="text-gray-700 dark:text-gray-400">Email</span>
              <input name="email" type="email"
                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                value="{{ old('email') }}" placeholder="example@nata.com"/>
                @error('email')
                    <div class="text-red-500 mt-1 text-sm">{{$message}}</div>
                @enderror
            </label>
            <label class="block mt-4 text-sm">
              <span class="text-gray-700 dark:text-gray-400">Password</span>
              <input name="password"
                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                placeholder="***************" type="password"/>
                @error('password')
                    <div class="text-red-500 mt-1 text-sm">{{$message}}</div>
                @enderror
            </label>

            <button type="submit"
              class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-purple"">
                Masuk
            </button>
            </form>

              <p class=" mt-4">
              <a class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline"
                href="{{Route('password.request')}}">
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