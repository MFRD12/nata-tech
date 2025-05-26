@extends('compro.layouts.index')

@section('content')
    <main class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Tentang Nata Tech</h1>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">Kami adalah perusahaan teknologi yang berdedikasi
                    untuk memberikan solusi inovatif bagi kebutuhan digital Anda.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">Visi Kami</h2>
                    <p class="text-gray-600">“Menjadi mitra terpercaya dalam menyediakan solusi TI dengan tepat,
                        inovatif, dan berkelanjutan untuk mewujudkan transformasi digital yang memberikan nilai lebih
                        bagi customer dan stakeholder”</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">Misi Kami</h2>
                    <p class="text-gray-600">Menghadirkan solusi teknologi yang inovatif, efisien, dan berkelanjutan
                        untuk membantu klien kami mencapai kesuksesan dalam era digital.</p>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Menyediakan solusi TI yang tepat sasaran dan inovatif
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Menjalin kolaborasi jangka panjang
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Menyelenggarakan tata kelola organisasi yang sehat

                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Mengoptimalkan sumber daya perusahaan
                    </li>
                    </ul>
                </div>
            </div>


<section id="nilai-perusahaan" class="bg-white rounded-lg shadow-md p-8 mb-12">
    <h2 class="text-2xl font-semibold text-gray-900 mb-6 text-center">Nilai-Nilai Kami</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Networking Excellence --}}
        <div class="bg-white rounded-lg p-6 hover:shadow-lg transition duration-300">
            <div class="flex justify-center">
                <img src="{{ asset('images/nilai/n.png') }}" class="w-40 h-40" alt="Networking Excellence Icon">
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2 text-center">Networking Excellence</h3>
            <p class="text-gray-600 text-center">Kami membangun jaringan profesional dan kolaborasi yang
                kuat untuk mendukung kesuksesan bersama.</p>
        </div>
        {{-- //Agility in Solutions --}}
        <div class="bg-white rounded-lg p-6 hover:shadow-lg transition duration-300">
            <div class="flex justify-center">
                <img src="{{ asset('images/nilai/a.png') }}" class="w-40 h-40" alt="Networking Excellence Icon">
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2 text-center">Agility in Solutions</h3>
            <p class="text-gray-600 text-center">Menjunjung tinggi kejujuran dan profesionalisme dalam
                setiap tindakan.</p>
        </div>
        {{-- //Trust and Transparency --}}
        <div class="bg-white rounded-lg p-6 hover:shadow-lg transition duration-300">
            <div class="flex justify-center">
                <img src="{{ asset('images/nilai/t.png') }}" class="w-40 h-40" alt="Networking Excellence Icon">
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2 text-center">Trust and Transparency</h3>
            <p class="text-gray-600 text-center">Menjunjung tinggi kejujuran dan profesionalisme dalam
                setiap tindakan.</p>
        </div>
        {{-- //Achievement Value-Oriented --}}
        <div class="bg-white rounded-lg p-6 hover:shadow-lg transition duration-300">
            <div class="flex justify-center">
                <img src="{{ asset('images/nilai/a2.png') }}" class="w-40 h-40" alt="Networking Excellence Icon">
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2 text-center">Achievement Value-Oriented</h3>
            <p class="text-gray-600 text-center">Kami tidak hanya berfokus pada hasil semata, tetapi juga
                pada pencapaian kebermanfaatan dalam penggunaannya.</p>
        </div>
    </div>
</section>

<section id="tim-kami" class="bg-white rounded-lg shadow-md p-8 mb-12"
    x-data="{
        parallaxOffset: 0,
        mouseX: 0,
        mouseY: 0,
        isInView: false
    }"
    x-init="
        window.addEventListener('scroll', () => {
            const rect = $el.getBoundingClientRect();
            isInView = rect.top < window.innerHeight && rect.bottom > 0;
            if(isInView) {
                parallaxOffset = (window.innerHeight - rect.top) * 0.05;
            }
        });
        $el.addEventListener('mousemove', (e) => {
            if(isInView) {
                const rect = $el.getBoundingClientRect();
                mouseX = ((e.clientX - rect.left) / rect.width - 0.5) * 20;
                mouseY = ((e.clientY - rect.top) / rect.height - 0.5) * 20;
            }
        });
        $el.addEventListener('mouseleave', () => {
            mouseX = 0;
            mouseY = 0;
        });
    "
    @scroll.window="
        const rect = $el.getBoundingClientRect();
        isInView = rect.top < window.innerHeight && rect.bottom > 0;
    "
    :class="{'animate-fadeIn': isInView}"
>
    <h2 class="text-2xl font-semibold text-gray-900 mb-6 text-center">Tim Manajemen</h2>
    <p class="text-lg text-gray-600 max-w-3xl mx-auto text-center mb-8">Dipimpin oleh para profesional berpengalaman, tim manajemen kami berkomitmen untuk memberikan solusi teknologi terbaik bagi klien kami.</p>

    <style>
    @keyframes fadeInScale {
        0% { opacity: 0; transform: scale(0.95); }
        100% { opacity: 1; transform: scale(1); }
    }
    .animate-fadeIn {
        animation: fadeInScale 0.8s ease-out forwards;
    }
</style>

<div class="relative max-w-5xl mx-auto h-[500px] md:h-[400px] overflow-hidden" x-show="isInView" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
        <!-- Struktur Tim dengan efek parallax -->
        <div class="absolute inset-0 flex items-center justify-center">
            <!-- Komisaris (Kiri) -->
            <div class="absolute left-0 md:left-60 transform -translate-x-1/12 md:translate-x-0 z-10 transition-transform duration-300 ease-out"
                 :style="`transform: translate(calc(-8% + ${parallaxOffset * -2}px + ${mouseX * -0.5}px), ${mouseY * -0.3}px);`">
                <img src="{{ asset('images/foto_tim/mardhi.png') }}" class="w-52 h-52 md:w-60 md:h-60 object-cover object-center drop-shadow-xl" alt="Komisaris">
                <div class="mt-4 text-center">
                    <h3 class="text-xl font-semibold text-gray-900 mb-1">Mas Ardhi</h3>
                    <p class="text-[#3E4FB0] font-medium mb-2">Komisaris</p>
                </div>
            </div>

            <!-- Direktur Utama (Tengah) -->
            <div class="absolute z-30 transform transition-transform duration-200 ease-out"
                 :style="`transform: translate(${mouseX * 0.3}px, ${mouseY * 0.3}px);`">
                <img src="{{ asset('images/foto_tim/bsulis.png') }}" class="w-52 h-70 md:w-60 md:h-70 object-cover object-center drop-shadow-2xl" alt="Direktur Utama">
                <div class="mt-4 text-center">
                    <h3 class="text-2xl font-bold text-gray-900 mb-1">Mbak Sulis</h3>
                    <p class="text-[#3E4FB0] font-semibold mb-2">Direktur Utama</p>
                </div>
            </div>

            <!-- Direktur (Kanan) -->
            <div class="absolute right-0 md:right-60 transform translate-x-1/12 md:translate-x-0 z-10 transition-transform duration-300 ease-out"
                 :style="`transform: translate(calc(8% + ${parallaxOffset * 2}px + ${mouseX * 0.5}px), ${mouseY * -0.3}px);`">
                <img src="{{ asset('images/foto_tim/marizia.png') }}" class="w-52 h-52 md:w-60 md:h-60 object-cover object-center drop-shadow-xl" alt="Direktur">
                <div class="mt-4 text-center">
                    <h3 class="text-xl font-semibold text-gray-900 mb-1">Mabk Arizia</h3>
                    <p class="text-[#3E4FB0] font-medium mb-2">Direktur</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Deskripsi Tim -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8 max-w-4xl mx-auto">
        <div class="text-center">
            <p class="text-gray-600">Dosen Sistem Informasi UISI</p>
        </div>
        <div class="text-center">
            <p class="text-gray-600">Dosen Sistem Informasi UNUSA</p>
        </div>
        <div class="text-center">
            <p class="text-gray-600">Dosen Sistem Informasi UBAYA</p>
        </div>
    </div>
</section>
</div>
</main>
@endsection
