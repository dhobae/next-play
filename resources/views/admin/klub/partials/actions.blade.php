<div class="d-flex justify-content-center gap-1">
    <a href="{{ route('admin.klub.edit', $klub) }}" class="btn btn-warning btn-sm" title="Edit"><i
            class="bi bi-pencil-square"></i></a>
    <form action="{{ route('admin.klub.destroy', $klub) }}" method="POST" class="delete-form d-inline">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm" title="Hapus"><i class="bi bi-trash"></i></button>
    </form>
</div>
