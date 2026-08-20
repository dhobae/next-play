<button type="button" class="btn btn-warning btn-sm edit-riwayat-button" title="Edit" data-bs-toggle="modal"
    data-bs-target="#riwayatModal" data-update-url="{{ route('admin.atlet-riwayat.update', [$atlet, $riwayat]) }}"
    data-nama-turnamen="{{ $riwayat->nama_turnamen }}"
    data-tanggal-turnamen="{{ $riwayat->tanggal_turnamen?->format('Y-m-d') }}"
    data-hasil-turnamen="{{ $riwayat->hasil_turnamen }}" data-poin-turnamen="{{ $riwayat->poin_turnamen }}">
    <i class="bi bi-pencil-square"></i>
</button>
<form action="{{ route('admin.atlet-riwayat.destroy', [$atlet, $riwayat]) }}" method="POST"
    class="d-inline delete-riwayat-form">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
        <i class="bi bi-trash"></i>
    </button>
</form>
