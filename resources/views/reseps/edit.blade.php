@extends('layouts.app')

@section('title', 'Edit Resep')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3>Edit Resep: {{ $resep->judul }}</h3>
        <a class="btn btn-secondary" href="{{ route('reseps.index') }}"> Kembali</a>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Ups!</strong> Ada masalah dengan input Anda.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('reseps.update', $resep->slug) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- INFORMASI DASAR --}}
            <h4>Informasi Dasar</h4>
            <div class="mb-3">
                <label for="judul" class="form-label"><strong>Judul Resep:</strong></label>
                <input type="text" name="judul" class="form-control" value="{{ old('judul', $resep->judul) }}" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label"><strong>Deskripsi Singkat:</strong></label>
                <textarea class="form-control" name="deskripsi" rows="3" required>{{ old('deskripsi', $resep->deskripsi) }}</textarea>
            </div>
            <div class="mb-3">
                <label for="img" class="form-label"><strong>Ganti Gambar Masakan:</strong></label>
                <input type="file" name="img" class="form-control">
                @if($resep->img)
                    <div class="mt-2"><small>Gambar saat ini:</small><br><img src="{{ asset('images/reseps/' . $resep->img) }}" height="100" class="img-thumbnail"></div>
                @endif
            </div>

            <hr>

            {{-- BAHAN & ALAT (BERDAMPINGAN) --}}
            <div class="row">
                <div class="col-md-6">
                    @include('reseps.partials.dynamic-input', ['name' => 'bahan', 'label' => 'Bahan-Bahan', 'items' => $resep->bahan])
                </div>
                <div class="col-md-6">
                    @include('reseps.partials.dynamic-input', ['name' => 'alat', 'label' => 'Alat-Alat', 'items' => $resep->alat])
                </div>
            </div>

            <div class="row mt-3">
                {{-- LANGKAH-LANGKAH (SATU BARIS PENUH) --}}
                <div class="col-md-12">
                    @include('reseps.partials.dynamic-input', ['name' => 'langkah', 'label' => 'Langkah-Langkah', 'items' => $resep->langkah])
                </div>
            </div>

            <hr>

            {{-- INFORMASI NUTRISI (POSISI BARU) --}}
            <h4>Informasi Nutrisi (per porsi)</h4>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="kalori" class="form-label"><strong>Kalori (kcal):</strong></label>
                    <input type="number" step="0.01" name="kalori" class="form-control" value="{{ old('kalori', $resep->nutrisi->kalori ?? 0) }}" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="protein" class="form-label"><strong>Protein (g):</strong></label>
                    <input type="number" step="0.01" name="protein" class="form-control" value="{{ old('protein', $resep->nutrisi->protein ?? 0) }}" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="karbo" class="form-label"><strong>Karbohidrat (g):</strong></label>
                    <input type="number" step="0.01" name="karbo" class="form-control" value="{{ old('karbo', $resep->nutrisi->karbo ?? 0) }}" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="lemak" class="form-label"><strong>Lemak (g):</strong></label>
                    <input type="number" step="0.01" name="lemak" class="form-control" value="{{ old('lemak', $resep->nutrisi->lemak ?? 0) }}" required>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">Perbarui Resep</button>
            </div>
        </form>
    </div>
</div>

@include('reseps.partials.dynamic-input-script')
@endsection
