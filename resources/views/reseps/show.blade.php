@extends('layouts.app')

@section('title', $resep->judul)

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3>{{ $resep->judul }}</h3>
        <a class="btn btn-secondary" href="{{ route('reseps.index') }}"> Kembali ke Daftar Resep</a>
    </div>
    <div class="card-body">
        @if($resep->img)
            <div class="text-center mb-4">
                <img src="{{ asset('images/reseps/' . $resep->img) }}" class="img-fluid rounded" alt="{{ $resep->judul }}" style="max-height: 400px;">
            </div>
        @endif

        <p class="fs-5">{{ $resep->deskripsi }}</p>
        <hr>

        {{-- INFORMASI NUTRISI --}}
        <h4>Informasi Nutrisi</h4>
        @if($resep->nutrisi)
        <div class="d-flex justify-content-around text-center mb-4">
            <div>
                <span class="fw-bold fs-4">{{ $resep->nutrisi->kalori }}</span><br><small>Kalori (kcal)</small>
            </div>
            <div>
                <span class="fw-bold fs-4">{{ $resep->nutrisi->protein }}g</span><br><small>Protein</small>
            </div>
            <div>
                <span class="fw-bold fs-4">{{ $resep->nutrisi->karbo }}g</span><br><small>Karbohidrat</small>
            </div>
            <div>
                <span class="fw-bold fs-4">{{ $resep->nutrisi->lemak }}g</span><br><small>Lemak</small>
            </div>
        </div>
        <hr>
        @endif

        <div class="row">
            <div class="col-md-6">
                <h4>Bahan-Bahan</h4>
                <ul class="list-group list-group-flush">
                    @foreach($resep->bahan as $item)
                        <li class="list-group-item">{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-6">
                <h4>Alat-Alat</h4>
                <ul class="list-group list-group-flush">
                    @foreach($resep->alat as $item)
                        <li class="list-group-item">{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <h4 class="mt-4">Langkah-Langkah</h4>
        <ol class="list-group list-group-numbered">
            @foreach($resep->langkah as $item)
                <li class="list-group-item">{{ $item }}</li>
            @endforeach
        </ol>
    </div>
    <div class="card-footer text-end">
        <a href="{{ route('reseps.edit', $resep->slug) }}" class="btn btn-primary">Edit Resep Ini</a>
    </div>
</div>
@endsection
