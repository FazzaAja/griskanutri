@extends('layouts.app')

@section('title', 'Detail Materi')

@section('content')
    {{-- Header Halaman --}}
    <div class="content-header">
        <h4 class="title is-4">Detail Materi</h4>
        <span class="separator"></span>
        <nav class="breadcrumb has-bullet-separator" aria-label="breadcrumbs">
            <ul>
                <li><a href="{{ route('materis.index') }}">Materi</a></li>
                <li class="is-active"><a href="#" aria-current="page">{{ Str::limit($materi->judul, 30) }}</a></li>
            </ul>
        </nav>
    </div>

    {{-- Konten Utama --}}
    <div class="content-body">
        <div class="card">
            <div class="card-content">
                {{-- Judul dan Info Kurikulum --}}
                <div class="media">
                    <div class="media-content">
                        <p class="title is-4">{{ $materi->judul }}</p>
                        <p class="subtitle is-6">
                            Kurikulum: <strong>{{ optional($materi->kurikulum)->nama ?? 'Umum' }}</strong>
                        </p>
                    </div>
                </div>

                <div class="content">
                    {{-- Keterangan --}}
                    <h5 class="title is-5 mt-5">Keterangan</h5>
                    <p>{{ $materi->keterangan }}</p>
                    <hr>

                    {{-- Rangkuman --}}
                    <h5 class="title is-5">Rangkuman</h5>
                    {{-- nl2br akan mengubah baris baru (enter) menjadi tag <br> --}}
                    <p>{!! nl2br(e($materi->rangkuman)) !!}</p>
                    <hr>

                    {{-- File Materi (Jika Ada) --}}
                    @if($materi->file)
                        <h5 class="title is-5">File Materi</h5>
                        <a href="{{ asset('storage/files/'.$materi->file) }}" class="button is-link is-outlined" target="_blank">
                            <span class="icon is-small"><i class="fa fa-download"></i></span>
                            <span>Download/Lihat File</span>
                        </a>
                        <hr>
                    @endif

                    {{-- Video Pembelajaran (Jika Ada) --}}
                    @if($materi->youtube)
                        <h5 class="title is-5">Video Pembelajaran</h5>
                        @php
                            // Mengubah URL 'watch?v=' menjadi URL 'embed/' yang valid untuk iframe
                            $embedUrl = str_replace('watch?v=', 'embed/', $materi->youtube);
                            // Menghapus parameter tambahan setelah video ID (seperti &list=...)
                            $embedUrl = strtok($embedUrl, '&');
                        @endphp
                        {{-- Bulma menggunakan figure.image.is-16by9 untuk video responsif --}}
                        <figure class="image is-16by9">
                            <iframe class="has-ratio" src="{{ $embedUrl }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </figure>
                        <hr>
                    @endif

                    {{-- Tombol Aksi Lanjutan --}}
                    <h5 class="title is-5">Latihan</h5>
                    <div class="field is-grouped">
                        <p class="control">
                            <a href="{{ route('materis.soals.index', $materi->slug) }}" class="button is-info">
                                <span class="icon"><i class="fa fa-list-alt"></i></span>
                                <span>Lihat Soal</span>
                            </a>
                        </p>
                        <p class="control">
                            <a href="{{ route('materis.quiz', $materi->slug) }}" class="button is-success">
                                <span class="icon"><i class="fa fa-puzzle-piece"></i></span>
                                <span>Mulai Latihan/Quiz</span>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            {{-- Footer Kartu untuk Navigasi Kembali & Edit --}}
            <footer class="card-footer">
                <a href="{{ route('materis.index') }}" class="card-footer-item">
                    <span class="icon is-small"><i class="fa fa-arrow-left"></i></span>
                    <span>Kembali ke Daftar Materi</span>
                </a>
                <a href="{{ route('materis.edit', $materi->slug) }}" class="card-footer-item">
                     <span class="icon is-small"><i class="fa fa-edit"></i></span>
                     <span>Edit Materi Ini</span>
                </a>
            </footer>
        </div>
    </div>
@endsection
