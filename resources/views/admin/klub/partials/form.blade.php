@php($klub = $klub ?? null)
<div class="mb-3">
    <label for="nama_klub" class="form-label">Nama Klub</label>
    <input type="text" name="nama_klub" id="nama_klub" class="form-control"
        value="{{ old('nama_klub', $klub?->nama_klub) }}" required>
    @error('nama_klub')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
<div class="mb-3">
    <label for="alamat" class="form-label">Alamat</label>
    <textarea name="alamat" id="alamat" class="form-control" rows="3">{{ old('alamat', $klub?->alamat) }}</textarea>
    @error('alamat')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
<div class="mb-3">
    <label for="gambar" class="form-label">Gambar</label>
    <input type="file" name="gambar" id="gambar" class="form-control"
        accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml" {{ $klub ? '' : 'required' }}>
    <small class="text-muted">Maksimal 2 MB.</small>
    <div class="d-flex gap-3 mt-2">
        @if ($klub?->gambar)
            <div>
                <div class="mb-1 fw-semibold">Gambar Saat Ini</div>
                <img src="{{ asset('storage/' . $klub->gambar) }}" alt="{{ $klub->nama_klub }}"
                    class="img-fluid rounded" style="width: 180px; height: 180px; object-fit: cover;">
            </div>
        @endif

        <div id="preview-gambar-container" class="d-none">
            <div class="mb-1 fw-semibold">Preview Gambar Baru</div>
            <img id="preview-gambar" src="" alt="Preview gambar klub baru" class="img-fluid rounded"
                style="width: 180px; height: 180px; object-fit: cover;">
        </div>
    </div>
    @error('gambar')
        <small class="d-block text-danger">{{ $message }}</small>
    @enderror
</div>

<script>
    document.getElementById('gambar').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const container = document.getElementById('preview-gambar-container');
        const preview = document.getElementById('preview-gambar');

        if (!file) {
            preview.removeAttribute('src');
            container.classList.add('d-none');
            return;
        }

        preview.src = URL.createObjectURL(file);
        container.classList.remove('d-none');
    });
</script>
