@extends('admin.layouts.app')

@section('content')
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="card-title mb-1">Riwayat Turnamen :</h3>
                    <p class="text-muted fw-bold">{{ $atlet->nama_atlet }}</p>
                </div>
                <div class="d-flex justify-content-between gap-1 ms-auto">
                    <a href="{{ route('admin.atlet-riwayat.index') }}" class="btn btn-secondary btn-sm ms-auto">
                        <i class="bi bi-person-fill me-1"></i> Ganti Atlet
                    </a>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#riwayatModal" data-mode="create">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Riwayat
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="riwayat-table" class="table table-bordered table-striped align-middle w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Turnamen</th>
                                <th>Tanggal</th>
                                <th>Hasil</th>
                                <th>Poin</th>
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
                    <h5 class="modal-title" id="riwayatModalLabel">Tambah Riwayat Turnamen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="riwayat-form" action="{{ route('admin.atlet-riwayat.store', $atlet) }}" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="riwayat-method" value="POST" disabled>
                    <div class="modal-body">
                        @include('admin.atlet-riwayat.partials.form')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="bi bi-save me-1"></i> <span id="riwayat-submit-label">Simpan</span>
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
            const riwayatForm = $('#riwayat-form');
            const riwayatMethod = $('#riwayat-method');
            const riwayatStoreUrl = riwayatForm.attr('action');

            const table = $('#riwayat-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.atlet-riwayat.manage', $atlet) }}',
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
                        data: 'hasil_turnamen',
                        name: 'hasil_turnamen'
                    },
                    {
                        data: 'poin_turnamen',
                        name: 'poin_turnamen'
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
                const isEdit = button.hasClass('edit-riwayat-button');

                $('#riwayatModalLabel').text(isEdit ? 'Edit Riwayat Turnamen' : 'Tambah Riwayat Turnamen');
                $('#riwayat-submit-label').text(isEdit ? 'Simpan Perubahan' : 'Simpan');

                if (isEdit) {
                    riwayatForm.attr('action', button.data('update-url'));
                    riwayatMethod.prop('disabled', false).val('PUT');
                    $('#nama_turnamen').val(button.data('nama-turnamen'));
                    $('#tanggal_turnamen').val(button.data('tanggal-turnamen'));
                    $('#hasil_turnamen').val(button.data('hasil-turnamen'));
                    $('#poin_turnamen').val(button.data('poin-turnamen'));
                } else {
                    riwayatForm.attr('action', riwayatStoreUrl);
                    riwayatMethod.prop('disabled', true).val('POST');
                    riwayatForm[0].reset();
                    $('#hasil_turnamen').val('');
                }
            });

            $(document).on('submit', '.delete-riwayat-form', function(event) {
                event.preventDefault();
                const form = this;

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: 'Riwayat turnamen ini akan dihapus permanen.',
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
                        }).done(function() {
                            table.ajax.reload(null, false);
                        });
                    }
                });
            });
        });
    </script>
@endsection
