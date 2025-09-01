@extends('layouts.app')

@section('title', 'Tambah Kurikulum')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3>Tambah Kurikulum Baru</h3>
        <a class="btn btn-primary" href="{{ route('kurikulums.index') }}"> Kembali</a>
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

        <form action="{{ route('kurikulums.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="nama" class="form-label"><strong>Nama Kurikulum:</strong></label>
                <input type="text" name="nama" class="form-control" placeholder="Contoh: Matematika Dasar" required>
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label"><strong>Keterangan:</strong></label>
                <textarea class="form-control" style="height:150px" name="keterangan" placeholder="Deskripsi singkat kurikulum"></textarea>
            </div>
            <div class="mb-3">
                <label for="img" class="form-label"><strong>Gambar (Cover):</strong></label>
                <input type="file" name="img" class="form-control">
            </div>
            <div class="mb-3">
                <label for="file" class="form-label"><strong>File (Silabus/Modul):</strong></label>
                <input type="file" name="file" class="form-control">
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
