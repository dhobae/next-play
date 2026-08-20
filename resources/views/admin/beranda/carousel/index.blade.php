@extends('admin.layouts.app')

@section('content')
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Carousel Beranda</h3>
                @if ($carousels->count() < 3)
                    <button type="button" class="btn btn-primary btn-sm ms-auto" data-bs-toggle="modal"
                        data-bs-target="#carouselModal" data-mode="create">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Carousel
                    </button>
                @endif
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
                                <th style="width: 20%">Gambar</th>
                                <th style="width: 25%">Judul</th>
                                <th style="width: 25%">Subjudul</th>
                                <th style="width: 15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($carousels as $carousel)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($carousel->gambar)
                                            <img src="{{ asset('storage/' . $carousel->gambar) }}"
                                                alt="{{ $carousel->judul }}" class="img-fluid rounded"
                                                style="max-height: 90px; object-fit: cover;">
                                        @else
                                            <span class="text-muted">Tidak ada gambar</span>
                                        @endif
                                    </td>
                                    <td>{{ $carousel->judul }}</td>
                                    <td>{{ $carousel->subjudul }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-warning btn-sm me-1 btn-edit-carousel"
                                            data-id="{{ $carousel->id }}" data-judul="{{ $carousel->judul }}"
                                            data-subjudul="{{ $carousel->subjudul }}" data-gambar="{{ $carousel->gambar }}"
                                            data-bs-toggle="modal" data-bs-target="#carouselModal" data-mode="edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        @if ($carousels->count() < 3)
                                            <form action="{{ route('admin.carousel.destroy', $carousel->id) }}"
                                                method="POST" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Belum ada data carousel.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="carouselModal" tabindex="-1" aria-labelledby="carouselModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="carouselForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" id="carouselMethod" value="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="carouselModalLabel">Tambah Carousel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul</label>
                            <input type="text" name="judul" id="judul" class="form-control"
                                value="{{ old('judul') }}">
                            @error('judul')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="subjudul" class="form-label">Subjudul</label>
                            <textarea name="subjudul" id="subjudul" class="form-control" rows="4">{{ old('subjudul') }}</textarea>
                            @error('subjudul')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar</label>
                            <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
                            @error('gambar')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            {{-- file preview --}}
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
            const carouselModal = $('#carouselModal');
            const carouselForm = $('#carouselForm');
            const carouselMethod = $('#carouselMethod');
            const carouselModalLabel = $('#carouselModalLabel');

            let currentMode = 'create';

            $('button[data-bs-target="#carouselModal"]').on('click', function() {
                const mode = $(this).data('mode');

                if (mode === 'create') {
                    currentMode = 'create';
                    carouselForm.attr('action', '{{ route('admin.carousel.store') }}');
                    carouselMethod.val('POST');
                    carouselModalLabel.text('Tambah Carousel');
                    carouselForm[0].reset();
                    $('#judul').val('');
                    $('#subjudul').val('');
                    $('#gambar').val('');

                    $('#previewGambarLama').attr('src', '');
                    $('#previewOldWrapper').hide();
                    $('#previewGambarBaru').attr('src', '');
                    $('#previewNewWrapper').hide();
                }
            });

            $('.btn-edit-carousel').on('click', function() {
                currentMode = 'edit';
                const id = $(this).data('id');
                const judul = $(this).data('judul');
                const subjudul = $(this).data('subjudul');
                const gambar = $(this).data('gambar');

                carouselForm.attr('action', '{{ url('admin/carousel') }}/' + id);
                carouselMethod.val('PUT');
                carouselModalLabel.text('Edit Carousel');

                $('#judul').val(judul);
                $('#subjudul').val(subjudul);
                $('#gambar').val('');

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
            $('#gambar').on('change', function() {
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
                    text: 'Data carousel ini akan dihapus permanen.',
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
