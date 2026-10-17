@extends('admin.layouts.app')

@section('content')
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="card-title mb-1">Riwayat Liga:</h3>
                    <span class="text-muted fw-bold mb-0"> {{ $klub->nama_klub }}</span>
                </div>
                <div class="d-flex justify-content-between gap-1 ms-auto">
                    <a href="{{ route('admin.klub-riwayat.index') }}" class="btn btn-secondary btn-sm ms-auto">
                        <i class="bi bi-building me-1"></i> Ganti Club
                    </a>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#riwayatModal" data-mode="create">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Riwayat
                    </button>
                </div>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="table-responsive">
                    <table id="riwayat-liga-table" class="table table-bordered table-striped align-middle w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Liga</th>
                                <th>Hasil Liga</th>
                                <th>Tanggal Liga</th>
                                <th>Poin Liga</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="riwayatModal" tabindex="-1" aria-labelledby="riwayatModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="riwayatModalLabel">Tambah Riwayat Liga</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="riwayat-liga-form" action="{{ route('admin.klub-riwayat.store', $klub) }}" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="riwayat-liga-method" value="POST" disabled>
                    <div class="modal-body">
                        @include('admin.klub-riwayat.partials.form')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="bi bi-save me-1"></i> <span id="riwayat-liga-submit-label">Simpan</span>
                        </button>
                    </div>
                </form>
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
            const riwayatModal = $('#riwayatModal');
            const riwayatForm = $('#riwayat-liga-form');
            const riwayatMethod = $('#riwayat-liga-method');
            const riwayatStoreUrl = riwayatForm.attr('action');

            const table = $('#riwayat-liga-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.klub-riwayat.manage', $klub) }}',
                order: [],
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
                        data: 'nama_liga',
                        name: 'nama_liga'
                    },
                    {
                        data: 'hasil_liga',
                        name: 'hasil_liga'
                    },
                    {
                        data: 'tanggal_liga',
                        name: 'tanggal_liga'
                    },
                    {
                        data: 'poin_liga',
                        name: 'poin_liga'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ]
            });

            riwayatModal.on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const isEdit = button.hasClass('edit-riwayat-liga-button');

                $('#riwayatModalLabel').text(isEdit ? 'Edit Riwayat Liga' : 'Tambah Riwayat Liga');
                $('#riwayat-liga-submit-label').text(isEdit ? 'Simpan Perubahan' : 'Simpan');

                if (isEdit) {
                    riwayatForm.attr('action', button.data('update-url'));
                    riwayatMethod.prop('disabled', false).val('PUT');
                    $('#nama_liga').val(button.data('nama-liga'));
                    $('#hasil_liga').val(button.data('hasil-liga')).trigger('change');
                    $('#tanggal_liga').val(button.data('tanggal-liga'));
                    $('#poin_liga').val(button.data('poin-liga'));
                } else {
                    riwayatForm.attr('action', riwayatStoreUrl);
                    riwayatMethod.prop('disabled', true).val('POST');
                    riwayatForm[0].reset();
                    $('#hasil_liga').val('').trigger('change');
                }
            });

            $(document).on('submit', '.delete-riwayat-liga-form', function(event) {
                event.preventDefault();
                const form = this;

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: 'Riwayat liga ini akan dihapus permanen.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                                url: form.action,
                                type: 'POST',
                                data: $(form).serialize()
                            })
                            .done(function() {
                                table.ajax.reload(null, false);
                            });
                    }
                });
            });
        });
    </script>
@endsection
