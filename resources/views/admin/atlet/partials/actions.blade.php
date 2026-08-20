<a href="{{ route('admin.atlet.show', $atlet) }}" class="btn btn-info btn-sm me-1" title="Detail">
    <i class="bi bi-eye"></i>
</a>
<a href="{{ route('admin.atlet.edit', $atlet) }}" class="btn btn-warning btn-sm me-1" title="Edit">
    <i class="bi bi-pencil-square"></i>
</a>

<form action="{{ route('admin.atlet.destroy', $atlet) }}" method="POST" class="d-inline delete-form">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
        <i class="bi bi-trash"></i>
    </button>
</form>
