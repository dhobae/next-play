@extends('admin.layouts.app')
@section('content')
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Data Season</h3>
                <a href="{{ route('admin.season.create') }}" class="btn btn-primary btn-sm ms-auto"><i
                        class="bi bi-plus-circle me-1"></i>Tambah Season</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="season-table" class="table table-bordered table-striped align-middle w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Season</th>
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th class="text-center">Aksi</th>
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
            $('#season-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.season.index') }}',
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
                    data: 'nama_season',
                    name: 'nama_season'
                }, {
                    data: 'tanggal_mulai',
                    name: 'tanggal_mulai'
                }, {
                    data: 'tanggal_selesai',
                    name: 'tanggal_selesai'
                }, {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                }]
            });

            $(document).on('submit', '.delete-form', function(event) {
                event.preventDefault();
                const form = this;

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: 'Data season ini akan dihapus permanen.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
