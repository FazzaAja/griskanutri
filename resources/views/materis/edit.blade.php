@extends('layouts.app')

@section('title', 'Edit Materi')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3>Edit Materi</h3>
        <a class="btn btn-primary" href="{{ route('materis.index') }}"> Kembali</a>
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

        <form action="{{ route('materis.update', $materi->slug) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="id_kurikulum" class="form-label"><strong>Kurikulum:</strong></label>
                <select name="id_kurikulum" class="form-select" required>
                    <option value="" disabled>-- Pilih Kurikulum --</option>
                    @foreach ($kurikulums as $kurikulum)
                        <option value="{{ $kurikulum->id_kurikulum }}" {{ $materi->id_kurikulum == $kurikulum->id_kurikulum ? 'selected' : '' }}>
                            {{ $kurikulum->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="judul" class="form-label"><strong>Judul Materi:</strong></label>
                <input type="text" name="judul" value="{{ $materi->judul }}" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="urutan" class="form-label"><strong>Nomor Urutan Materi:</strong></label>
                <input type="number" name="urutan" class="form-control" value="{{ old('urutan', $materi->urutan) }}" required>
                <small class="form-text text-muted">Materi akan diurutkan dari angka terkecil ke terbesar.</small>
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label"><strong>Keterangan:</strong></label>
                <textarea class="form-control" style="height:100px" name="keterangan">{{ $materi->keterangan }}</textarea>
            </div>
            <div class="mb-3">
                <label for="rangkuman" class="form-label"><strong>Rangkuman:</strong></label>
                <textarea class="form-control" style="height:150px" name="rangkuman">{{ $materi->rangkuman }}</textarea>
            </div>
            <div class="mb-3">
                <label for="file" class="form-label"><strong>File (Modul/PDF):</strong></label>
                <input type="file" name="file" class="form-control">
                @if($materi->file) <small>File saat ini: <a href="{{ asset('files/'.$materi->file) }}" target="_blank">{{ $materi->file }}</a></small> @endif
            </div>
            <div class="mb-3">
                <label for="youtube" class="form-label"><strong>Link Video YouTube:</strong></label>
                <input type="url" name="youtube" value="{{ $materi->youtube }}" class="form-control" placeholder="https://www.youtube.com/watch?v=xxxxxxxxxxx">
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Perbarui</button>
            </div>
        </form>
    </div>
</div>
@endsection
