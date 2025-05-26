@extends('compro.layouts.index')

@section('content')
    <main class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">Insight & Artikel</h1>
                    <p class="text-lg text-gray-600 max-w-3xl mx-auto">Temukan informasi terbaru seputar teknologi dan transformasi digital.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Article 1 -->
                    <article class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="aspect-w-16 aspect-h-9">
                            <img class="object-cover w-full h-48" src="https://via.placeholder.com/800x450" alt="Article thumbnail">
                        </div>
                        <div class="p-6">
                            <div class="flex items-center text-sm text-gray-500 mb-2">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                15 Mei 2024
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Transformasi Digital untuk UKM</h3>
                            <p class="text-gray-600 mb-4">Bagaimana UKM dapat memanfaatkan teknologi digital untuk mengembangkan bisnis mereka di era modern.</p>
                            <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Baca selengkapnya →</a>
                        </div>
                    </article>

                    <!-- Article 2 -->
                    <article class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="aspect-w-16 aspect-h-9">
                            <img class="object-cover w-full h-48" src="https://via.placeholder.com/800x450" alt="Article thumbnail">
                        </div>
                        <div class="p-6">
                            <div class="flex items-center text-sm text-gray-500 mb-2">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                10 Mei 2024
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Keamanan Siber untuk Bisnis</h3>
                            <p class="text-gray-600 mb-4">Tips dan strategi untuk melindungi bisnis Anda dari ancaman siber yang semakin berkembang.</p>
                            <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Baca selengkapnya →</a>
                        </div>
                    </article>

                    <!-- Article 3 -->
                    <article class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="aspect-w-16 aspect-h-9">
                            <img class="object-cover w-full h-48" src="https://via.placeholder.com/800x450" alt="Article thumbnail">
                        </div>
                        <div class="p-6">
                            <div class="flex items-center text-sm text-gray-500 mb-2">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                5 Mei 2024
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Tren Teknologi 2024</h3>
                            <p class="text-gray-600 mb-4">Eksplorasi tren teknologi terbaru yang akan membentuk masa depan industri digital.</p>
                            <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Baca selengkapnya →</a>
                        </div>
                    </article>
                </div>


            </div>
        </main>
@endsection
