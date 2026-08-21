@extends('layouts.app')

@section('content')
    <div class="auth-card">
        <div class="auth-card-body">
            <div class="auth-mark">N</div>
            <h1 class="auth-title h3">Buat akun admin</h1>
            <p class="auth-subtitle">Ini adalah langkah awal untuk menyiapkan akses ke aplikasi CMS. Kode OTP akan dikirim ke
                email Anda.</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="auth-label">Nama admin</label>
                    <input id="name" type="text" class="form-control auth-input @error('name') is-invalid @enderror"
                        name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="auth-label">Alamat email</label>
                    <input id="email" type="email"
                        class="form-control auth-input @error('email') is-invalid @enderror" name="email"
                        value="{{ old('email') }}" required autocomplete="email">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="auth-label">Kata sandi</label>
                    <input id="password" type="password"
                        class="form-control auth-input @error('password') is-invalid @enderror" name="password" required
                        autocomplete="new-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password-confirm" class="auth-label">Ulangi kata sandi</label>
                    <input id="password-confirm" type="password" class="form-control auth-input"
                        name="password_confirmation" required autocomplete="new-password">
                </div>

                <button type="submit" class="btn btn-primary auth-button">Kirim kode OTP</button>
            </form>
        </div>
    </div>
@endsection
