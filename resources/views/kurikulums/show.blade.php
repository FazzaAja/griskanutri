@extends('layouts.app')

@section('title', 'Detail Kurikulum')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3>Detail Kurikulum</h3>
        <a class="btn btn-primary" href="{{ route('kurikulums.index') }}"> Kembali</a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                @if($kurikulum->img)
                    <img src="{{ asset('images/'.$kurikulum->img) }}" class="img-fluid rounded" alt="{{ $kurikulum->nama }}">
                @else
                    <img src="https://via.placeholder.com/300" class="img-fluid rounded" alt="No Image">
                @endif
            </div>
            <div class="col-md-8">
                <h3>{{ $kurikulum->nama }}</h3>
                <p><strong>Keterangan:</strong><br>{{ $kurikulum->keterangan }}</p>
                @if($kurikulum->file)
                <p><strong>File Modul:</strong> <a href="{{ asset('files/'.$kurikulum->file) }}" target="_blank">Download/Lihat File</a></p>
                @endif
                <p><small>Diunggah pada: {{ $kurikulum->upload_at->format('d M Y, H:i') }}</small></p>
            </div>
        </div>
    </div>
</div>
@endsection
