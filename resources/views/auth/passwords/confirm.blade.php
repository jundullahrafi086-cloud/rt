@extends('layouts.app')

@section('auth')
<div class="col-md-8 col-lg-6 col-xxl-4 mx-auto">
    <div class="card shadow-lg border-0 rounded-lg overflow-hidden">
        
        {{-- BAGIAN HEADER KARTU --}}
        <div class="card-header border-0 text-center py-4 bg-light">
            <div class="d-inline-block bg-primary text-white p-3 rounded-circle mb-3">
                <i class="bi bi-shield-lock-fill fs-2"></i>
            </div>
            <h3 class="fw-bold mb-1">{{ __('Konfirmasi Password') }}</h3>
            <p class="text-muted mb-0">{{ __('Untuk keamanan, mohon konfirmasi password Anda untuk melanjutkan.') }}</p>
        </div>

        {{-- BAGIAN BODY KARTU --}}
        <div class="card-body p-4 p-sm-5">
            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                {{-- Menggunakan Floating Labels --}}
                <div class="form-floating mb-4">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                    <label for="password">{{ __('Password') }}</label>

                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary btn-lg fw-bold">
                        {{ __('Konfirmasi Password') }}
                    </button>
                </div>
                
                <div class="text-center">
                    @if (Route::has('password.request'))
                        <a class="btn btn-link text-decoration-none small" href="{{ route('password.request') }}">
                            {{ __('Lupa Password Anda?') }}
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection