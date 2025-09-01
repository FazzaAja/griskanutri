@extends('layouts.app')

@section('title', 'Kuis - ' . $materi->judul)

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Kuis: {{ $materi->judul }}</h3>
        <p>Jawablah pertanyaan-pertanyaan di bawah ini dengan benar.</p>
    </div>
    <div class="card-body">
        <form action="{{ route('materis.submitQuiz', $materi->slug) }}" method="POST">
            @csrf
            @forelse ($soals as $soal)
                <div class="mb-4 p-3 border rounded">
                    <h5>Soal #{{ $loop->iteration }}</h5>
                    <p class="fs-5">{{ $soal->pertanyaan }}</p>

                    @if($soal->img)
                        <div class="mb-3">
                            <img src="{{ asset('images/soal/' . $soal->img) }}" alt="Gambar Soal" class="img-fluid rounded" style="max-height: 250px;">
                        </div>
                    @endif

                    <div class="form-group">
                        <label class="form-label">Pilih jawaban:</label>
                        @foreach ($soal->opsi as $key => $option)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="answers[{{ $soal->id_soal }}]" id="opsi_{{ $soal->id_soal }}_{{ $key }}" value="{{ $key }}" required>
                                <label class="form-check-label" for="opsi_{{ $soal->id_soal }}_{{ $key }}">
                                    {{ $key }}. {{ $option }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="alert alert-warning">
                    Belum ada soal untuk materi ini.
                </div>
            @endforelse

            @if($soals->isNotEmpty())
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg">Selesai & Lihat Hasil</button>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection
