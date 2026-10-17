<button type="button" class="btn btn-warning btn-sm edit-riwayat-liga-button" title="Edit" data-bs-toggle="modal"
    data-bs-target="#riwayatModal" data-update-url="{{ route('admin.klub-riwayat.update', [$klub, $riwayat]) }}"
    data-nama-liga="{{ $riwayat->nama_liga }}" data-hasil-liga="{{ $riwayat->hasil_liga }}"
    data-tanggal-liga="{{ $riwayat->tanggal_liga?->format('Y-m-d') }}" data-poin-liga="{{ $riwayat->poin_liga }}">
    <i class="bi bi-pencil-square"></i>
</button>
<form action="{{ route('admin.klub-riwayat.destroy', [$klub, $riwayat]) }}" method="POST"
    class="d-inline delete-riwayat-liga-form">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm" title="Hapus"><i class="bi bi-trash"></i></button>
</form>
