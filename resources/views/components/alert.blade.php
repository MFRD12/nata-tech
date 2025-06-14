@props([
    'type' => 'info', // Tipe default: info, success, error, warning
    'message', // Pesan yang akan ditampilkan (wajib ada)
    'title' => null, // Judul opsional untuk alert
    'duration' => 5000, // Durasi tampil dalam milidetik
])

@php
    $bgColor = '';
    $borderColor = '';
    $textColor = '';
    $defaultTitle = '';

    switch ($type) {
        case 'success':
            $bgColor = 'bg-green-100';
            $borderColor = 'border-green-400';
            $textColor = 'text-green-700';
            $leftBorderColor = 'bg-green-500';
            $defaultTitle = 'Sukses!';
            break;
        case 'error':
            $bgColor = 'bg-red-100';
            $borderColor = 'border-red-400';
            $textColor = 'text-red-700';
            $leftBorderColor = 'bg-red-500';
            $defaultTitle = 'Terjadi Kesalahan!';
            break;
        case 'warning':
            $bgColor = 'bg-yellow-100';
            $borderColor = 'border-yellow-400';
            $textColor = 'text-yellow-700';
            $leftBorderColor = 'bg-yellow-500';
            $defaultTitle = 'Peringatan!';
            break;
        default:
            // info
            $bgColor = 'bg-blue-100';
            $borderColor = 'border-blue-400';
            $textColor = 'text-blue-700';
            $leftBorderColor = 'bg-blue-500';
            $defaultTitle = 'Informasi';
            break;
    }

    // Gunakan title yang di-pass, atau defaultTitle jika title null
    $alertTitle = $title ?? $defaultTitle;
@endphp

<div x-data="{ show: true }" 
    x-init="setTimeout(() => show = false, {{ $duration }})"
    x-show="show"
    x-transition:enter="transition transform duration-300 ease-out"
    x-transition:enter-start="translate-x-full opacity-0"
    x-transition:enter-end="translate-x-0 opacity-100"
    x-transition:leave="transition transform duration-300 ease-in"
    x-transition:leave-start="translate-x-0 opacity-100"
    x-transition:leave-end="translate-x-full opacity-0"
    class="fixed top-4 right-4 z-30 pl-6 px-4 py-3 rounded-md border {{ $bgColor }} {{ $borderColor }} {{ $textColor }} shadow-lg w-[60%] sm:w-full sm:max-w-sm md:max-w-md lg:max-w-md xl:max-w-md"
    role="alert">

    <span class="absolute left-0 top-0 h-full w-1 rounded-l-md {{ $leftBorderColor }}"></span>

    @if ($alertTitle)
        <p class="font-bold">{{ $alertTitle }}</p>
    @endif

    <p class="{{ $alertTitle ? 'text-sm' : '' }}">{{ $message }}</p>
</div>
