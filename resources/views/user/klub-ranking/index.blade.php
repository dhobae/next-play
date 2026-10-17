@extends('user.layouts.app')

@section('content')
    <section class="peringkat-hero"
        @if ($hero?->gambar) style="--peringkat-hero-image: url('{{ asset('storage/' . $hero->gambar) }}');" @endif>
        <div class="container">
            <p class="eyebrow">Peringkat Club</p>
            <h1>{{ $hero?->judul ?? 'PERINGKAT CLUB' }}</h1>
            <p>{{ $hero?->subjudul ?? '' }}</p>
        </div>
    </section>

    <section class="section-padding ranking-section">
        <div class="container">
            <div class="ranking-panel">
                <div class="ranking-heading">
                    <h2><i class="fa-solid fa-trophy"></i> Ranking Club</h2>
                    <span class="ranking-total"><i class="fa-solid fa-circle-info"></i> Klik baris untuk detail <b
                            id="club-total">0 Club</b></span>
                </div>

                <div class="ranking-table-wrap">
                    <table id="club-ranking-table" class="ranking-table w-100">
                        <thead>
                            <tr>
                                <th class="rank-header">Rank</th>
                                <th>Padel Club</th>
                                <th>Total Liga</th>
                                <th class="points-header">Poin</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.11/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.11/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(function() {
            const table = $('#club-ranking-table').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                lengthMenu: [10, 25, 50],
                pageLength: 10,
                order: [],
                ajax: '{{ route('peringkat-klub') }}',
                language: {
                    processing: 'Memuat...',
                    search: 'Cari Club:',
                    lengthMenu: 'Tampilkan _MENU_ data',
                    info: 'Menampilkan _START_-_END_ dari _TOTAL_ club',
                    infoEmpty: 'Belum ada club',
                    zeroRecords: 'Club tidak ditemukan',
                    paginate: {
                        previous: '‹',
                        next: '›'
                    }
                },
                columns: [{
                        data: 'rank',
                        name: 'rank',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'klub_display',
                        name: 'klub_display'
                    },
                    {
                        data: 'total_liga',
                        name: 'total_liga'
                    },
                    {
                        data: 'poin_liga',
                        name: 'poin_liga'
                    }
                ],
                createdRow: function(row, data) {
                    $(row).attr('data-detail-url', data.detail_url);
                },
                columnDefs: [{
                    targets: 0,
                    className: 'rank-column',
                    render: function(data) {
                        const rankClass = {
                            1: 'rank-gold',
                            2: 'rank-dark-silver',
                            3: 'rank-bronze'
                        } [data] || 'rank-light-silver';
                        return '<span class="club-rank-chip ' + rankClass +
                            '"><i class="fa-solid fa-trophy"></i> #' + data + '</span>';
                    }
                }, {
                    targets: 3,
                    className: 'points-column',
                    render: function(data) {
                        return '<span class="points-badge">' + data + '</span>';
                    }
                }],
                drawCallback: function(settings) {
                    $('#club-total').text(settings.json.recordsFiltered + ' Club');
                }
            });

            $('#club-ranking-table tbody').on('click', 'tr', function() {
                const detailUrl = $(this).data('detail-url');
                if (detailUrl) window.location.href = detailUrl;
            });
        });
    </script>
@endsection
