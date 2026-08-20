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
        <select name="hasil_turnamen" id="hasil_turnamen" class="form-select select2" required>
            <option value="">Pilih hasil turnamen</option>
            @foreach (['Champions', 'Runner Up', 'R32', 'R16', 'R8', 'R4', 'Kualifikasi'] as $hasil)
                <option value="{{ $hasil }}" @selected(old('hasil_turnamen', $riwayat?->hasil_turnamen) === $hasil)>
                    {{ $hasil }}
                </option>
            @endforeach
        </select>
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

<script>
    const hasilTurnamenModal = $('#hasil_turnamen').closest('.modal');

    $('#hasil_turnamen').select2({
        theme: 'bootstrap-5',
        placeholder: 'Pilih hasil turnamen',
        width: '100%',
        dropdownParent: hasilTurnamenModal.length ? hasilTurnamenModal : $(document.body)
    });
</script>
