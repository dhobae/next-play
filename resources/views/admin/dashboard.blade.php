@extends('admin.layouts.app')

@section('content')
    <style>
        .dashboard-intro {
            background: linear-gradient(120deg, #132238 0%, #1e4660 62%, #2d7a78 100%);
            color: #fff;
            border-radius: .5rem;
            overflow: hidden;
            position: relative;
        }

        .dashboard-intro::after {
            content: '';
            position: absolute;
            width: 13rem;
            height: 13rem;
            border: 1px solid rgba(255, 255, 255, .18);
            border-radius: 50%;
            right: -3rem;
            top: -5rem;
        }

        .dashboard-stat {
            border: 0;
            border-left: 4px solid var(--stat-color);
            min-height: 122px;
        }

        .dashboard-stat .stat-icon {
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            border-radius: .5rem;
            color: var(--stat-color);
            background: color-mix(in srgb, var(--stat-color) 12%, transparent);
            font-size: 1.25rem;
        }

        .dashboard-section-title {
            font-size: .95rem;
            font-weight: 700;
            letter-spacing: .01em;
        }
    </style>

    <div class="col-12">
        <div class="dashboard-intro shadow-sm p-4 mb-4">
            <div class="position-relative" style="z-index: 1;">
                <p class="text-uppercase small mb-2 opacity-75">Panel administrasi</p>
                <h1 class="h3 mb-2">Selamat datang, Admin.</h1>
                <p class="mb-0 opacity-75">Pantau dan kelola konten Next Premiere.</p>
            </div>
        </div>

        <div class="row g-3 mb-4">
            @foreach ([['events', 'Total Event', 'calendar-event', 'admin.eventacara.index', '#0d6efd', 'Kelola event'], ['athletes', 'Total Atlet', 'person-badge', 'admin.atlet.index', '#198754', 'Kelola atlet'], ['visitors', 'Total Pengunjung', 'people', null, '#fd7e14', null], ['sponsors', 'Sponsor', 'award', 'admin.sponsor.index', '#6f42c1', 'Kelola sponsor']] as $stat)
                <div class="col-sm-6 col-xl-3">
                    <div class="card dashboard-stat shadow-sm" style="--stat-color: {{ $stat[4] }};">
                        <div class="card-body d-flex justify-content-between align-items-start">
                            <div>
                                <div class="text-muted small">{{ $stat[1] }}</div>
                                <div class="h2 mb-0 mt-2">{{ $stats[$stat[0]] }}</div>
                                @if ($stat[3])
                                    <a class="small text-decoration-none" href="{{ route($stat[3]) }}">{{ $stat[5] }}
                                        <i class="bi bi-arrow-right"></i></a>
                                @endif
                            </div>
                            <div class="stat-icon ms-auto"><i class="bi bi-{{ $stat[2] }}"></i></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row g-4">
            <div class="col-12">
                <div class="card shadow-sm h-100">
                    <div class="card-header d-flex justify-content-between align-items-center"><span
                            class="dashboard-section-title">Event terbaru</span><a
                            href="{{ route('admin.eventacara.index') }}" class="btn btn-sm btn-outline-primary ms-auto"><i
                                class="bi bi-plus-lg me-1"></i>Tambah event</a></div>
                    <div class="card-body p-0">
                        @if ($latestEvents->isEmpty())
                            <div class="text-center text-muted py-5"><i
                                    class="bi bi-calendar2-x fs-2 d-block mb-2"></i>Belum ada event yang ditambahkan.</div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th class="ps-3">Judul</th>
                                            <th>Tanggal</th>
                                            <th class="text-end pe-3">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($latestEvents as $event)
                                            <tr>
                                                <td class="ps-3">{{ $event->judul }}</td>
                                                <td class="text-muted">
                                                    {{ $event->tanggal ? \Carbon\Carbon::parse($event->tanggal)->format('d M Y') : '-' }}
                                                </td>
                                                <td class="text-end pe-3"><a
                                                        href="{{ route('admin.eventacara.edit', $event) }}"
                                                        class="btn btn-sm btn-light" title="Edit event"><i
                                                            class="bi bi-pencil"></i></a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
