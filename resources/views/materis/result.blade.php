@extends('layouts.app')

@section('title', 'Hasil Kuis')

@section('content')
    {{-- Header Halaman --}}
    <div class="content-header">
        <h4 class="title is-4">Hasil Kuis</h4>
        <span class="separator"></span>
        <nav class="breadcrumb has-bullet-separator" aria-label="breadcrumbs">
            <ul>
                <li><a href="{{ route('materis.index') }}">Materi</a></li>
                <li><a href="{{ route('materis.show', $results['materi_slug']) }}">{{ Str::limit($results['materi_judul'], 25) }}</a></li>
                <li class="is-active"><a href="#" aria-current="page">Hasil</a></li>
            </ul>
        </nav>
    </div>

    {{-- Konten Utama --}}
    <div class="content-body">

        {{-- Kotak Skor Utama --}}
        <div class="notification {{ $results['score'] >= 75 ? 'is-success' : 'is-danger' }} has-text-centered">
            <p class="title is-3">Skor Anda</p>
            <p class="title is-1 has-text-weight-bold">{{ $results['score'] }}</p>
            <p class="subtitle is-5">
                Anda berhasil menjawab <strong>{{ $results['correct_answers'] }}</strong> dari <strong>{{ $results['total_questions'] }}</strong> soal dengan benar.
            </p>
        </div>

        <h4 class="title is-4 mt-6">Rincian Jawaban</h4>

        {{-- Loop untuk Rincian Jawaban --}}
        @foreach($results['results_data'] as $index => $result)
            {{-- Komponen 'message' untuk setiap soal --}}
            <article class="message {{ $result['is_correct'] ? 'is-success' : 'is-danger' }}">
                <div class="message-header">
                    <p>Soal #{{ $index + 1 }}: {{ $result['pertanyaan'] }}</p>
                </div>
                <div class="message-body content">
                    <ul>
                        @foreach($result['opsi'] as $key => $option)
                            @php
                                $isUserAnswer = ($key == $result['jawaban_user']);
                                $isCorrectAnswer = ($key == $result['jawaban_benar']);
                                $class = '';
                                if ($isUserAnswer && !$result['is_correct']) {
                                    $class = 'has-text-danger has-text-weight-bold'; // Jawaban user yang salah
                                } elseif ($isCorrectAnswer) {
                                    $class = 'has-text-success has-text-weight-bold'; // Jawaban yang benar
                                }
                            @endphp
                            <li class="{{ $class }}">
                                {{ $key }}. {{ $option }}

                                @if ($isCorrectAnswer)
                                    <span class="icon is-small has-text-success"><i class="fa fa-check"></i></span>
                                    <em class="is-size-7">(Jawaban Benar)</em>
                                @endif

                                @if ($isUserAnswer && !$result['is_correct'])
                                     <span class="icon is-small has-text-danger"><i class="fa fa-times"></i></span>
                                     <em class="is-size-7">(Jawaban Anda)</em>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </article>
        @endforeach

        {{-- Tombol Aksi di Bagian Bawah --}}
        <div class="field is-grouped is-grouped-centered mt-5">
            <p class="control">
                <a href="{{ route('materis.index') }}" class="button is-light">
                    <span class="icon"><i class="fa fa-arrow-left"></i></span>
                    <span>Kembali ke Daftar Materi</span>
                </a>
            </p>
            <p class="control">
                <a href="{{ route('materis.quiz', $results['materi_slug']) }}" class="button is-primary">
                    <span class="icon"><i class="fa fa-redo"></i></span>
                    <span>Coba Lagi Kuis Ini</span>
                </a>
            </p>
        </div>
    </div>
@endsection
