<nav x-data="{ scrolled: false, open: false }" x-init="window.addEventListener('scroll', () => { scrolled = window.pageYOffset > 30; if(scrolled) { document.body.style.paddingTop = '56px'; } else { document.body.style.paddingTop = '0px'; } })" :class="{ 'bg-white shadow-md': !scrolled, 'bg-white shadow-lg fixed top-0 left-0 right-0 z-50 transition-all duration-300 transform': scrolled }" class="w-full transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-20"> {{-- Increased horizontal padding for wider screens --}}
        <div class="flex justify-between transition-all duration-300" :class="{ 'h-16': !scrolled, 'h-10': scrolled }">
            <div class="flex">
                <div class="flex-shrink-0 flex items-center transition-all duration-300" :class="{ 'h-16': !scrolled, 'h-10': scrolled }"> {{-- Dynamic height based on scroll --}}
                    {{-- Replace with actual SVG logo if available --}}
                    <img :class="{ 'h-12': !scrolled, 'h-8': scrolled }" class="w-auto transition-all duration-300" src="{{ asset('images\nata-logo.png') }}" alt="nata-tech-logo"> {{-- Logo with dynamic size --}}
                </div>
            </div>
            <div class="hidden sm:ml-10 sm:flex sm:space-x-8 transition-all duration-300">
                <a href="{{ url('/') }}" :class="{ 'text-base': !scrolled, 'text-sm': scrolled }" class="text-[#3E4FB0] inline-flex items-center px-1 pt-1 font-bold hover:text-[#3E4FB0] hover:scale-105 hover:[text-shadow:0_0_8px_rgba(191,219,254,0.8)] transition-all duration-300">Beranda</a>
                <a href="{{ url('/about') }}" :class="{ 'text-base': !scrolled, 'text-sm': scrolled }" class="text-[#3E4FB0] inline-flex items-center px-1 pt-1 font-bold hover:text-[#3E4FB0] hover:scale-105 hover:[text-shadow:0_0_8px_rgba(191,219,254,0.8)] transition-all duration-300">Tentang Kami</a>
                <a href="{{ url('/product') }}" :class="{ 'text-base': !scrolled, 'text-sm': scrolled }" class="text-[#3E4FB0] inline-flex items-center px-1 pt-1 font-bold hover:text-[#3E4FB0] hover:scale-105 hover:[text-shadow:0_0_8px_rgba(191,219,254,0.8)] transition-all duration-300">Produk</a>
                <a href="{{ url('/insight') }}" :class="{ 'text-base': !scrolled, 'text-sm': scrolled }" class="text-[#3E4FB0] inline-flex items-center px-1 pt-1 font-bold hover:text-[#3E4FB0] hover:scale-105 hover:[text-shadow:0_0_8px_rgba(191,219,254,0.8)] transition-all duration-300">Insight</a>
                <a href="{{ url('/contact') }}" :class="{ 'text-base': !scrolled, 'text-sm': scrolled }" class="text-[#3E4FB0] inline-flex items-center px-1 pt-1 font-bold hover:text-[#3E4FB0] hover:scale-105 hover:[text-shadow:0_0_8px_rgba(191,219,254,0.8)] transition-all duration-300">Kontak</a>
            </div>
            {{-- Mobile Menu Button --}}
            <div class="-mr-2 flex items-center sm:hidden">
                <button type="button" class="bg-white inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 dark:bg-gray-800 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700" aria-controls="mobile-menu" aria-expanded="false" @click="open = !open"> {{-- Using parent Alpine.js context --}}
                    <span class="sr-only">Open main menu</span>
                    <!-- Icon when menu is closed. -->
                    <svg x-show="!open" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                    <!-- Icon when menu is open. -->
                    <svg x-show="open" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile menu, show/hide based on menu state (using Alpine.js) --}}
    <div class="sm:hidden" id="mobile-menu" x-show="open" @click.away="open = false"> {{-- Added Alpine.js show/hide --}}
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ url('/') }}" class="bg-white border-l-4 border-[#3E4FB0] text-[#3E4FB0] block pl-3 pr-4 py-2 text-base font-medium">Beranda</a>
            <a href="{{ url('/tentang-kami') }}" class="border-transparent text-[#3E4FB0] hover:bg-gray-50 hover:border-[#3E4FB0] hover:text-[#3E4FB0] hover:[text-shadow:0_0_8px_rgba(191,219,254,0.8)] block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-all duration-300">Tentang Kami</a>
            <a href="{{ url('/produk') }}" class="border-transparent text-[#3E4FB0] hover:bg-gray-50 hover:border-[#3E4FB0] hover:text-[#3E4FB0] hover:[text-shadow:0_0_8px_rgba(191,219,254,0.8)] block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-all duration-300">Produk</a>
            <a href="{{ url('/insight') }}" class="border-transparent text-[#3E4FB0] hover:bg-gray-50 hover:border-[#3E4FB0] hover:text-[#3E4FB0] hover:[text-shadow:0_0_8px_rgba(191,219,254,0.8)] block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-all duration-300">Insight</a>
            <a href="{{ url('/kontak') }}" class="border-transparent text-[#3E4FB0] hover:bg-gray-50 hover:border-[#3E4FB0] hover:text-[#3E4FB0] hover:[text-shadow:0_0_8px_rgba(191,219,254,0.8)] block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-all duration-300">Kontak</a>
        </div>
    </div>
</nav>
