@extends('admin.layouts.app')

@section('content')
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title mb-0">Pilih Atlet</h3>
            </div>
            <div class="card-body">
                <p class="text-muted">Pilih atlet untuk melihat dan mengelola riwayat turnamennya.</p>
                <form action="{{ route('admin.atlet-riwayat.index') }}" method="GET" id="pilih-atlet-form">
                    <div class="row align-items-end">
                        <div class="col-md-8 mb-3 mb-md-0">
                            <label for="atlet_id" class="form-label">Nama Atlet</label>
                            <select id="atlet_id" class="form-select" required>
                                <option value="">Cari nama atlet...</option>
                                @foreach ($atlets as $atlet)
                                    <option value="{{ $atlet->id }}">{{ $atlet->nama_atlet }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-check-circle me-1"></i> Konfirmasi Atlet
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            $('#atlet_id').select2({
                theme: 'bootstrap-5',
                placeholder: 'Cari nama atlet...',
                width: '100%'
            });

            $('#pilih-atlet-form').on('submit', function(event) {
                event.preventDefault();
                const atletId = $('#atlet_id').val();

                if (atletId) {
                    window.location.href = '{{ url('admin/atlet-riwayat/atlet') }}/' + atletId;
                }
            });
        });
    </script>
@endsection
