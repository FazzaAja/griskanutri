@extends('layouts.app')

@section('title', 'Kuis - ' . $materi->judul)

@section('content')
    {{-- Header Halaman --}}
    <div class="content-header">
        <h4 class="title is-4">Kuis: {{ $materi->judul }}</h4>
        <span class="separator"></span>
        <nav class="breadcrumb has-bullet-separator" aria-label="breadcrumbs">
            <ul>
                <li><a href="{{ route('materis.index') }}">Materi</a></li>
                <li><a href="{{ route('materis.show', $materi->slug) }}">{{ Str::limit($materi->judul, 25) }}</a></li>
                <li class="is-active"><a href="#" aria-current="page">Latihan Kuis</a></li>
            </ul>
        </nav>
    </div>

    {{-- Konten Utama --}}
    <div class="content-body">
        <form action="{{ route('materis.submitQuiz', $materi->slug) }}" method="POST">
            @csrf

            @forelse ($soals as $soal)
                {{-- Setiap soal dibungkus dengan komponen 'box' --}}
                <div class="box">
                    <h5 class="title is-5">Soal #{{ $loop->iteration }}</h5>
                    <div class="content">
                        <p>{{ $soal->pertanyaan }}</p>
                    </div>

                    @if($soal->img)
                        <figure class="image is-5by3 mb-4">
                            {{-- Sesuaikan path ke 'storage' jika file diunggah oleh user --}}
                            <img src="{{ asset('storage/images/soal/' . $soal->img) }}" alt="Gambar Soal" style="max-height: 300px; width: auto;">
                        </figure>
                    @endif

                    {{-- Pilihan Jawaban --}}
                    <div class="field">
                        <label class="label">Pilih jawaban:</label>
                        <div class="control">
                            @foreach ($soal->opsi as $key => $option)
                                <label class="radio">
                                    <input type="radio" name="answers[{{ $soal->id_soal }}]" value="{{ $key }}" required>
                                    {{ $key }}. {{ $option }}
                                </label>
                                <br>
                            @endforeach
                        </div>
                    </div>
                </div>
            @empty
                {{-- Tampilan jika tidak ada soal --}}
                <div class="notification is-warning">
                    Belum ada soal untuk materi ini. <a href="{{ route('materis.show', $materi->slug) }}">Kembali ke detail materi.</a>
                </div>
            @endforelse

            {{-- Tombol Submit jika ada soal --}}
            @if($soals->isNotEmpty())
                <div class="field mt-5">
                    <div class="control">
                        <button type="submit" class="button is-success is-large is-fullwidth">
                            <span class="icon"><i class="fa fa-check"></i></span>
                            <span>Selesai & Lihat Hasil</span>
                        </button>
                    </div>
                </div>
            @endif
        </form>
    </div>
@endsection
