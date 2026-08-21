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
                            <div class="mb-3"><label for="password" class="form-label">Password baru</label><input
                                    type="password" name="password" id="password" class="form-control" minlength="8"
                                    required></div>
                            <div class="mb-3"><label for="password_confirmation" class="form-label">Konfirmasi password
                                    baru</label><input type="password" name="password_confirmation"
                                    id="password_confirmation" class="form-control" minlength="8" required></div>
                            <button class="btn btn-primary" type="submit"><i class="bi bi-key me-1"></i>Ganti
                                Password</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Ganti Email</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.profile.email.otp') }}" method="POST" class="mb-4">
                            @csrf
                            <label for="email" class="form-label">Email baru</label>
                            <div class="input-group"><input type="email" name="email" id="email"
                                    class="form-control" value="{{ old('email', $pendingEmail) }}" required><button
                                    class="btn btn-outline-primary" type="submit"><i class="bi bi-send me-1"></i>Kirim
                                    OTP</button></div>
                        </form>
                        @if ($emailChangePending)
                            <form action="{{ route('admin.profile.email.verify') }}" method="POST">
                                @csrf
                                <label for="otp" class="form-label">Kode OTP</label>
                                <div class="input-group"><input type="text" name="otp" id="otp"
                                        class="form-control" inputmode="numeric" maxlength="6" pattern="[0-9]{6}"
                                        required><button class="btn btn-success" type="submit"><i
                                            class="bi bi-check2-circle me-1"></i>Verifikasi</button></div>
                                <small class="text-muted">Masukkan kode 6 digit yang dikirim ke email baru.</small>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
