@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Verifikasi Email</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">{{ session('status') }}</div>
                        @endif

                        <p>Kode OTP telah dikirim ke <strong>{{ $email }}</strong>.</p>

                        <form method="POST" action="{{ route('register.verify.submit') }}">
                            @csrf
                            <div class="row mb-3">
                                <label for="code" class="col-md-4 col-form-label text-md-end">Kode OTP</label>
                                <div class="col-md-6">
                                    <input id="code" type="text" inputmode="numeric" pattern="[0-9]{6}"
                                        maxlength="6" class="form-control @error('code') is-invalid @enderror"
                                        name="code" required autofocus>
                                    @error('code')
                                        <span class="invalid-feedback"
                                            role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Verifikasi dan Masuk</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
