@extends('admin.layouts.app')

@section('content')
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title mb-0">Pilih Club</h3>
            </div>
            <div class="card-body">
                <p class="text-muted">Pilih club untuk melihat dan mengelola riwayat liganya.</p>
                <form action="{{ route('admin.klub-riwayat.index') }}" method="GET" id="pilih-klub-form">
                    <div class="row align-items-end">
                        <div class="col-md-8 mb-3 mb-md-0">
                            <label for="klub_id" class="form-label">Nama Club</label>
                            <select id="klub_id" class="form-select" required>
                                <option value="">Cari nama club...</option>
                                @foreach ($klubs as $klub)
                                    <option value="{{ $klub->id }}">{{ $klub->nama_klub }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-check-circle me-1"></i> Konfirmasi Club
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
            $('#klub_id').select2({
                theme: 'bootstrap-5',
                placeholder: 'Cari nama club...',
                width: '100%'
            });

            $('#pilih-klub-form').on('submit', function(event) {
                event.preventDefault();
                const klubId = $('#klub_id').val();
                if (klubId) {
                    window.location.href = '{{ url('admin/klub-riwayat/klub') }}/' + klubId;
                }
            });
        });
    </script>
@endsection
