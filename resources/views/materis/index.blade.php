@extends('layouts.app')

@section('title', 'Manajemen Materi')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3>Manajemen Materi</h3>
        <a class="btn btn-success" href="{{ route('materis.create') }}"> Buat Materi Baru</a>
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
                        <th>No</th>
                        <th>Judul Materi</th>
                        <th>Kurikulum Induk</th>
                        <th>Keterangan</th>
                        <th width="280px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($materis as $materi)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $materi->judul }}</td>
                        <td>{{ optional($materi->kurikulum)->nama }}</td>
                        <td>{{ Str::limit($materi->keterangan, 70) }}</td>
                        <td>
                            <form action="{{ route('materis.destroy', $materi->slug) }}" method="POST">
                                <a class="btn btn-info btn-sm" href="{{ route('materis.show', $materi->slug) }}">Lihat</a>
                                <a class="btn btn-primary btn-sm" href="{{ route('materis.edit', $materi->slug) }}">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data materi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {!! $materis->links() !!}
    </div>
</div>
@endsection
