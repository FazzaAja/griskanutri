@extends('layouts.app')

@section('title', 'Buat Resep Baru')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3>Buat Resep Baru</h3>
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

        <form action="{{ route('reseps.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- INFORMASI DASAR --}}
            <h4>Informasi Dasar</h4>
            <div class="mb-3">
                <label for="judul" class="form-label"><strong>Judul Resep:</strong></label>
                <input type="text" name="judul" class="form-control" placeholder="Contoh: Nasi Goreng Spesial" value="{{ old('judul') }}" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label"><strong>Deskripsi Singkat:</strong></label>
                <textarea class="form-control" name="deskripsi" rows="3" placeholder="Jelaskan sedikit tentang resep ini" required>{{ old('deskripsi') }}</textarea>
            </div>
            <div class="mb-3">
                <label for="img" class="form-label"><strong>Gambar Masakan:</strong></label>
                <input type="file" name="img" class="form-control">
            </div>

            <hr>

            {{-- BAHAN & ALAT (BERDAMPINGAN) --}}
            <div class="row">
                <div class="col-md-6">
                    @include('reseps.partials.dynamic-input', ['name' => 'bahan', 'label' => 'Bahan-Bahan'])
                </div>
                <div class="col-md-6">
                    @include('reseps.partials.dynamic-input', ['name' => 'alat', 'label' => 'Alat-Alat'])
                </div>
            </div>

            <div class="row mt-3"> {{-- mt-3 untuk memberi sedikit jarak --}}
                {{-- LANGKAH-LANGKAH (SATU BARIS PENUH) --}}
                <div class="col-md-12">
                    @include('reseps.partials.dynamic-input', ['name' => 'langkah', 'label' => 'Langkah-Langkah'])
                </div>
            </div>

            <hr>

            {{-- INFORMASI NUTRISI (POSISI BARU) --}}
            <h4>Informasi Nutrisi (per porsi)</h4>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="kalori" class="form-label"><strong>Kalori (kcal):</strong></label>
                    <input type="number" step="0.01" name="kalori" class="form-control" value="{{ old('kalori', 0) }}" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="protein" class="form-label"><strong>Protein (g):</strong></label>
                    <input type="number" step="0.01" name="protein" class="form-control" value="{{ old('protein', 0) }}" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="karbo" class="form-label"><strong>Karbohidrat (g):</strong></label>
                    <input type="number" step="0.01" name="karbo" class="form-control" value="{{ old('karbo', 0) }}" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="lemak" class="form-label"><strong>Lemak (g):</strong></label>
                    <input type="number" step="0.01" name="lemak" class="form-control" value="{{ old('lemak', 0) }}" required>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">Simpan Resep</button>
            </div>
        </form>
    </div>
</div>

@include('reseps.partials.dynamic-input-script')
@endsection
