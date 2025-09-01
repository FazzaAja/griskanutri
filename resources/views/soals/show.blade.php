@extends('layouts.app')

@section('title', 'Detail Soal')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3>Detail Soal</h3>
        <a class="btn btn-secondary" href="{{ route('materis.soals.index', $materi->slug) }}"> Kembali</a>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <strong>Materi Induk:</strong>
            <p>{{ $materi->judul }}</p>
        </div>
        <hr>
        <div class="mb-3">
            <strong>Pertanyaan:</strong>
            <p class="fs-5">{{ $soal->pertanyaan }}</p>
        </div>
        <hr>
        @if($soal->img)
            <div class="mb-3">
                <strong>Gambar:</strong><br>
                <img src="{{ asset('images/soal/' . $soal->img) }}" alt="Gambar Soal" class="img-fluid rounded" style="max-width: 400px;">
            </div>
            <hr>
        @endif
        <div class="mb-3">
            <strong>Opsi Jawaban:</strong>
            <ul class="list-group">
                @foreach($soal->opsi as $key => $option)
                    <li class="list-group-item {{ $key == $soal->jawaban ? 'list-group-item-success' : '' }}">
                        <strong>{{ $key }}.</strong> {{ $option }}
                        @if($key == $soal->jawaban)
                            <span class="badge bg-success float-end">Jawaban Benar</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="card-footer text-end">
        <a class="btn btn-primary" href="{{ route('materis.soals.edit', [$materi->slug, $soal->id_soal]) }}">Edit Soal Ini</a>
    </div>
</div>
@endsection
