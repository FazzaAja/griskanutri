@extends('layouts.landing')

@section('title', $resep->judul)

@push('styles')
<style>
    body { background-color: #f8f9fa; }
    .recipe-container {
        max-width: 1100px;
        margin: 2rem auto;
        padding: 1rem;
    }

    /* STRUKTUR GRID UTAMA */
    .recipe-layout-grid {
        display: grid;
        grid-template-columns: 1fr; /* Default 1 kolom untuk mobile */
        gap: 1.5rem;
    }

    /* KARTU KONTEN */
    .recipe-card {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        padding: 1.5rem;
    }

    /* GAMBAR OVERLAY HANYA UNTUK MOBILE */
    .recipe-image-block {
        position: relative;
        color: white;
        border-radius: 8px;
        overflow: hidden;
    }
    .recipe-image-block {
        position: relative;
        color: white;
        border-radius: 8px;
        overflow: hidden;
        background-color: #fff; /* Tambahkan background agar ruang kosong terlihat bersih */
        border: 1px solid #eee; /* Tambahkan border agar rapi */
    }
    .recipe-image-block .main-image {
        width: 100%;
        height: 100%; /* Biarkan tinggi gambar menyesuaikan secara otomatis */
        max-height: 400px; /* Anda bisa mengatur tinggi maksimal */
        object-fit: contain; /* <-- INI KUNCINYA */
        display: block;
    }
    .recipe-image-block .recipe-title-overlay {
        position: absolute;
        bottom: 0; left: 0; right: 0;
        padding: 1.5rem;
        font-size: 1.8rem;
        font-weight: 700;
        background: linear-gradient(to top, rgba(0,0,0,0.85), transparent);
    }

    /* JUDUL, DESKRIPSI, NUTRISI (Blok Utama) */
    .section-title-recipe {
        font-size: 1.5rem; font-weight: 600;
        margin-bottom: 1rem; padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--primary-color, #4682b4);
    }
    .styled-list li { list-style: none; padding: 0.75rem 0; border-bottom: 1px solid #f1f1f1; }
    .steps-list { list-style: none; padding-left: 0; }
    .steps-list li { display: flex; align-items: flex-start; margin-bottom: 1.5rem; }
    .steps-list .step-number {
        background-color: var(--primary-color, #4682b4); color: white;
        font-weight: 700; border-radius: 50%;
        min-width: 30px; height: 30px;
        display: flex; align-items: center; justify-content: center;
        margin-right: 15px; flex-shrink: 0;
    }
    .nutrition-section {
        margin-top: 10px;
        display: flex; flex-wrap: wrap; justify-content: space-around;
        text-align: center; background-color: #f8f9fa;
        border-radius: 8px; padding: 1rem; margin-bottom: 2rem;
        border: 1px solid #eee;
    }
    .nutrition-item { padding: 0.5rem; }
    .nutrition-item .value { display: block; font-size: 1.5rem; font-weight: 600; color: var(--primary-color, #4682b4); }
    .nutrition-item .label { font-size: 0.85rem; color: #6c757d; }
    .recipe-title-desktop {
        font-family: var(--header-font, "Poppins", sans-serif);
        font-size: 2.5rem; font-weight: 700; margin-bottom: 1rem;
    }
    .placeholder-container {
        width: 100%;
        height: 400px; /* Samakan dengan tinggi gambar mobile */
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #e9ecef;
        color: #6c757d;
        border-radius: 8px;
        font-weight: 500;
    }

    /* ... CSS Anda yang sudah ada ... */

    /* --- TAMBAHKAN KODE INI DI BAGIAN BAWAH CSS ANDA --- */

    /* Pengaturan Default (Mobile-First) */
    /* Sembunyikan judul versi desktop secara default */
    .recipe-title-desktop {
        display: none;
    }

    /* Aturan untuk layar lebar (desktop) dengan lebar minimal 992px */
    @media (min-width: 992px) {
        /* Sembunyikan judul overlay (yang di atas gambar) di desktop */
        .recipe-image-block .recipe-title-overlay {
            display: none;
        }

        /* Tampilkan kembali judul versi desktop */
        .recipe-title-desktop {
            display: block;
        }
    }

    /* Ubah juga di bagian media query untuk desktop */
    @media (min-width: 992px) {
        /* ... style desktop lain ... */
        .d-none.d-lg-block .recipe-card {
            display: flex; /* Tambahan agar gambar di tengah */
            align-items: center;
            justify-content: center;
        }
        .d-none.d-lg-block .recipe-card img {
            width: 100%;
            object-fit: contain; /* <-- UBAH DI SINI */
            border-radius: 8px;
            max-height: 450px; /* Batasi tinggi maksimal di desktop */
        }
    }

    /* Aturan untuk 2 kolom di layar lebar (desktop) */
    @media (min-width: 992px) {
        .recipe-layout-grid {
            grid-template-columns: 1fr 1.5fr; /* 2 kolom */
            gap: 0.5rem;
            align-items: start; /* <-- TAMBAHKAN INI */
        }

        /* Tentukan posisi setiap blok di dalam grid */
        .recipe-image-block {
            grid-column: 1 / 2; /* Kolom pertama */
            grid-row: 1 / 2; /* Baris pertama */
        }
        .recipe-ingredients-block {
            grid-column: 1 / 2; /* Kolom pertama */
            grid-row: 2 / 3; /* Baris kedua */
        }
        .recipe-main-info-block {
            grid-column: 2 / 3; /* Kolom kedua */
            grid-row: 1 / 2; /* Baris pertama */
        }
        .recipe-steps-block {
            grid-column: 2 / 3; /* Kolom kedua */
            grid-row: 2 / 3; /* Baris kedua */
        }

        /* Sembunyikan judul overlay mobile di desktop */
        .recipe-image-block .recipe-title-overlay {
            display: none;
        }

        /* Tambahkan ini di dalam @media (min-width: 992px) */
        .recipe-ingredients-block {
            position: -webkit-sticky; /* Untuk Safari */
            position: sticky;
            top: 100px; /* Jarak dari atas layar saat menempel */
        }
    }

    /* Aturan untuk layar dengan lebar maksimal 768px (tablet dan ponsel) */
    @media (max-width: 768px) {
        .nutrition-section {
            display: grid; /* Ganti layout menjadi Grid */
            grid-template-columns: 1fr 1fr; /* Buat 2 kolom sama lebar */
            gap: 1rem; /* Beri jarak antar item */
            justify-content: center; /* Pastikan item di tengah jika ada ruang */
            padding: 1.5rem; /* Sesuaikan padding agar lebih pas */
        }
    }
</style>
@endpush

@section('content')
<div class="container recipe-container">
    <div class="recipe-layout-grid">

        {{-- BLOK 1: GAMBAR (Header Mobile & Gambar Desktop) --}}
        <div class="recipe-image-block">
            @if($resep->img)
                <img src="{{ asset('images/reseps/' . $resep->img) }}" alt="{{ $resep->judul }}" class="main-image">
            @else
                <div class="placeholder-container">
                    <span>Foto tidak tersedia</span>
                </div>
            @endif
            <h1 class="recipe-title-overlay">{{ $resep->judul }}</h1>
        </div>

        {{-- BLOK 2: INFO UTAMA (Judul Desktop, Deskripsi, Nutrisi) --}}
        <div class="recipe-main-info-block recipe-card">
            <h1 class="recipe-title-desktop">{{ $resep->judul }}</h1>
            <p>{{ $resep->deskripsi }}</p>
            @if($resep->nutrisi)
                    {{-- NUTRISI --}}
                @if($resep->nutrisi)
                <div class="nutrition-section">
                    <div class="nutrition-item">
                        <span class="value">{{ $resep->nutrisi->kalori }}</span>
                        <span class="label">Kalori (kcal)</span>
                    </div>
                    <div class="nutrition-item">
                        <span class="value">{{ $resep->nutrisi->protein }}g</span>
                        <span class="label">Protein</span>
                    </div>
                    <div class="nutrition-item">
                        <span class="value">{{ $resep->nutrisi->karbo }}g</span>
                        <span class="label">Karbohidrat</span>
                    </div>
                    <div class="nutrition-item">
                        <span class="value">{{ $resep->nutrisi->lemak }}g</span>
                        <span class="label">Lemak</span>
                    </div>
                </div>
                @endif
            @endif
        </div>

        {{-- BLOK 3: BAHAN & ALAT --}}
        <div class="recipe-ingredients-block recipe-card">
            <h2 class="section-title-recipe">Bahan & Alat</h2>
            <ul class="styled-list ps-0">
                @foreach($resep->bahan as $bahan)
                    <li>{{ $bahan }}</li>
                @endforeach
                @foreach($resep->alat as $alat)
                    <li>{{ $alat }}</li>
                @endforeach
            </ul>
        </div>

        {{-- BLOK 4: LANGKAH-LANGKAH --}}
        <div class="recipe-steps-block recipe-card">
            <h2 class="section-title-recipe">Cara Membuat</h2>
            <ol class="steps-list">
                @foreach($resep->langkah as $langkah)
                    <li>
                        <span class="step-number">{{ $loop->iteration }}</span>
                        <p>{{ $langkah }}</p>
                    </li>
                @endforeach
            </ol>
        </div>

    </div>
</div>
@endsection
