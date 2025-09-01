@extends('layouts.app')

@section('title', 'Manajemen Kurikulum')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3>Manajemen Kurikulum</h3>
        <a class="btn btn-success" href="{{ route('kurikulums.create') }}"> Buat Kurikulum Baru</a>
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
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Keterangan</th>
                        <th width="280px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kurikulums as $kurikulum)
                    <tr>
                        <td>{{ $kurikulum->id_kurikulum }}</td>
                        <td>{{ $kurikulum->nama }}</td>
                        <td>{{ Str::limit($kurikulum->keterangan, 100) }}</td>
                        <td>
                            <form action="{{ route('kurikulums.destroy', $kurikulum->id_kurikulum) }}" method="POST">
                                <a class="btn btn-info btn-sm" href="{{ route('kurikulums.show', $kurikulum->id_kurikulum) }}">Lihat</a>
                                <a class="btn btn-primary btn-sm" href="{{ route('kurikulums.edit', $kurikulum->id_kurikulum) }}">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data kurikulum.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Pagination Links --}}
        {!! $kurikulums->links() !!}
    </div>
</div>
@endsection
