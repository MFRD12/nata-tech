@props([
    'message',
    'title' => 'Error!',
    'type' => 'error', // success, warning, info, question
    'closeRoute' => null,
])

@if ($message)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const isDark = localStorage.getItem('dark') === 'true';

            Swal.fire({
                title: @json($title),
                text: @json($message),
                icon: @json($type),
                confirmButtonText: 'Tutup',
                background: isDark ? '#1a1c23' : '#ffffff',
                color: isDark ? '#f3f4f6' : '#1f2937',
                confirmButtonColor: isDark ? '#ef4444' : '#d33',
                customClass: {
                    title: 'text-base', // Tailwind font-size utk judul
                    popup: 'text-sm', // font utama
                    confirmButton: 'text-sm' // tombol
                }
            })
        });
    </script>
@endif
