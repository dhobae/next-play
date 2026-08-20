@extends('admin.layouts.app')

@section('content')
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Sponsor Beranda</h3>
                <button type="button" class="btn btn-primary btn-sm ms-auto" data-bs-toggle="modal"
                    data-bs-target="#sponsorModal" data-mode="create">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Sponsor
                </button>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th style="width: 5%">#</th>
                                <th style="width: 25%">Gambar</th>
                                <th style="width: 45%">Nama Sponsor</th>
                                <th style="width: 15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sponsors as $sponsor)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($sponsor->gambar)
                                            <img src="{{ asset('storage/' . $sponsor->gambar) }}"
                                                alt="{{ $sponsor->nama_sponsor }}" class="img-fluid rounded"
                                                style="max-height: 90px; object-fit: cover;">
                                        @else
                                            <span class="text-muted">Tidak ada gambar</span>
                                        @endif
                                    </td>
                                    <td>{{ $sponsor->nama_sponsor }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-warning btn-sm me-1 btn-edit-sponsor"
                                            data-id="{{ $sponsor->id }}" data-nama_sponsor="{{ $sponsor->nama_sponsor }}"
                                            data-gambar="{{ $sponsor->gambar }}" data-bs-toggle="modal"
                                            data-bs-target="#sponsorModal" data-mode="edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <form action="{{ route('admin.sponsor.destroy', $sponsor->id) }}" method="POST"
                                            class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Belum ada data sponsor.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="sponsorModal" tabindex="-1" aria-labelledby="sponsorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="sponsorForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" id="sponsorMethod" value="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="sponsorModalLabel">Tambah Sponsor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_sponsor" class="form-label">Nama Sponsor</label>
                            <input type="text" name="nama_sponsor" id="nama_sponsor" class="form-control"
                                value="{{ old('nama_sponsor') }}">
                            @error('nama_sponsor')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="sponsor_gambar" class="form-label">Gambar</label>
                            <input type="file" name="gambar" id="sponsor_gambar" class="form-control" accept="image/*">
                            @error('gambar')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <div class="mt-2 d-flex gap-3 flex-wrap">
                                <div id="previewOldWrapper" style="display: none;">
                                    <p class="mb-1 small text-muted">Gambar saat ini:</p>
                                    <img id="previewGambarLama" src="" alt="Gambar lama"
                                        class="img-fluid rounded border" style="max-height: 150px; object-fit: cover;">
                                </div>
                                <div id="previewNewWrapper" style="display: none;">
                                    <p id="previewNewLabel" class="mb-1 small text-muted">Preview gambar:</p>
                                    <img id="previewGambarBaru" src="" alt="Preview gambar"
                                        class="img-fluid rounded border" style="max-height: 150px; object-fit: cover;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            const sponsorModal = $('#sponsorModal');
            const sponsorForm = $('#sponsorForm');
            const sponsorMethod = $('#sponsorMethod');
            const sponsorModalLabel = $('#sponsorModalLabel');

            let currentMode = 'create';

            $('button[data-bs-target="#sponsorModal"]').on('click', function() {
                const mode = $(this).data('mode');

                if (mode === 'create') {
                    currentMode = 'create';
                    sponsorForm.attr('action', '{{ route('admin.sponsor.store') }}');
                    sponsorMethod.val('POST');
                    sponsorModalLabel.text('Tambah sponsor');
                    sponsorForm[0].reset();
                    $('#nama_sponsor').val('');
                    $('#sponsor_gambar').val('');

                    $('#previewGambarLama').attr('src', '');
                    $('#previewOldWrapper').hide();
                    $('#previewGambarBaru').attr('src', '');
                    $('#previewNewWrapper').hide();
                }
            });

            $('.btn-edit-sponsor').on('click', function() {
                currentMode = 'edit';
                const id = $(this).data('id');
                const namaSponsor = $(this).data('nama_sponsor');
                const gambar = $(this).data('gambar');

                sponsorForm.attr('action', '{{ url('admin/sponsor') }}/' + id);
                sponsorMethod.val('PUT');
                sponsorModalLabel.text('Edit sponsor');

                $('#nama_sponsor').val(namaSponsor);
                $('#sponsor_gambar').val('');

                $('#previewGambarBaru').attr('src', '');
                $('#previewNewWrapper').hide();

                if (gambar) {
                    $('#previewGambarLama').attr('src', '{{ asset('storage') }}/' + gambar);
                    $('#previewOldWrapper').show();
                } else {
                    $('#previewGambarLama').attr('src', '');
                    $('#previewOldWrapper').hide();
                }
            });

            // Preview saat user pilih file baru
            $('#sponsor_gambar').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#previewGambarBaru').attr('src', e.target.result);
                        $('#previewNewLabel').text(currentMode === 'edit' ? 'Preview gambar baru:' :
                            'Preview gambar:');
                        $('#previewNewWrapper').show();
                    };
                    reader.readAsDataURL(file);
                } else {
                    $('#previewGambarBaru').attr('src', '');
                    $('#previewNewWrapper').hide();
                }
            });

            $('.delete-form').on('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: 'Data sponsor ini akan dihapus permanen.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
    </script>
@endsection
