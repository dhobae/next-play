@php($riwayat = $riwayat ?? null)

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="nama_turnamen" class="form-label">Nama Turnamen</label>
        <input type="text" name="nama_turnamen" id="nama_turnamen" class="form-control"
            value="{{ old('nama_turnamen', $riwayat?->nama_turnamen) }}" required>
        @error('nama_turnamen')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="tanggal_turnamen" class="form-label">Tanggal Turnamen</label>
        <input type="date" name="tanggal_turnamen" id="tanggal_turnamen" class="form-control"
            value="{{ old('tanggal_turnamen', $riwayat?->tanggal_turnamen?->format('Y-m-d')) }}" required>
        @error('tanggal_turnamen')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="hasil_turnamen" class="form-label">Hasil Turnamen</label>
        <input type="text" name="hasil_turnamen" id="hasil_turnamen" class="form-control"
            value="{{ old('hasil_turnamen', $riwayat?->hasil_turnamen) }}" maxlength="255" required>
        @error('hasil_turnamen')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="poin_turnamen" class="form-label">Poin Turnamen</label>
        <input type="number" name="poin_turnamen" id="poin_turnamen" class="form-control"
            value="{{ old('poin_turnamen', $riwayat?->poin_turnamen) }}" required>
        @error('poin_turnamen')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>
