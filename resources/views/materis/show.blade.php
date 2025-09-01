@extends('layouts.app')

@section('title', 'Detail Materi')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3>Detail Materi: {{ $materi->judul }}</h3>
        <a class="btn btn-primary" href="{{ route('materis.index') }}"> Kembali</a>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <strong>Kurikulum Induk:</strong>
            <p>{{ optional($materi->kurikulum)->nama }}</p>
        </div>
        <hr>
        <div class="mb-3">
            <strong>Keterangan:</strong>
            <p>{{ $materi->keterangan }}</p>
        </div>
        <hr>
        <div class="mb-3">
            <strong>Rangkuman:</strong>
            <p>{!! nl2br(e($materi->rangkuman)) !!}</p>
        </div>
        <hr>

        @if($materi->file)
            <div class="mb-3">
                <strong>File Materi:</strong>
                <p><a href="{{ asset('files/'.$materi->file) }}" class="btn btn-info btn-sm" target="_blank">Download/Lihat File</a></p>
            </div>
            <hr>
        @endif

        @if($materi->youtube)
            <div class="mb-3">
                <strong>Video Pembelajaran:</strong>
                @php
                    $youtubeUrl = $materi->youtube;
                    // Mengubah URL 'watch?v=' menjadi URL 'embed/'
                    $embedUrl = str_replace('watch?v=', 'embed/', $youtubeUrl);
                    // Menghapus parameter tambahan setelah video ID
                    $embedUrl = strtok($embedUrl, '&');
                @endphp
                <div class="ratio ratio-16x9 mt-2">
                    <iframe src="{{ $embedUrl }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
        @endif

        <a href="{{ route('materis.soals.index', $materi->slug) }}">Lihat Soal</a>
        <a href="{{ route('materis.quiz', $materi->slug) }}">Latihan Soal</a>
    </div>
</div>
@endsection
