@extends('admin.layouts.app')

@section('content')
    <div class="col-12">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Profil</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email saat ini</label>
                                <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                            </div>
                            <button class="btn btn-primary" type="submit"><i class="bi bi-save me-1"></i>Simpan
                                Profil</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Ganti Password</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.profile.password.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="password" class="form-label">Password baru</label>
                                <input type="password" name="password" id="password" class="form-control" minlength="8"
                                    required autocomplete="new-password">
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi password baru</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control" minlength="8" required autocomplete="new-password">
                            </div>
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-key me-1"></i>Ganti Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
