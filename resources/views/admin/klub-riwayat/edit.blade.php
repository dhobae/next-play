@extends('admin.layouts.app')

@section('content')
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="card-title mb-1">Edit Riwayat Liga</h3>
                    <div class="text-muted">{{ $klub->nama_klub }}</div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.klub-riwayat.update', [$klub, $riwayat]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('admin.klub-riwayat.partials.form', ['riwayat' => $riwayat])
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.klub-riwayat.manage', $klub) }}" class="btn btn-secondary btn-sm">Batal</a>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
