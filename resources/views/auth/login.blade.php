@extends('layouts.app')

@section('content')
    <div class="auth-card">
        <div class="auth-card-body">
            <div class="auth-mark">N</div>
            <h1 class="auth-title h3">Selamat datang di aplikasi CMS</h1>
            <p class="auth-subtitle">Silakan masukkan akun admin Anda untuk melanjutkan.</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="auth-label">Alamat email</label>
                    <input id="email" type="email"
                        class="form-control auth-input @error('email') is-invalid @enderror" name="email"
                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="auth-label">Kata sandi</label>
                    <input id="password" type="password"
                        class="form-control auth-input @error('password') is-invalid @enderror" name="password" required
                        autocomplete="current-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label auth-note" for="remember">Ingat saya</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a class="auth-note text-decoration-none" href="{{ route('password.request') }}">Lupa kata
                            sandi?</a>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary auth-button">Masuk ke CMS</button>
            </form>
        </div>
    </div>
@endsection
