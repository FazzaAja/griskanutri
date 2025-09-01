@extends('layouts.app')

@section('title', 'Manajemen Soal')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Manajemen Soal untuk Materi: <span class="text-primary">{{ $materi->judul }}</span></h3>
        <div class="mt-2">
            <a class="btn btn-success" href="{{ route('materis.soals.create', $materi->slug) }}"> Buat Soal Baru</a>
            <a class="btn btn-secondary" href="{{ route('materis.index') }}"> Kembali ke Daftar Materi</a>
        </div>
    </div>
    <div class="card-body">
        @if ($message = Session::get('success'))
            <div class="alert alert-success mt-2">
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">No</th>
                        <th>Pertanyaan</th>
                        <th width="15%">Gambar</th>
                        <th width="10%">Jawaban Benar</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($soals as $soal)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ Str::limit($soal->pertanyaan, 80) }}</td>
                        <td>
                            @if($soal->img)
                                <img src="{{ asset('images/soal/' . $soal->img) }}" alt="Gambar Soal" width="100" class="img-thumbnail">
                            @else
                                <span class="text-muted">Tidak ada</span>
                            @endif
                        </td>
                        <td class="text-center fw-bold">{{ $soal->jawaban }}</td>
                        <td>
                            <form action="{{ route('materis.soals.destroy', [$materi->slug, $soal->id_soal]) }}" method="POST">
                                <a class="btn btn-info btn-sm" href="{{ route('materis.soals.show', [$materi->slug, $soal->id_soal]) }}">Lihat</a>
                                <a class="btn btn-primary btn-sm" href="{{ route('materis.soals.edit', [$materi->slug, $soal->id_soal]) }}">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus soal ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada soal untuk materi ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {!! $soals->links() !!}
    </div>
</div>
@endsection
