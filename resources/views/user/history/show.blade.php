@extends('user.layouts.app')

@section('content')
    <section class="athlete-detail-hero history-club-hero">
        <div class="container">
            <a class="athlete-back-link" href="{{ route('history') }}"><i class="fa-solid fa-arrow-left"></i> Kembali ke
                History</a>
            <div class="history-club-heading">
                <div class="history-club-logo">
                    @if ($klub->gambar)
                    <img src="{{ asset('storage/' . $klub->gambar) }}" alt="{{ $klub->nama_klub }}">@else<img
                            src="{{ asset('assets/nextpremiere/padel-dummy.png') }}" alt="{{ $klub->nama_klub }}">
                    @endif
                </div>
                <div>
                    <p class="eyebrow">Padel Club · Season: {{ $season->nama_season }}</p>
                    <h1>{{ $klub->nama_klub }}</h1>
                    @php
                        $rankClass = match ($standing->rank) {
                            1 => 'rank-gold',
                            2 => 'rank-dark-silver',
                            3 => 'rank-bronze',
                            default => 'rank-light-silver',
                        };
                    @endphp
                    <span class="club-rank-chip {{ $rankClass }}"><i class="fa-solid fa-trophy"></i>
                        Peringkat #{{ $standing->rank }}</span>
                </div>
            </div>
        </div>
    </section>
    <section class="section-padding ranking-section">
        <div class="container">
            <div class="ranking-heading history-athletes-heading">
                <h2><i class="fa-solid fa-users"></i> Atlet Klub</h2>
            </div>
            <div class="history-athlete-grid">
                @forelse ($standing->atlets as $atlet)
                    <a class="history-athlete-card" href="{{ route('atlets.show', $atlet) }}">
                        <div class="history-athlete-image">
                            @if ($atlet->foto_atlet)
                                <img src="{{ asset('storage/' . $atlet->foto_atlet) }}"
                                alt="{{ $atlet->nama_atlet }}">@else<img
                                    src="{{ asset('assets/nextpremiere/padel-dummy.png') }}"
                                    alt="{{ $atlet->nama_atlet }}">
                            @endif
                        </div>
                        <strong>{{ $atlet->nama_atlet }}</strong><i class="fa-solid fa-arrow-up-right-from-square"></i>
                    </a>
                @empty
                    <p class="empty-history">Belum ada atlet pada klub ini.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
