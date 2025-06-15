@props([
    'type' => 'info',
    'message',
    'title' => null,
    'duration' => 3000,
])

@if ($message)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const isDark = localStorage.getItem('dark') === 'true';

            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: @json($type),
                title: @json($title),
                text: @json($message),
                showConfirmButton: false,
                timer: {{ $duration }},
                timerProgressBar: true,
                background: isDark ? '#1f2937' : '#fff',
                color: isDark ? '#f3f4f6' : '#1f2937',
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
        });
    </script>
@endif
