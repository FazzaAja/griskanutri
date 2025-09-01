@extends('layouts.landing')

@section('title', 'Latihan Soal - ' . $materi->judul)

@push('styles')
<style>
    body { background-color: #f0f4f8; }
    .form-container { max-width: 800px; margin: 2rem auto; }
    .form-header {
        background-color: var(--primary-color, #4682b4);
        color: white;
        padding: 20px;
        border-radius: 8px 8px 0 0;
        border-top: 10px solid var(--secondary-color, #a9cce3);
    }
    .form-card {
        background-color: #fff;
        border: 1px solid #dadce0;
        border-radius: 8px;
        margin-bottom: 1rem;
        padding: 24px;
    }
    .question-title { font-weight: 500; margin-bottom: 1.5rem; }
    .form-check-label { margin-left: 0.5rem; }
    .btn-submit-quiz { padding: 10px 24px; font-weight: 500; }
</style>
@endpush

@section('content')
<div class="container form-container">
    <div class="form-header">
        <h2>{{ $materi->judul }}</h2>
        <p>Silakan jawab pertanyaan di bawah ini. Jawaban Anda akan diakumulasikan setelah menekan tombol Kirim.</p>
    </div>

    <form action="{{ route('latihan.submit', $materi->slug) }}" method="POST">
        @csrf

        @forelse ($soals as $soal)
            <div class="form-card">
                <p class="question-title">{{ $loop->iteration }}. {{ $soal->pertanyaan }}</p>

                @if($soal->img)
                    <div class="mb-3">
                        <img src="{{ asset('images/soal/' . $soal->img) }}" alt="Gambar Soal" class="img-fluid rounded" style="max-height: 250px;">
                    </div>
                @endif

                <div class="form-group">
                    @foreach ($soal->opsi as $key => $option)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[{{ $soal->id_soal }}]" id="opsi_{{ $soal->id_soal }}_{{ $key }}" value="{{ $key }}" required>
                            <label class="form-check-label" for="opsi_{{ $soal->id_soal }}_{{ $key }}">
                                {{ $option }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="form-card">
                <p class="text-center">Belum ada soal untuk materi ini.</p>
            </div>
        @endforelse

        @if($soals->isNotEmpty())
            <div class="d-flex justify-content-between mt-3">
                <button type="submit" class="btn btn-primary btn-submit-quiz" style="margin-right: 10px">Kirim</button>
                <a href="{{ route('materi.show', $materi->slug) }}">Kembali</a>
            </div>
        @endif
    </form>
</div>
@endsection
