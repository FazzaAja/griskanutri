@extends('layouts.app')

@section('title', 'Detail Soal')

@section('content')
    <div class="content-header">
        <h4 class="title is-4">Detail Soal</h4>
        <span class="separator"></span>
        <nav class="breadcrumb has-bullet-separator" aria-label="breadcrumbs">
             <ul>
                <li><a href="{{ route('materis.index') }}">Materi</a></li>
                <li><a href="{{ route('materis.soals.index', $materi->slug) }}">Daftar Soal</a></li>
                <li class="is-active"><a href="#" aria-current="page">Detail Soal</a></li>
            </ul>
        </nav>
    </div>

    <div class="content-body">
        <div class="card">
            <div class="card-content">
                <div class="content">
                    <p class="subtitle is-6">Materi Induk: <strong>{{ $materi->judul }}</strong></p>
                    <hr>
                    <h5 class="title is-5">Pertanyaan:</h5>
                    <p>{{ $soal->pertanyaan }}</p>

                    @if($soal->img)
                        <hr>
                        <h5 class="title is-5">Gambar:</h5>
                        <figure class="image" style="max-width: 400px;">
                            <img src="{{ asset('storage/images/soal/' . $soal->img) }}" alt="Gambar Soal">
                        </figure>
                    @endif

                    <hr>
                    <h5 class="title is-5">Opsi Jawaban:</h5>
                    <div class="tags are-medium">
                        @foreach($soal->opsi as $key => $option)
                            <span class="tag {{ $key == $soal->jawaban ? 'is-success' : 'is-light' }}">
                                <strong>{{ $key }}.</strong> &nbsp; {{ $option }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
            <footer class="card-footer">
                <a href="{{ route('materis.soals.index', $materi->slug) }}" class="card-footer-item">
                    <span class="icon is-small"><i class="fa fa-arrow-left"></i></span>
                    <span>Kembali ke Daftar Soal</span>
                </a>
                <a href="{{ route('materis.soals.edit', [$materi->slug, $soal->id_soal]) }}" class="card-footer-item">
                     <span class="icon is-small"><i class="fa fa-edit"></i></span>
                     <span>Edit Soal Ini</span>
                </a>
            </footer>
        </div>
    </div>
@endsection
