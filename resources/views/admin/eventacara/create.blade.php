@extends('admin.layouts.app')

@section('content')
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Tambah Event</h3>
                <a href="{{ route('admin.eventacara.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
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

                <form action="{{ route('admin.eventacara.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('admin.eventacara.partials.form')
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.eventacara.index') }}" class="btn btn-secondary btn-sm">Batal</a>
                        <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-save me-1"></i>
                            Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
