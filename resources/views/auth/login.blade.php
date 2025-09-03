@extends('layouts.app')

@section('auth')
<div class="col-md-8 col-lg-6 col-xxl-4 mx-auto">
    <div class="card shadow-lg border-0 rounded-lg overflow-hidden">
        
        {{-- BAGIAN HEADER KARTU --}}
        <div class="card-header border-0 text-center py-4 bg-light">
            <a href="/" class="d-inline-block">
                <img src="{{ asset('assets/img/logo.png') }}" width="150" alt="Logo Desa">
            </a>
            <h3 class="fw-bold mt-3 mb-0">{{ $nm_desa ?? config('app.name') }}</h3>
            <p class="text-muted mb-0">Silakan login untuk melanjutkan</p>
        </div>

        {{-- BAGIAN BODY KARTU --}}
        <div class="card-body p-4 p-sm-5">
            
            {{-- Menampilkan Pesan Error dan Sukses --}}
            @if (session('password-success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('password-success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Menampilkan Notifikasi Login Gagal --}}
            @error('email')
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @enderror

            {{-- FORM LOGIN --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                {{-- Menggunakan Floating Labels untuk tampilan lebih modern --}}
                <div class="form-floating mb-3">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                    <label for="email">Alamat Email</label>
                </div>

                <div class="form-floating mb-4">
                    <input type="password" class="form-control" id="password" name="password" required placeholder="Password">
                    <label for="password">Password</label>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">
                            Ingat saya
                        </label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-decoration-none text-primary fw-bold small">Lupa Password?</a>
                    @endif
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg fw-bold">Login</button>
                </div>
            </form>

            <hr class="my-4">

            <div class="text-center">
                @if (Route::has('register'))
                    <p class="mb-0 small">Belum punya akun? <a href="{{ route('register') }}" class="text-primary fw-bold">Daftar</a></p>
                @endif
                <p class="mb-0 small mt-2">atau kembali ke <a href="/" class="text-primary fw-bold">Halaman Utama</a></p>
            </div>
            
        </div>
    </div>
</div>
@endsection