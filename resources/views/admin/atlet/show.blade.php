@extends('admin.layouts.app')

@section('content')
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Detail Atlet</h3>
                <div class="d-flex gap-2 ms-auto">
                    <a href="{{ route('admin.atlet.edit', $atlet) }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil-square me-1"></i> Edit
                    </a>
                    {{-- <a href="{{ route('admin.atlet.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a> --}}
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 text-center mb-4 mb-md-0">
                        @if ($atlet->foto_atlet)
                            <img src="{{ asset('storage/' . $atlet->foto_atlet) }}" alt="{{ $atlet->nama_atlet }}"
                                class="img-fluid rounded" style="max-height: 320px; object-fit: cover;">
                        @else
                            <div class="text-muted py-5">Tidak ada foto atlet.</div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <h4>{{ $atlet->nama_atlet }}</h4>
                        <dl class="row mt-3">
                            <dt class="col-sm-4">Level</dt>
                            <dd class="col-sm-8">{{ $atlet->level }}</dd>
                            <dt class="col-sm-4">Jenis Kelamin</dt>
                            <dd class="col-sm-8">{{ $atlet->jenis_kelamin === 0 ? 'Laki-laki' : 'Perempuan' }}</dd>
                            <dt class="col-sm-4">Klub/Asosiasi</dt>
                            <dd class="col-sm-8">{{ $atlet->klub_asosiasi }}</dd>
                            <dt class="col-sm-4">Tempat, Tanggal Lahir</dt>
                            <dd class="col-sm-8">{{ $atlet->tempat_lahir }},
                                {{ $atlet->tanggal_lahir?->format('d-m-Y') ?: '-' }}</dd>
                            <dt class="col-sm-4">Kebangsaan</dt>
                            <dd class="col-sm-8">{{ $atlet->kebangsaan }}</dd>
                        </dl>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col-12 mt-3">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title mb-0">Riwayat Turnamen</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="atlet-history-table" class="table table-bordered table-striped align-middle w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Turnamen</th>
                                <th>Tanggal</th>
                                <th>Hasil</th>
                                <th>Poin</th>
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
            $('#atlet-history-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.atlet.show', $atlet) }}',
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
                    },
                    {
                        data: 'nama_turnamen',
                        name: 'nama_turnamen'
                    },
                    {
                        data: 'tanggal_turnamen',
                        name: 'tanggal_turnamen'
                    },
                    {
                        data: 'hasil_display',
                        name: 'hasil_turnamen',
                        orderable: false
                    },
                    {
                        data: 'poin_turnamen',
                        name: 'poin_turnamen'
                    }
                ]
            });
        });
    </script>
@endsection
