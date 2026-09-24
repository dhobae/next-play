@extends('admin.layouts.app')

@section('content')
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Detail Season</h3>
                <div class="d-flex gap-2 ms-auto">
                    <a href="{{ route('admin.season.edit', $season) }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil-square me-1"></i>Edit
                    </a>
                    <a href="{{ route('admin.season.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <h4>{{ $season->nama_season }}</h4>
                <dl class="row mt-3 mb-4">
                    <dt class="col-sm-3">Tanggal Mulai</dt>
                    <dd class="col-sm-9">{{ $season->tanggal_mulai?->format('d-m-Y') ?: '-' }}</dd>
                    <dt class="col-sm-3">Tanggal Selesai</dt>
                    <dd class="col-sm-9">{{ $season->tanggal_selesai?->format('d-m-Y') ?: '-' }}</dd>
                </dl>

                <h5 class="mb-3">Klub Peserta</h5>
                <div class="table-responsive">
                    <table id="season-club-table" class="table table-bordered table-striped align-middle w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Klub</th>
                                <th>Atlet Ikut Serta</th>
                                <th>MP</th>
                                <th>W</th>
                                <th>L</th>
                                <th>PP</th>
                                <th>LP</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.11/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.11/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.11/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(function() {
            $('#season-club-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.season.show', $season) }}',
                language: {
                    processing: 'Memuat...',
                    search: 'Cari:',
                    lengthMenu: 'Tampilkan _MENU_ data',
                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                    infoEmpty: 'Tidak ada data',
                    zeroRecords: 'Data tidak ditemukan',
                    paginate: {
                        first: 'Awal',
                        last: 'Akhir',
                        next: 'Berikutnya',
                        previous: 'Sebelumnya'
                    }
                },
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                }, {
                    data: 'klub_nama',
                    name: 'klub_nama'
                }, {
                    data: 'atlet_nama',
                    name: 'atlet_nama',
                    orderable: false,
                    searchable: false
                }, {
                    data: 'mp',
                    name: 'mp'
                }, {
                    data: 'w',
                    name: 'w'
                }, {
                    data: 'l',
                    name: 'l'
                }, {
                    data: 'pp',
                    name: 'pp'
                }, {
                    data: 'lp',
                    name: 'lp'
                }]
            });
        });
    </script>
@endsection
