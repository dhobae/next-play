@extends('admin.layouts.app')
@section('content')
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title mb-0">Edit Klub</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.klub.update', $klub) }}" method="POST" enctype="multipart/form-data">@csrf
                    @method('PUT') @include('admin.klub.partials.form')<div class="d-flex justify-content-end gap-2"><a
                            href="{{ route('admin.klub.index') }}" class="btn btn-secondary btn-sm">Batal</a><button
                            class="btn btn-primary btn-sm"><i class="bi bi-save me-1"></i>Simpan Perubahan</button></div>
                </form>
            </div>
        </div>
    </div>
@endsection
