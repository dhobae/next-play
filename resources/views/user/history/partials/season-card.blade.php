@foreach ($seasons as $season)
    <div class="ranking-panel mb-4">
        <div class="ranking-heading">
            <h2><i class="fa-solid fa-chart-line"></i> History {{ $season->nama_season }}</h2>
            <span class="ranking-total"><i class="fa-solid fa-circle-info"></i> Klik baris untuk detail klub</span>
        </div>
        <div class="ranking-table-wrap">
            <table class="ranking-table history-table w-100">
                <thead>
                    <tr>
                        <th style="color: #fff !important">#</th>
                        <th>Padel Club</th>
                        <th>MP</th>
                        <th>W</th>
                        <th>L</th>
                        <th>PP</th>
                        <th>LP</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($season->standingsKlub as $standing)
                        <tr class="{{ $standing->rank === 1 ? 'rank-row-first' : '' }}"
                            data-detail-url="{{ route('history.show', [$season, $standing->klub]) }}">
                            @php
                                $rankClass = match ($standing->rank) {
                                    1 => 'rank-gold',
                                    2 => 'rank-dark-silver',
                                    3 => 'rank-bronze',
                                    default => 'rank-light-silver',
                                };
                            @endphp
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $standing->klub->nama_klub }}
                                @if ($standing->rank <= 2)
                                    <span class="club-rank-chip {{ $rankClass }}">
                                        <i class="fa-solid fa-trophy"></i> #{{ $standing->rank }}
                                    </span>
                                @endif
                            </td>
                            <td>{{ $standing->mp }}</td>
                            <td>{{ $standing->w }}</td>
                            <td>{{ $standing->l }}</td>
                            <td>{{ $standing->pp }}</td>
                            <td>{{ $standing->lp }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">Belum ada data klub pada season ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endforeach
