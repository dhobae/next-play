@extends('user.layouts.app')

@section('content')
    @php
        $rankBadgeClass = match ((int) $rank) {
            1 => 'rank-gold',
            2 => 'rank-dark-silver',
            3 => 'rank-bronze',
            default => 'rank-light-silver',
        };
    @endphp

    <section class="athlete-detail-hero club-ranking-detail-hero">
        <div class="container">
            <a class="athlete-back-link" href="{{ route('peringkat-klub') }}"><i class="fa-solid fa-arrow-left"></i> Kembali ke
                Peringkat Club</a>
            <div class="athlete-detail-profile">
                <div class="athlete-detail-avatar-wrap">
                    <div class="athlete-detail-avatar">
                        @if ($klub->gambar)
                            <img src="{{ asset('storage/' . $klub->gambar) }}" alt="{{ $klub->nama_klub }}">
                        @else
                            <img src="{{ asset('assets/nextpremiere/padel-dummy.png') }}" alt="{{ $klub->nama_klub }}">
                        @endif
                    </div>
                    <span class="athlete-rank-chip {{ $rankBadgeClass }}"><i class="fa-solid fa-trophy"></i>
                        #{{ $rank }}</span>
                </div>
                <div class="athlete-detail-copy">
                    <h1>{{ $klub->nama_klub }}</h1>
                    <p class="detail-rank-label">Peringkat Club {{ $rank }}</p>
                    <div class="athlete-detail-tags">
                        <span><i class="fa-solid fa-location-dot"></i> {{ $klub->alamat ?: '-' }}</span>
                        <span><i class="fa-solid fa-trophy"></i> {{ $totalLiga }} Liga</span>
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
                    <h2>Informasi Club</h2>
                    <dl class="detail-list">
                        <div>
                            <dt><i class="fa-solid fa-building"></i> Nama Club</dt>
                            <dd>{{ $klub->nama_klub }}</dd>
                        </div>
                        <div>
                            <dt><i class="fa-solid fa-location-dot"></i> Alamat</dt>
                            <dd>{{ $klub->alamat ?: '-' }}</dd>
                        </div>
                        <div>
                            <dt><i class="fa-solid fa-trophy"></i> Peringkat Keseluruhan</dt>
                            <dd>#{{ $rank }}</dd>
                        </div>
                    </dl>
                </article>
                <article class="detail-card">
                    <h2>Statistik</h2>
                    <div class="stat-list">
                        <div class="stat-item stat-green"><span>Total Poin Liga</span><strong>{{ $totalPoin }}</strong>
                        </div>
                        <div class="stat-item stat-grey"><span>Total Liga</span><strong>{{ $totalLiga }}</strong></div>
                        <div class="stat-item stat-purple"><span>Peringkat Club</span><strong>#{{ $rank }}</strong>
                        </div>
                    </div>
                </article>
            </div>

            <article class="detail-card tournament-card">
                <h2>Riwayat Liga</h2>
                <div class="detail-tournament-table-wrap">
                    <table class="detail-tournament-table">
                        <thead>
                            <tr>
                                <th>Nama Liga</th>
                                <th>Tanggal</th>
                                <th>Hasil</th>
                                <th>Poin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($klub->riwayatLiga as $riwayat)
                                <tr>
                                    <td>{{ $riwayat->nama_liga }}</td>
                                    <td>{{ $riwayat->tanggal_liga?->translatedFormat('d M Y') ?: '-' }}</td>
                                    <td><span class="result-badge">{{ $riwayat->hasil_liga }}</span></td>
                                    <td class="detail-points">+{{ $riwayat->poin_liga }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="empty-history">Belum ada riwayat liga.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </article>
        </div>
    </section>
@endsection
