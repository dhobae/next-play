@extends('user.layouts.app')

@section('content')
    @php
        $levelClass = strtolower($atlet->level);
        $levelIcon = match ($levelClass) {
            'elektrum' => 'fa-solid fa-crown',
            'silver', 'bronze' => 'fa-solid fa-medal',
            'beginner' => 'fa-solid fa-shield-halved',
            default => 'fa-solid fa-shield-halved',
        };
        $rankBadgeClass = match ((int) $rank) {
            1 => 'rank-gold',
            2 => 'rank-dark-silver',
            3 => 'rank-bronze',
            default => 'rank-light-silver',
        };
    @endphp

    <section class="athlete-detail-hero">
        <div class="container">
            <a class="athlete-back-link" href="{{ route('atlets') }}"><i class="fa-solid fa-arrow-left"></i> Kembali ke
                Peringkat</a>
            <div class="athlete-detail-profile">
                <div class="athlete-detail-avatar-wrap">
                    <div class="athlete-detail-avatar">
                        @if ($atlet->foto_atlet)
                            <img src="{{ asset('storage/' . $atlet->foto_atlet) }}" alt="{{ $atlet->nama_atlet }}">
                        @else
                            <img src="{{ asset('assets/nextpremiere/padel-dummy.png') }}" alt="{{ $atlet->nama_atlet }}">
                        @endif
                    </div>
                    <span class="athlete-rank-chip {{ $rankBadgeClass }}"><i class="fa-solid fa-trophy"></i>
                        #{{ $rank }}</span>
                </div>
                <div class="athlete-detail-copy">
                    <h1>{{ $atlet->nama_atlet }} <span class="detail-level level-{{ $levelClass }}"><i
                                class="{{ $levelIcon }}"></i> ({{ $atlet->level }})</span></h1>
                    <p class="detail-rank-label">Peringkat {{ $genderLabel }} {{ $rank }}</p>
                    <div class="athlete-detail-tags">
                        <span><i class="fa-solid fa-flag"></i> {{ $atlet->kebangsaan ?: '-' }}</span>
                        <span><i class="fa-solid fa-location-dot"></i> {{ $atlet->tempat_lahir ?: '-' }}</span>
                        <span><i class="fa-solid fa-star"></i> {{ $totalPoin }} Poin</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding athlete-detail-section">
        <div class="container">
            <div class="athlete-detail-grid">
                <article class="detail-card">
                    <h2>Informasi Pribadi</h2>
                    <dl class="detail-list">
                        <div>
                            <dt><i class="fa-regular fa-calendar"></i> Tanggal Lahir</dt>
                            <dd>{{ $atlet->tanggal_lahir?->translatedFormat('d F Y') ?: '-' }}</dd>
                        </div>
                        <div>
                            <dt><i class="fa-solid fa-location-dot"></i> Tempat Lahir</dt>
                            <dd>{{ $atlet->tempat_lahir ?: '-' }}</dd>
                        </div>
                        <div>
                            <dt><i class="fa-solid fa-flag"></i> Kebangsaan</dt>
                            <dd>{{ $atlet->kebangsaan ?: '-' }}</dd>
                        </div>
                    </dl>
                </article>
                <article class="detail-card">
                    <h2>Statistik</h2>
                    <div class="stat-list">
                        <div class="stat-item stat-green"><span>Total Poin</span><strong>{{ $totalPoin }}</strong></div>
                        <div class="stat-item stat-grey"><span>Total Turnamen</span><strong>{{ $totalTurnamen }}</strong>
                        </div>
                        <div class="stat-item stat-purple"><span>Peringkat
                                {{ $genderLabel }}</span><strong>#{{ $rank }}</strong></div>
                    </div>
                </article>
            </div>

            <article class="detail-card tournament-card">
                <h2>Riwayat Turnamen</h2>
                <div class="detail-tournament-table-wrap">
                    <table class="detail-tournament-table">
                        <thead>
                            <tr>
                                <th>Turnamen</th>
                                <th>Tanggal</th>
                                <th>Hasil</th>
                                <th>Poin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($atlet->riwayatTurnamen as $riwayat)
                                <tr>
                                    <td>{{ $riwayat->nama_turnamen }}</td>
                                    <td>{{ $riwayat->tanggal_turnamen?->translatedFormat('d M Y') ?: '-' }}</td>
                                    <td><span class="result-badge">{{ $riwayat->hasil_turnamen }}</span></td>
                                    <td class="detail-points">+{{ $riwayat->poin_turnamen }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="empty-history">Belum ada riwayat turnamen.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </article>
        </div>
    </section>
@endsection
