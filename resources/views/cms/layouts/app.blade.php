<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Laravel'))</title>
        <link rel="icon" href="{{ asset('images/nata-logo-rounded.png') }}" type="image/jpeg"">

        <!-- Fonts -->
        {{-- <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> --}}
        <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
        />
        
        @vite(['resources/css/app.css'])
        <!-- Scripts -->
        <link rel="stylesheet" href="{{asset('assets/css/tailwind.output.css')}}" />
        <script
        src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"
        defer
        ></script>
        <script src="{{asset('assets/js/init-alpine.js')}}"></script>
        <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css"
        />
        <script
        src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"
        defer
        ></script>
        <script src="{{asset('assets/js/charts-lines.js')}}" defer></script>
        <script src="{{asset('assets/js/charts-pie.js')}}" defer></script>
    </head>
    <body>
      
        <div
      class="flex h-screen bg-gray-50 dark:bg-gray-900"
      :class="{ 'overflow-hidden': isSideMenuOpen }"
    >
      <!-- Desktop sidebar -->
        @include('cms.partials.sidebar')
      <!-- Mobile sidebar -->

      <div class="flex flex-col flex-1 w-full">
        @include('cms.partials.navbar')

        <main class="h-full overflow-y-auto">
            {{$slot}}
        </main>

      </div>
    </div>
    </body>
</html>
