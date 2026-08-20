<div class="d-flex justify-content-center align-items-center gap-1">
    <a href="{{ route('admin.eventacara.edit', $event) }}" class="btn btn-warning btn-sm pb-0" title="Edit">
        <i class="bi bi-pencil-square"></i>
    </a>

    <form action="{{ route('admin.eventacara.destroy', $event) }}" method="POST" class="d-inline delete-form">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm pb-0" title="Hapus">
            <i class="bi bi-trash"></i>
        </button>
    </form>

</div>
