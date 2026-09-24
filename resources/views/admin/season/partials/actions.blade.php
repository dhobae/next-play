<div class="d-flex justify-content-center gap-1">
    <a href="{{ route('admin.season.show', $season) }}" class="btn btn-info btn-sm" title="Detail"><i
            class="bi bi-eye"></i></a>
    <a href="{{ route('admin.season.edit', $season) }}" class="btn btn-warning btn-sm" title="Edit"><i
            class="bi bi-pencil-square"></i></a>
    <form action="{{ route('admin.season.destroy', $season) }}" method="POST" class="delete-form d-inline">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm" title="Hapus"><i class="bi bi-trash"></i></button>
    </form>
</div>
