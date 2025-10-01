@extends('layouts.app')

@section('title', 'Detail Kurikulum')

@section('content')
    {{-- Header Halaman --}}
    <div class="content-header">
        <h4 class="title is-4">Detail Kurikulum</h4>
        <span class="separator"></span>
        <nav class="breadcrumb has-bullet-separator" aria-label="breadcrumbs">
            <ul>
                <li><a href="{{ route('kurikulums.index') }}">Kurikulum</a></li>
                <li class="is-active"><a href="#" aria-current="page">Detail Data</a></li>
            </ul>
        </nav>
    </div>

    {{-- Konten Utama --}}
    <div class="content-body">
        <div class="card">
            <div class="card-content">
                <div class="columns">
                    {{-- Kolom untuk Gambar --}}
                    <div class="column is-4">
                        <figure class="image is-4by3">
                            @if($kurikulum->img)
                                {{-- Arahkan ke folder storage/images jika Anda menggunakan storage link --}}
                                <img src="{{ asset('storage/images/'.$kurikulum->img) }}" alt="{{ $kurikulum->nama }}">
                            @else
                                {{-- Placeholder jika tidak ada gambar --}}
                                <img src="https://placehold.co/800x600?text=No+Image" alt="No Image Available">
                            @endif
                        </figure>
                    </div>

                    {{-- Kolom untuk Detail Teks --}}
                    <div class="column is-8">
                        <h3 class="title is-3">{{ $kurikulum->nama }}</h3>
                        @if ($kurikulum->created_at)
                        <h5 class="subtitle is-6 has-text-grey">
                            Diunggah pada: {{ $kurikulum->created_at->format('d M Y, H:i') }}
                        </h5>
                        @endif

                        <div class="content">
                            <p>{{ $kurikulum->keterangan }}</p>

                            @if($kurikulum->file)
                                <p><strong>File Modul:</strong></p>
                                {{-- Arahkan ke folder storage/files jika Anda menggunakan storage link --}}
                                <a href="{{ asset('storage/files/'.$kurikulum->file) }}" target="_blank" class="button is-link is-outlined">
                                    <span class="icon is-small"><i class="fa fa-download"></i></span>
                                    <span>Download/Lihat File</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <footer class="card-footer">
                <a href="{{ route('kurikulums.index') }}" class="card-footer-item">
                    <span class="icon is-small"><i class="fa fa-arrow-left"></i></span>
                    <span>Kembali</span>
                </a>
                <a href="{{ route('kurikulums.edit', $kurikulum->id_kurikulum) }}" class="card-footer-item">
                     <span class="icon is-small"><i class="fa fa-edit"></i></span>
                     <span>Edit Kurikulum Ini</span>
                </a>
            </footer>
        </div>
    </div>
@endsection
