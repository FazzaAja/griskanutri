@extends('layouts.landing') {{-- Atau layout lain yang sesuai --}}

@section('title', 'Login')

@push('styles')
<style>
    /* Menghapus padding default dari section content jika ada */
    .auth-page-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        background-color: #f8f9fa;
    }

    .auth-container {
        width: 100%;
        max-width: 900px;
        margin: 2rem;
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        overflow: hidden;
        display: flex;
    }

    /* Kolom Kiri - Gambar Branding */
    .auth-branding-side {
        flex-basis: 45%;
        background: linear-gradient(to top, rgba(70, 130, 180, 0.8), rgba(70, 130, 180, 0.9)),
                    url('https://images.unsplash.com/photo-1554118811-4c1c12535b3c?q=80&w=1770&auto=format&fit=crop') no-repeat center center/cover;
        color: white;
        padding: 3rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .auth-branding-side h2 {
        font-size: 2rem;
        font-weight: 700;
        color: white;
        margin-bottom: 1rem;
    }
    .auth-branding-side p {
        font-size: 1rem;
        opacity: 0.9;
    }

    /* Kolom Kanan - Form Login */
    .auth-form-side {
        flex-basis: 55%;
        padding: 3rem;
    }
    .auth-form-side h3 {
        font-size: 1.8rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--text-color, #333);
    }
    .auth-form-side .subtitle {
        color: #6c757d;
        margin-bottom: 2rem;
    }
    /* Ganti selector .form-control menjadi lebih spesifik */
    .auth-form-side .form-control {
        height: 50px;
        border-radius: 8px;
        border: 1px solid #ced4da;
        width: 100%; /* Pastikan lebar input penuh */
    }
    .form-control:focus {
        border-color: var(--primary-color, #4682b4);
        box-shadow: 0 0 0 0.25rem rgba(70, 130, 180, 0.25);
    }
    .btn-login {
        height: 50px;
        border-radius: 8px;
        font-weight: 600;
        background-color: var(--primary-color, #4682b4);
        border: none;
    }
    .auth-footer {
        text-align: center;
        margin-top: 1.5rem;
        font-size: 0.9rem;
    }

    /* ... style lain ... */

    .auth-form-side .form-label {
        margin-bottom: 0.5rem; /* Memberi jarak antara label dan input */
        font-weight: 500; /* Sedikit menebalkan font label */
        color: #495057;
    }

    .auth-form-side .form-control {
        height: 50px;
        border-radius: 8px;
        border: 1px solid #ced4da;
        width: 100%;
        /* Perbaikan Font di Dalam Input */
        font-size: 1rem; /* Sesuaikan ukuran font */
        padding: 0.75rem 1rem; /* Atur padding internal */
    }

    /* ... style lain ... */

    /* Responsif untuk Mobile */
    @media (max-width: 768px) {
        .auth-container {
            flex-direction: column;
            margin: 1rem;
        }
        .auth-branding-side {
            display: none; /* Sembunyikan gambar di mobile agar form lebih fokus */
        }
        .auth-form-side {
            padding: 2rem;
        }
    }
</style>
@endpush

@section('content')
<div class="auth-page-wrapper">
    <div class="auth-container">

        {{-- SISI KIRI - GAMBAR BRANDING --}}
        <div class="auth-branding-side">
            <h2>Masuk Sebagai Admin</h2>
            <p>Masuk untuk melanjutkan dan mengakses semua fitur resep dan materi kesehatan.</p>
        </div>

        {{-- SISI KANAN - FORM LOGIN --}}
        <div class="auth-form-side">
            <h3>Login Akun</h3>
            {{-- <p class="subtitle">Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p> --}}

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="d-grid mt-4">
                    <br>
                    <button type="submit" class="btn btn-primary btn-login">Login</button>
                </div>
            </form>

            {{-- <div class="auth-footer">
                <a href="#">Lupa Password?</a>
            </div> --}}
        </div>

    </div>
</div>
@endsection
