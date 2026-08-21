@extends('layouts.app')

@section('content')
    <div class="auth-card">
        <div class="auth-card-body">
            <div class="auth-mark">N</div>
            <h1 class="auth-title h3">Verifikasi email</h1>
            <p class="auth-subtitle">Masukkan kode OTP 6 digit yang kami kirim ke <strong>{{ $email }}</strong>.</p>
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('register.verify.submit') }}">
                @csrf
                <div class="mb-4">
                    <label for="code" class="auth-label">Kode OTP</label>
                    <input id="code" type="text" inputmode="numeric" pattern="[0-9]{6}" maxlength="6"
                        class="form-control auth-input @error('code') is-invalid @enderror" name="code" required
                        autofocus>
                    @error('code')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary auth-button">Verifikasi dan masuk</button>
            </form>
        </div>
    </div>
@endsection
