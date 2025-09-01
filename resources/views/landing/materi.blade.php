@extends('layouts.landing')

@section('title', $materi->judul)

@push('styles')
<style>
    /* Mengatur background halaman agar lebih netral */
    body {
        background-color: #f8f9fa;
    }

    .kurikulum-hero {
        /* Menambahkan background gambar dan overlay gelap */
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
        url("{{ asset('images/img/pembukaan-sekolah-perempuan-griska.jpg') }}") no-repeat center 80%/cover;
        background-size: 100% auto;
        color: white; /* Mengubah warna teks utama menjadi putih */
        text-align: center;
        padding: 6rem 1.5rem;
        display: flex; /* Menggunakan flexbox untuk centering */
        justify-content: center; /* Centering horizontal */
        align-items: center; /* Centering vertikal */
        min-height: 50vh; /* Sesuaikan tinggi sesuai selera */
    }

    /* Pastikan warna heading di dalam hero menjadi putih */
    .kurikulum-hero .hero-content h1 {
        color: white;
        font-size: 3.5rem; /* Sedikit perbesar font */
        font-weight: 700;
    }

    /* Container utama untuk layout Classroom */
    .classroom-container {
        max-width: 1100px;
        margin: 2rem auto;
    }

    /* Kolom utama di kiri */
    .classroom-main-content {
        background-color: #fff;
        border-radius: 8px;
        border: 1px solid #dadce0;
        padding: 24px;
    }

    .classroom-header {
        display: flex;
        align-items: flex-start;
        padding-bottom: 24px;
        border-bottom: 1px solid #dadce0;
    }
    .classroom-header .icon {
        width: 40px;
        height: 40px;
        background-color: var(--primary-color, #4682b4);
        border-radius: 50%;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        margin-right: 16px;
    }
    .classroom-header .title-section h1 {
        font-size: 1.8rem;
        margin-bottom: 4px;
        color: #3c4043;
    }
    .classroom-header .title-section p {
        font-size: 0.85rem;
        color: #5f6368;
        margin-bottom: 0;
    }

    .classroom-body {
        padding-top: 24px;
        font-size: 0.95rem;
        line-height: 1.8;
    }
    .classroom-body h3 {
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }

    /* Bagian Lampiran (Attachment) */
    .attachments-section {
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid #dadce0;
    }
    .attachment-item {
        display: flex;
        align-items: center;
        border: 1px solid #dadce0;
        border-radius: 8px;
        padding: 12px;
        text-decoration: none;
        color: #3c4043;
        transition: background-color 0.2s;
        max-width: 300px; /* Batasi lebar item lampiran */
    }
    .attachment-item:hover {
        background-color: #f1f3f4;
    }
    .attachment-item .file-icon {
        width: 32px;
        height: 32px;
        margin-right: 16px;
    }
    .attachment-item .file-info small {
        display: block;
        color: #5f6368;
        font-size: 0.8rem;
    }

    /* Sidebar di kanan */
    .classroom-sidebar {
        background-color: #fff;
        border-radius: 8px;
        border: 1px solid #dadce0;
        padding: 16px;
    }
    .classroom-sidebar h5 {
        font-size: 1rem;
        font-weight: 600;
        color: #3c4043;
        margin-bottom: 16px;
    }
    .classroom-sidebar .btn {
        width: 100%;
        margin-bottom: 12px;
        padding: 10px;
        font-weight: 500;
    }
    .btn-primary-classroom {
        background-color: var(--primary-color, #4682b4);
        color: white;
    }
    .btn-secondary-classroom {
        background-color: transparent;
        color: var(--primary-color, #4682b4);
        border: 1px solid #dadce0;
    }
    .btn-secondary-classroom:hover {
        background-color: #f1f3f4;
    }

    /* Responsive Design */
    /* Aturan untuk layar dengan lebar maksimal 768px (tablet dan ponsel) */
    @media (max-width: 768px) {
        .kurikulum-hero {
            /* Buat lebih pendek di mobile, misal 50% tinggi layar */
            min-height: 20vh;

            /* Kurangi sedikit padding vertikal agar tidak terlalu makan tempat */
            padding: 4rem 1.5rem;
        }

        .kurikulum-hero .hero-content h1 {
            /* Kecilkan juga ukuran font agar pas */
            font-size: 2.5rem;
        }

        .section-title{
            font-size: 1.5rem;
        }
    }
</style>
@endpush

@section('content')

<header class="kurikulum-hero">
    <div class="hero-content">
        <h1>Kurikulum & Materi</h1>
    </div>
</header>

<div class="container classroom-container">
    <div class="row g-4">
        {{-- Kolom Konten Utama (Kiri) --}}
        <div class="col-lg-8">
            <div class="classroom-main-content">
                {{-- Header Materi --}}
                <div class="classroom-header">
                    <div class="icon">
                        <i class="fa-solid fa-book-open" style="margin: 5px; padding: 5px;"></i>
                    </div>
                    <div class="title-section">
                        <h1>{{ $materi->judul }}</h1>
                        <p>Dibuat pada: {{ $materi->upload_at->format('d F Y') }}</p>
                    </div>
                </div>

                {{-- Isi Materi --}}
                <div class="classroom-body">
                    <h5>Deskripsi</h5>
                    <p>{{ $materi->keterangan }}</p>

                    @if($materi->rangkuman)
                    <h3>Rangkuman Materi</h3>
                    <p>{!! nl2br(e($materi->rangkuman)) !!}</p>
                    @endif

                    {{-- GANTI BLOK VIDEO YANG LAMA DENGAN INI --}}
                    @if($materi->youtube)
                        <div class="mb-5">
                            <h3>Video Pembelajaran</h3>
                            @php
                                $embedUrl = null;
                                $youtubeUrl = $materi->youtube;

                                // Mencoba mengambil ID video dari berbagai format URL YouTube
                                $patterns = [
                                    '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com|youtu\.be)\/(?:watch\?v=)?([a-zA-Z0-9_-]{11})/', // Pola untuk youtu.be/ dan watch?v=
                                ];

                                foreach ($patterns as $pattern) {
                                    if (preg_match($pattern, $youtubeUrl, $matches)) {
                                        $videoId = $matches[1];
                                        $embedUrl = "https://www.youtube.com/embed/" . $videoId;
                                        break;
                                    }
                                }
                            @endphp

                            {{-- Tampilkan video hanya jika URL berhasil diubah --}}
                            @if($embedUrl)
                                <div class="ratio ratio-16x9">
                                    <iframe src="{{ $embedUrl }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    Link video YouTube tidak valid. Pastikan formatnya benar.
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- Lampiran File Materi --}}
                    @if($materi->file)
                    <div class="attachments-section">
                        <h5>Lampiran</h5>
                        <a href="{{ asset('files/' . $materi->file) }}" class="attachment-item" download>
                            {{-- Ganti ikon berdasarkan tipe file jika diperlukan --}}
                            <img src="https://ssl.gstatic.com/docs/doclist/images/mediatype/icon_1_pdf_x16.png" class="file-icon" alt="File Icon">
                            <div class="file-info">
                                <strong>{{ Str::limit($materi->file, 25) }}</strong>
                                <small>File Materi</small>
                            </div>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Kolom Sidebar (Kanan) --}}
        <div class="col-lg-4">
            <div class="classroom-sidebar">
                <h5>Aksi Anda</h5>
                <a href="{{ route('latihan.show', $materi->slug) }}" class="btn btn-primary-classroom">
                    <i class="fa-solid fa-file-pen me-2" style="padding-right: 10px"></i>Mulai Latihan Soal
                </a>
                @if($materi->file)
                    <a href="{{ asset('files/' . $materi->file) }}" class="btn btn-secondary-classroom" download>
                        <i class="fa-solid fa-download me-2" style="padding-right: 10px"></i>Download Materi
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
