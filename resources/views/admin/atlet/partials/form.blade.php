@php($atlet = $atlet ?? null)
@php($jenisKelamin = old('jenis_kelamin', $atlet?->jenis_kelamin))

<div class="row">
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nama_atlet" class="form-label">Nama Atlet</label>
                <input type="text" name="nama_atlet" id="nama_atlet" class="form-control"
                    value="{{ old('nama_atlet', $atlet?->nama_atlet) }}" required>
                @error('nama_atlet')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="level" class="form-label">Level</label>
                <select name="level" id="level" class="form-select" required>
                    <option value="">Pilih level</option>
                    @foreach (['Bronze', 'Silver', 'Elektrum', 'Beginner'] as $level)
                        <option value="{{ $level }}" @selected(old('level', $atlet?->level) === $level)>
                            {{ $level }}
                        </option>
                    @endforeach
                </select>
                @error('level')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="form-select" required>
                    <option value="">Pilih jenis kelamin</option>
                    <option value="0" @selected((string) $jenisKelamin === '0')>Laki-laki</option>
                    <option value="1" @selected((string) $jenisKelamin === '1')>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="klub_asosiasi" class="form-label">Klub/Asosiasi</label>
                <input type="text" name="klub_asosiasi" id="klub_asosiasi" class="form-control"
                    value="{{ old('klub_asosiasi', $atlet?->klub_asosiasi) }}" required>
                @error('klub_asosiasi')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control"
                    value="{{ old('tempat_lahir', $atlet?->tempat_lahir) }}" required>
                @error('tempat_lahir')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control"
                    value="{{ old('tanggal_lahir', $atlet?->tanggal_lahir?->format('Y-m-d')) }}" required>
                @error('tanggal_lahir')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="kebangsaan" class="form-label">Kebangsaan</label>
                <input type="text" name="kebangsaan" id="kebangsaan" class="form-control"
                    value="{{ old('kebangsaan', $atlet?->kebangsaan) }}" required>
                @error('kebangsaan')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

    </div>

    <div class="col-md-4">
        <div class="mb-3">
            <label for="foto_atlet" class="form-label">Foto Atlet</label>
            <input type="file" name="foto_atlet" id="foto_atlet" class="form-control"
                accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml" {{ $atlet ? '' : 'required' }}>
            <small class="text-muted">Maksimal 2 MB.</small>
            @error('foto_atlet')
                <small class="d-block text-danger">{{ $message }}</small>
            @enderror
        </div>

        @if ($atlet?->foto_atlet)
            <div class="mb-3">
                <div class="mb-2 fw-semibold">Foto Saat Ini</div>
                <img src="{{ asset('storage/' . $atlet->foto_atlet) }}" alt="{{ $atlet->nama_atlet }}"
                    class="img-fluid rounded" style="max-height: 220px; object-fit: cover;">
            </div>
        @endif

        <div id="preview-container" class="d-none">
            <div class="mb-2 fw-semibold">Preview Foto Baru</div>
            <img id="preview-foto-atlet" src="" alt="Preview foto atlet baru" class="img-fluid rounded"
                style="max-height: 220px; object-fit: cover;">
        </div>
    </div>
</div>

<script>
    document.getElementById('foto_atlet').addEventListener('change', function(event) {
        const container = document.getElementById('preview-container');
        const preview = document.getElementById('preview-foto-atlet');
        const file = event.target.files[0];

        if (!file) {
            return;
        }

        preview.src = URL.createObjectURL(file);
        container.classList.remove('d-none');
    });
</script>
