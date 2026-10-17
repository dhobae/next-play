@extends('admin.layouts.app')

@section('content')
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Hero Club</h3>
                @if ($heroes->isEmpty())
                    <button type="button" class="btn btn-primary btn-sm ms-auto" data-bs-toggle="modal"
                        data-bs-target="#heroModal" data-mode="create"><i class="bi bi-plus-circle me-1"></i> Tambah
                        Hero</button>
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
                                <th style="width:5%">#</th>
                                <th style="width:20%">Gambar</th>
                                <th style="width:25%">Judul</th>
                                <th style="width:25%">Subjudul</th>
                                <th style="width:15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($heroes as $hero)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($hero->gambar)
                                            <img src="{{ asset('storage/' . $hero->gambar) }}" alt="{{ $hero->judul }}"
                                                class="img-fluid rounded" style="max-height:90px;object-fit:cover;">
                                        @else
                                            <span class="text-muted">Tidak ada gambar</span>
                                        @endif
                                    </td>
                                    <td>{{ $hero->judul }}</td>
                                    <td>{{ $hero->subjudul }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-warning btn-sm me-1 btn-edit-hero"
                                            data-id="{{ $hero->id }}" data-judul="{{ $hero->judul }}"
                                            data-subjudul="{{ $hero->subjudul }}" data-gambar="{{ $hero->gambar }}"
                                            data-bs-toggle="modal" data-bs-target="#heroModal"><i
                                                class="bi bi-pencil-square"></i></button>
                                        @if ($heroes->count() > 1)
                                            <form action="{{ route('admin.heroklub.destroy', $hero->id) }}" method="POST"
                                                class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"><i
                                                        class="bi bi-trash"></i></button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Belum ada data hero.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="heroModal" tabindex="-1" aria-labelledby="heroModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="heroForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" id="heroMethod" value="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="heroModalLabel">Tambah Hero</h5>
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
                            <div class="mt-2 d-flex gap-3 flex-wrap">
                                <div id="previewOldWrapper" style="display:none">
                                    <p class="mb-1 small text-muted">Gambar saat ini:</p>
                                    <img id="previewGambarLama" src="" alt="Gambar lama"
                                        class="img-fluid rounded border" style="max-height:150px;object-fit:cover;">
                                </div>
                                <div id="previewNewWrapper" style="display:none">
                                    <p id="previewNewLabel" class="mb-1 small text-muted">Preview gambar:</p>
                                    <img id="previewGambarBaru" src="" alt="Preview gambar"
                                        class="img-fluid rounded border" style="max-height:150px;object-fit:cover;">
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
        $(function() {
            const form = $('#heroForm');
            let mode = 'create';

            $('button[data-bs-target="#heroModal"]').on('click', function() {
                if ($(this).data('mode') !== 'create') return;
                mode = 'create';
                form.attr('action', '{{ route('admin.heroklub.store') }}');
                $('#heroMethod').val('POST');
                $('#heroModalLabel').text('Tambah Hero Club');
                form[0].reset();
                $('#previewOldWrapper, #previewNewWrapper').hide();
            });

            $('.btn-edit-hero').on('click', function() {
                const button = $(this);
                mode = 'edit';
                form.attr('action', '{{ url('admin/heroklub') }}/' + button.data('id'));
                $('#heroMethod').val('PUT');
                $('#heroModalLabel').text('Edit Hero Club');
                $('#judul').val(button.data('judul'));
                $('#subjudul').val(button.data('subjudul'));
                $('#gambar').val('');
                $('#previewNewWrapper').hide();
                if (button.data('gambar')) {
                    $('#previewGambarLama').attr('src', '{{ asset('storage') }}/' + button.data('gambar'));
                    $('#previewOldWrapper').show();
                } else {
                    $('#previewOldWrapper').hide();
                }
            });

            $('#gambar').on('change', function() {
                const file = this.files[0];
                if (!file) return $('#previewNewWrapper').hide();
                const reader = new FileReader();
                reader.onload = function(event) {
                    $('#previewGambarBaru').attr('src', event.target.result);
                    $('#previewNewLabel').text(mode === 'edit' ? 'Preview gambar baru:' :
                        'Preview gambar:');
                    $('#previewNewWrapper').show();
                };
                reader.readAsDataURL(file);
            });

            $('.delete-form').on('submit', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: 'Data hero ini akan dihapus permanen.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) this.submit();
                });
            });
        });
    </script>
@endsection
