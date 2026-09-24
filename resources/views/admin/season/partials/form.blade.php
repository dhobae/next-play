@php($season = $season ?? null)

<div class="mb-3">
    <label for="nama_season" class="form-label">Nama Season</label>
    <input type="text" name="nama_season" id="nama_season" class="form-control"
        value="{{ old('nama_season', $season?->nama_season) }}" required>

    @error('nama_season')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
        <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control"
            value="{{ old('tanggal_mulai', $season?->tanggal_mulai?->format('Y-m-d')) }}">

        @error('tanggal_mulai')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
        <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control"
            value="{{ old('tanggal_selesai', $season?->tanggal_selesai?->format('Y-m-d')) }}">

        @error('tanggal_selesai')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>

@php($standings = collect($season?->standingsKlub ?? [])->keyBy('klub_id'))
<div class="mb-3">
    <label class="form-label">Klub dan Statistik Season</label>
    <div class="table-responsive border rounded">
        <table class="table table-sm align-middle mb-0">
            <thead>
                <tr>
                    <th>Pilih</th>
                    <th>Klub</th>
                    <th>MP</th>
                    <th>W</th>
                    <th>L</th>
                    <th>PP</th>
                    <th>LP</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($klubs as $klub)
                    @php($standing = $standings->get($klub->id))
                    @php($selectedAtletIds = old("atlets.{$klub->id}", $standing?->atlets?->pluck('id')->all() ?? []))
                    <tr>
                        <td><input type="checkbox" name="klub_ids[]" value="{{ $klub->id }}"
                                @checked(old('klub_ids') ? in_array($klub->id, old('klub_ids')) : (bool) $standing)></td>
                        <td>{{ $klub->nama_klub }}</td>
                        @foreach (['mp', 'w', 'l', 'pp', 'lp'] as $stat)
                            <td><input type="number" name="stats[{{ $klub->id }}][{{ $stat }}]"
                                    class="form-control form-control-sm"
                                    value="{{ old("stats.{$klub->id}.{$stat}", $standing?->{$stat} ?? 0) }}"></td>
                        @endforeach
                    </tr>
                    <tr>
                        <td colspan="7">
                            <label for="atlets_{{ $klub->id }}" class="form-label mb-1">Atlet yang ikut
                                serta</label>
                            <select name="atlets[{{ $klub->id }}][]" id="atlets_{{ $klub->id }}"
                                class="form-select season-atlet-select" multiple data-placeholder="Pilih atlet">
                                @foreach ($atlets->where('klub_id', $klub->id) as $atlet)
                                    <option value="{{ $atlet->id }}" @selected(in_array($atlet->id, $selectedAtletIds))>
                                        {{ $atlet->nama_atlet }}
                                    </option>
                                @endforeach
                            </select>
                            @error("atlets.{$klub->id}")
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @error('klub_ids')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
