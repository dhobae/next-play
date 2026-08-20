@php($eventacara = $eventacara ?? null)

<div class="row">
    <div class="col-md-8">
        <div class="mb-3">
            <label for="judul" class="form-label">Judul</label>
            <input type="text" name="judul" id="judul" class="form-control"
                value="{{ old('judul', $eventacara?->judul) }}" required>
            @error('judul')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- <div class="mb-3">
            <label for="subjudul" class="form-label">Subjudul</label>
            <input type="text" name="subjudul" id="subjudul" class="form-control"
                value="{{ old('subjudul', $eventacara?->subjudul) }}" required>
            @error('subjudul')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div> --}}

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control"
                value="{{ old('tanggal', $eventacara?->tanggal) }}" required>
            @error('tanggal')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="6" required>{{ old('deskripsi', $eventacara?->deskripsi) }}</textarea>
            @error('deskripsi')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="mb-3">
            <label for="gambar" class="form-label">Gambar</label>
            <input type="file" name="gambar" id="gambar" class="form-control"
                accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml" {{ $eventacara ? '' : 'required' }}>
            <small class="text-muted">Maksimal 2 MB.</small>
            @error('gambar')
                <small class="d-block text-danger">{{ $message }}</small>
            @enderror
        </div>

        @if ($eventacara?->gambar)
            <div class="mb-3">
                <div class="mb-2 fw-semibold">Gambar Saat Ini</div>
                <img src="{{ asset('storage/' . $eventacara->gambar) }}" alt="{{ $eventacara->judul }}"
                    class="img-fluid rounded" style="max-height: 220px; object-fit: cover;">
            </div>
        @endif

        <div id="preview-container" class="d-none">
            <div class="mb-2 fw-semibold">Preview Gambar Baru</div>
            <img id="preview-gambar" src="" alt="Preview gambar baru" class="img-fluid rounded"
                style="max-height: 220px; object-fit: cover;">
        </div>
    </div>
</div>

<script>
    document.getElementById('gambar').addEventListener('change', function(event) {
        const container = document.getElementById('preview-container');
        const preview = document.getElementById('preview-gambar');
        const file = event.target.files[0];

        if (!file) {
            return;
        }

        preview.src = URL.createObjectURL(file);
        container.classList.remove('d-none');
    });
</script>
