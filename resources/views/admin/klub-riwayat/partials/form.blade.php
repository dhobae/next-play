@php($riwayat = $riwayat ?? null)

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="nama_liga" class="form-label">Nama Liga</label>
        <input type="text" name="nama_liga" id="nama_liga" class="form-control"
            value="{{ old('nama_liga', $riwayat?->nama_liga) }}" required>
        @error('nama_liga')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="hasil_liga" class="form-label">Hasil Liga</label>
        <input type="text" name="hasil_liga" id="hasil_liga" class="form-control"
            value="{{ old('hasil_liga', $riwayat?->hasil_liga) }}" maxlength="255" required>
        @error('hasil_liga')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="tanggal_liga" class="form-label">Tanggal Liga</label>
        <input type="date" name="tanggal_liga" id="tanggal_liga" class="form-control"
            value="{{ old('tanggal_liga', $riwayat?->tanggal_liga?->format('Y-m-d')) }}" required>
        @error('tanggal_liga')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="poin_liga" class="form-label">Poin Liga</label>
        <input type="number" name="poin_liga" id="poin_liga" class="form-control"
            value="{{ old('poin_liga', $riwayat?->poin_liga) }}" required>
        @error('poin_liga')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>
