@extends('layouts.auth')

@section('title', 'Login — Lapak Second')

@section('content')
<div class="auth-card">

    <a href="/" class="auth-logo">
        <div class="logo-dot"></div>
        Lapak Second
    </a>

    <h1 class="auth-title">Selamat Datang </h1>
    <p class="auth-sub">Masuk untuk mulai belanja elektronik pilihan.</p>

    {{-- Error --}}
    @if ($errors->any())
        <div class="alert alert-error">
            <i class="fas fa-circle-exclamation"></i>
            {{ $errors->first() }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            <i class="fas fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- ══ GOOGLE LOGIN ══ --}}
    <a href="{{ route('google.redirect') }}" class="google-btn">
        <svg width="18" height="18" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
            <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
            <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
            <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
            <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
        </svg>
        Lanjutkan dengan Google
    </a>

    <div class="divider">atau masuk dengan email</div>

    {{-- ══ EMAIL LOGIN ══ --}}
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label class="form-label">Email</label>
            <div class="input-wrap">
                <i class="fas fa-envelope input-icon"></i>
                <input type="email" name="email"
                       class="form-input @error('email') is-invalid @enderror"
                       placeholder="name@email.com"
                       value="{{ old('email') }}"
                       autocomplete="email" required>
            </div>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Password</label>
            <div class="input-wrap">
                <i class="fas fa-lock input-icon"></i>
                <input type="password" name="password" id="password"
                       class="form-input has-toggle @error('password') is-invalid @enderror"
                       placeholder="••••••••"
                       autocomplete="current-password" required>
                <button type="button" class="toggle-pass" onclick="togglePassword('password')">
                    <i class="fas fa-eye" id="password-icon"></i>
                </button>
            </div>
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="check-row">
            <label class="check-label">
                <input type="checkbox" name="remember"> Ingat saya
            </label>
        </div>

        <button type="submit" class="submit-btn">
            <i class="fas fa-arrow-right-to-bracket"></i>
            Masuk Sekarang
        </button>
    </form>

    <div class="auth-footer">
        Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
    </div>

</div>
@endsection
