@props(['route', 'id'])

<form id="form-delete-{{ $id }}" action="{{ $route }}" method="POST" class="inline-block">
    @csrf
    @method('DELETE')
    <button type="button" onclick="confirmDelete({{ $id }})"
        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-xs font-medium shadow-sm">
        <i class="fas fa-trash"></i>
    </button>
</form>

<script>
    function confirmDelete(id) {
        const isDark = localStorage.getItem('dark') === 'true';

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: 'Data tidak dapat dikembalikan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: isDark ? '#ef4444' : '#d33',
            cancelButtonColor: isDark ? '#6b7280' : '#aaa',
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',
            background: isDark ? '#1a1c23' : '#ffffff',
            color: isDark ? '#f3f4f6' : '#1f2937',
            customClass: {
                popup: 'rounded-lg shadow',
                title: 'text-lg font-semibold',
                confirmButton: 'text-sm px-4 py-2',
                cancelButton: 'text-sm px-4 py-2'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-delete-' + id).submit();
            }
        });
    }
</script>