@extends('layouts.app')

@section('title', 'Hasil Kuis')

@section('content')
<div class="card">
    <div class="card-header text-center">
        <h3>Hasil Kuis: {{ $results['materi_judul'] }}</h3>
    </div>
    <div class="card-body">
        <div class="text-center mb-4">
            <h1 class="display-3">Skor Anda</h1>
            <h1 class="display-1 fw-bold {{ $results['score'] >= 75 ? 'text-success' : 'text-danger' }}">
                {{ $results['score'] }}
            </h1>
            <p class="fs-4">
                Anda berhasil menjawab <strong>{{ $results['correct_answers'] }}</strong> dari <strong>{{ $results['total_questions'] }}</strong> soal dengan benar.
            </p>
        </div>

        <hr>

        <h4 class="mt-4">Rincian Jawaban:</h4>

        @foreach($results['results_data'] as $index => $result)
            <div class="mb-3 p-3 border rounded {{ $result['is_correct'] ? 'border-success' : 'border-danger' }}">
                <p class="fw-bold">Soal #{{ $index + 1 }}: {{ $result['pertanyaan'] }}</p>

                @foreach($result['opsi'] as $key => $option)
                    @php
                        $isUserAnswer = ($key == $result['jawaban_user']);
                        $isCorrectAnswer = ($key == $result['jawaban_benar']);
                        $class = '';
                        if ($isUserAnswer && !$result['is_correct']) {
                            $class = 'text-danger fw-bold'; // Jawaban user yang salah
                        } elseif ($isCorrectAnswer) {
                            $class = 'text-success fw-bold'; // Jawaban yang benar
                        }
                    @endphp
                    <p class="{{ $class }}">
                        {{ $key }}. {{ $option }}
                        @if($isUserAnswer && !$result['is_correct']) <span>(Jawaban Anda)</span> @endif
                        @if($isCorrectAnswer) <span>(Jawaban Benar)</span> @endif
                    </p>
                @endforeach
            </div>
        @endforeach

        <div class="text-center mt-4">
            <a href="{{ route('materis.index') }}" class="btn btn-secondary">Kembali ke Daftar Materi</a>
            <a href="{{ route('materis.quiz', Request::segment(2)) }}" class="btn btn-primary">Coba Lagi Kuis Ini</a>
        </div>
    </div>
</div>
@endsection
