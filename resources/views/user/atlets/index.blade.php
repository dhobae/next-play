@extends('user.layouts.app')

@section('content')
    <section class="peringkat-hero"
        @if ($hero?->gambar) style="--peringkat-hero-image: url('{{ asset('storage/' . $hero->gambar) }}');" @endif>
        <div class="container">
            <p class="eyebrow">Peringkat</p>
            <h1>{{ $hero?->judul ?? 'JUDUL PERINGKAT PEMAIN' }}</h1>
            <p>{{ $hero?->subjudul ?? '' }}
            </p>
        </div>
    </section>

    <section class="section-padding ranking-section">
        <div class="container">
            <div class="ranking-panel">
                <div class="ranking-toolbar">
                    <div class="ranking-tabs" role="group" aria-label="Jenis kelamin">
                        <button class="ranking-filter gender-filter active" type="button" data-gender="0"><i
                                class="fa-solid fa-mars"></i> Pria</button>
                        <button class="ranking-filter gender-filter" type="button" data-gender="1"><i
                                class="fa-solid fa-venus"></i> Wanita</button>
                    </div>
                    <div class="ranking-tabs level-tabs" role="group" aria-label="Level atlet">
                        <button class="ranking-filter level-filter active" type="button" data-level="">Semua</button>
                        <button class="ranking-filter level-filter" type="button" data-level="bronze">Bronze</button>
                        <button class="ranking-filter level-filter" type="button" data-level="silver">Silver</button>
                        <button class="ranking-filter level-filter" type="button" data-level="elektrum">Elektrum</button>
                        <button class="ranking-filter level-filter" type="button" data-level="beginner">Beginner</button>
                    </div>
                </div>

                <div class="ranking-heading">
                    <h2><i class="fa-solid fa-trophy"></i> Ranking <span class="gender-heading">Pria</span></h2>
                    <span class="ranking-total"><i class="fa-solid fa-circle-info"></i> Klik baris untuk detail <b
                            id="athlete-total">0 Atlet</b></span>
                </div>

                <div class="ranking-table-wrap">
                    <table id="athlete-ranking-table" class="ranking-table w-100">
                        <thead>
                            <tr>
                                <th class="rank-header">Rank</th>
                                <th>Nama</th>
                                <th>Klub / Asosiasi</th>
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
            let gender = '0';
            let level = '';
            const table = $('#athlete-ranking-table').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                lengthMenu: [10, 25, 50],
                pageLength: 10,
                order: [],
                ajax: {
                    url: '{{ route('atlets') }}',
                    data: function(data) {
                        data.jenis_kelamin = gender;
                        data.level = level;
                    }
                },
                language: {
                    processing: 'Memuat...',
                    search: 'Cari Atlet:',
                    lengthMenu: 'Tampilkan _MENU_ data',
                    info: 'Menampilkan _START_-_END_ dari _TOTAL_ atlet',
                    infoEmpty: 'Belum ada atlet',
                    zeroRecords: 'Atlet tidak ditemukan',
                    paginate: {
                        previous: '‹',
                        next: '›'
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'nama_atlet_display',
                        name: 'nama_atlet'
                    },
                    {
                        data: 'klub_asosiasi',
                        name: 'klub_asosiasi'
                    },
                    {
                        data: 'poin',
                        name: 'riwayat_turnamen_sum_poin_turnamen',
                        searchable: false,
                        orderable: false
                    }
                ],
                createdRow: function(row, data) {
                    $(row).attr('data-detail-url', data.detail_url);
                },
                columnDefs: [{
                        targets: 0,
                        className: 'rank-column'
                    },
                    {
                        targets: 3,
                        className: 'points-column',
                        render: function(data) {
                            return '<span class="points-badge">' + data + '</span>';
                        }
                    }
                ],
                drawCallback: function(settings) {
                    $('#athlete-total').text(settings.json.recordsFiltered + ' Atlet');
                }
            });

            $('#athlete-ranking-table tbody').on('click', 'tr', function() {
                const detailUrl = $(this).data('detail-url');
                if (detailUrl) window.location.href = detailUrl;
            });

            $('.gender-filter').on('click', function() {
                $('.gender-filter').removeClass('active');
                $(this).addClass('active');
                gender = $(this).data('gender').toString();
                $('.gender-heading').text(gender === '0' ? 'Pria' : 'Wanita');
                table.ajax.reload();
            });

            $('.level-filter').on('click', function() {
                $('.level-filter').removeClass('active');
                $(this).addClass('active');
                level = $(this).data('level');
                table.ajax.reload();
            });
        });
    </script>
@endsection
