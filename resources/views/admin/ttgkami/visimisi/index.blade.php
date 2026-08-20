@extends('admin.layouts.app')

@section('content')
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Visi & Misi</h3>
                @if ($visimisis->isEmpty())
                    <button type="button" class="btn btn-primary btn-sm ms-auto" data-bs-toggle="modal"
                        data-bs-target="#visimisiModal" data-mode="create">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Visi & Misi
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
                                <th style="width: 25%">Visi</th>
                                <th style="width: 30%">Misi</th>
                                <th style="width: 15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($visimisis as $visimisi)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($visimisi->gambar)
                                            <img src="{{ asset('storage/' . $visimisi->gambar) }}" alt="Visi & Misi"
                                                class="img-fluid rounded" style="max-height: 90px; object-fit: cover;">
                                        @else
                                            <span class="text-muted">Tidak ada gambar</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="ql-editor p-0">{!! $visimisi->visi !!}</div>
                                    </td>
                                    <td>
                                        <div class="ql-editor p-0">{!! $visimisi->misi !!}</div>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-warning btn-sm me-1 btn-edit-visimisi"
                                            data-id="{{ $visimisi->id }}" data-visi="{{ $visimisi->visi }}"
                                            data-misi="{{ $visimisi->misi }}" data-gambar="{{ $visimisi->gambar }}"
                                            data-bs-toggle="modal" data-bs-target="#visimisiModal" data-mode="edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        @if ($visimisis->count() > 1)
                                            <form action="{{ route('admin.visimisi.destroy', $visimisi->id) }}"
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
                                    <td colspan="5" class="text-center text-muted py-4">Belum ada data visi & misi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="visimisiModal" tabindex="-1" aria-labelledby="visimisiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form id="visimisiForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" id="visimisiMethod" value="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="visimisiModalLabel">Tambah Visi & Misi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="visi" class="form-label">Visi</label>
                            <div id="visiEditor"></div>
                            <textarea name="visi" id="visi" class="form-control d-none" required>{{ old('visi') }}</textarea>
                            @error('visi')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="misi" class="form-label">Misi</label>
                            <div id="misiEditor"></div>
                            <textarea name="misi" id="misi" class="form-control d-none" required>{{ old('misi') }}</textarea>
                            @error('misi')
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
            const visimisiModal = $('#visimisiModal');
            const visimisiForm = $('#visimisiForm');
            const visimisiMethod = $('#visimisiMethod');
            const visimisiModalLabel = $('#visimisiModalLabel');

            let currentMode = 'create';

            const visiEditor = new Quill('#visiEditor', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{
                            header: [1, 2, 3, false]
                        }],
                        ['bold', 'italic', 'underline'],
                        [{
                            list: 'ordered'
                        }, {
                            list: 'bullet'
                        }],
                        ['clean']
                    ]
                }
            });

            const misiEditor = new Quill('#misiEditor', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{
                            header: [1, 2, 3, false]
                        }],
                        ['bold', 'italic', 'underline'],
                        [{
                            list: 'ordered'
                        }, {
                            list: 'bullet'
                        }],
                        ['clean']
                    ]
                }
            });

            function syncQuillEditor(editor, target) {
                target.val(editor.root.innerHTML);
            }

            visiEditor.on('text-change', function() {
                syncQuillEditor(visiEditor, $('#visi'));
            });

            misiEditor.on('text-change', function() {
                syncQuillEditor(misiEditor, $('#misi'));
            });

            $('button[data-bs-target="#visimisiModal"]').on('click', function() {
                const mode = $(this).data('mode');

                if (mode === 'create') {
                    currentMode = 'create';
                    visimisiForm.attr('action', '{{ route('admin.visimisi.store') }}');
                    visimisiMethod.val('POST');
                    visimisiModalLabel.text('Tambah Visi & Misi');
                    visimisiForm[0].reset();
                    visiEditor.setContents('');
                    misiEditor.setContents('');
                    $('#visi').val('');
                    $('#misi').val('');
                    $('#gambar').val('');

                    $('#previewGambarLama').attr('src', '');
                    $('#previewOldWrapper').hide();
                    $('#previewGambarBaru').attr('src', '');
                    $('#previewNewWrapper').hide();
                }
            });

            $('.btn-edit-visimisi').on('click', function() {
                currentMode = 'edit';
                const id = $(this).data('id');
                const visi = $(this).data('visi');
                const misi = $(this).data('misi');
                const gambar = $(this).data('gambar');

                visimisiForm.attr('action', '{{ url('admin/visimisi') }}/' + id);
                visimisiMethod.val('PUT');
                visimisiModalLabel.text('Edit Visi & Misi');

                visiEditor.clipboard.dangerouslyPasteHTML(visi || '');
                misiEditor.clipboard.dangerouslyPasteHTML(misi || '');
                $('#visi').val(visi || '');
                $('#misi').val(misi || '');
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
                    text: 'Data visi & misi ini akan dihapus permanen.',
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
