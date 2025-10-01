@extends('layouts.app')

@section('title', $resep->judul)

@section('content')
    <div class="content-header">
        <h4 class="title is-4">Detail Resep</h4>
        <span class="separator"></span>
        <nav class="breadcrumb has-bullet-separator" aria-label="breadcrumbs">
            <ul>
                <li><a href="{{ route('reseps.index') }}">Resep</a></li>
                <li class="is-active"><a href="#" aria-current="page">{{ Str::limit($resep->judul, 30) }}</a></li>
            </ul>
        </nav>
    </div>

    <div class="content-body">
        <div class="card">
            @if($resep->img)
            <div class="card-image">
                <figure class="image is-16by9">
                    <img src="{{ asset('images/reseps/' . $resep->img) }}" alt="{{ $resep->judul }}">
                </figure>
            </div>
            @endif
            <div class="card-content">
                <div class="media mb-5">
                    <div class="media-content">
                        <p class="title is-4">{{ $resep->judul }}</p>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="content">
                    <p>{{ $resep->deskripsi }}</p>
                </div>
                <hr>

                {{-- Informasi Nutrisi --}}
                @if($resep->nutrisi)
                <h5 class="title is-5 has-text-centered">Informasi Nutrisi (per porsi)</h5>
                <nav class="level is-mobile">
                    <div class="level-item has-text-centered">
                        <div>
                            <p class="heading">Kalori</p>
                            <p class="title is-4">{{ $resep->nutrisi->kalori }} <span class="is-size-6">kcal</span></p>
                        </div>
                    </div>
                    <div class="level-item has-text-centered">
                        <div>
                            <p class="heading">Protein</p>
                            <p class="title is-4">{{ $resep->nutrisi->protein }}g</p>
                        </div>
                    </div>
                    <div class="level-item has-text-centered">
                        <div>
                            <p class="heading">Karbohidrat</p>
                            <p class="title is-4">{{ $resep->nutrisi->karbo }}g</p>
                        </div>
                    </div>
                    <div class="level-item has-text-centered">
                        <div>
                            <p class="heading">Lemak</p>
                            <p class="title is-4">{{ $resep->nutrisi->lemak }}g</p>
                        </div>
                    </div>
                </nav>
                <hr>
                @endif

                {{-- Kolom Bahan dan Alat --}}
                <div class="columns">
                    <div class="column is-6 content">
                        <h5 class="title is-5">Bahan-Bahan</h5>
                        <ul>
                            @foreach($resep->bahan as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="column is-6 content">
                        <h5 class="title is-5">Alat-Alat</h5>
                        <ul>
                            @foreach($resep->alat as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                {{-- Langkah-langkah --}}
                <div class="content">
                     <h5 class="title is-5">Langkah-Langkah</h5>
                     <ol>
                        @foreach($resep->langkah as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                     </ol>
                </div>
            </div>
            {{-- Footer dengan Tombol Aksi --}}
            <footer class="card-footer">
                <a href="{{ route('reseps.index') }}" class="card-footer-item">
                    <span class="icon is-small"><i class="fa fa-arrow-left"></i></span>
                    <span>Kembali</span>
                </a>
                <a href="{{ route('reseps.edit', $resep->slug) }}" class="card-footer-item">
                     <span class="icon is-small"><i class="fa fa-edit"></i></span>
                     <span>Edit Resep</span>
                </a>
            </footer>
        </div>
    </div>
@endsection
