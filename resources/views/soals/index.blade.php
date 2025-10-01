@extends('layouts.app')

@section('title', 'Manajemen Soal')

@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/datatables-bulma/datatables-bulma.min.css') }}">
@endpush

@section('content')
    {{-- Header Halaman --}}
    <div class="content-header">
        <h4 class="title is-4">Manajemen Soal</h4>
        <span class="separator"></span>
        <nav class="breadcrumb has-bullet-separator" aria-label="breadcrumbs">
            <ul>
                <li><a href="{{ route('materis.index') }}">Materi</a></li>
                <li><a href="{{ route('materis.show', $materi->slug) }}">{{ Str::limit($materi->judul, 25) }}</a></li>
                <li class="is-active"><a href="#" aria-current="page">Daftar Soal</a></li>
            </ul>
        </nav>
    </div>

    {{-- Konten Utama --}}
    <div class="content-body">

        @if ($message = Session::get('success'))
            <div class="notification is-success is-light">
                <button class="delete"></button>
                {{ $message }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h5 class="card-header-title">Daftar Soal untuk: {{ $materi->judul }}</h5>
            </div>
            <div class="card-content">
                <div class="field is-grouped">
                    <p class="control">
                        <a class="button is-success" href="{{ route('materis.soals.create', $materi->slug) }}">
                            <span class="icon is-small"><i class="fa fa-plus"></i></span>
                            <span>Buat Soal Baru</span>
                        </a>
                    </p>
                    <p class="control">
                        <a class="button is-light" href="{{ route('materis.index') }}">
                            <span class="icon is-small"><i class="fa fa-arrow-left"></i></span>
                            <span>Kembali</span>
                        </a>
                    </p>
                </div>

                <div class="table-container mt-4">
                    <table class="table is-hoverable is-bordered is-fullwidth" id="datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pertanyaan</th>
                                <th>Gambar</th>
                                <th class="has-text-centered">Jawaban Benar</th>
                                <th class="has-text-centered">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($soals as $soal)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ Str::limit($soal->pertanyaan, 80) }}</td>
                                <td>
                                    @if($soal->img)
                                        <figure class="image is-64x64">
                                            <img src="{{ asset('storage/images/soal/' . $soal->img) }}" alt="Gambar Soal">
                                        </figure>
                                    @else
                                        <span class="tag is-light">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="has-text-centered has-text-weight-bold is-family-monospace">
                                    {{ $soal->jawaban }}
                                </td>
                                <td class="has-text-centered">
                                    <form action="{{ route('materis.soals.destroy', [$materi->slug, $soal->id_soal]) }}" method="POST">
                                        <a href="{{ route('materis.soals.show', [$materi->slug, $soal->id_soal]) }}" class="button is-small is-info is-text" title="Lihat">
                                            <span class="icon"><i class="fa fa-eye"></i></span>
                                        </a>
                                        <a href="{{ route('materis.soals.edit', [$materi->slug, $soal->id_soal]) }}" class="button is-small is-primary is-text" title="Edit">
                                            <span class="icon"><i class="fa fa-edit"></i></span>
                                        </a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="button is-small is-danger is-text" title="Hapus" onclick="return confirm('Yakin ingin menghapus soal ini?')">
                                            <span class="icon"><i class="fa fa-trash"></i></span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="has-text-centered">Belum ada soal untuk materi ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('vendor/datatables-bulma/datatables-bulma.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                dom: "<'columns'<'column'l><'column'f>>" +
                     "<'columns'<'column is-12'tr>>" +
                     "<'columns'<'column'i><'column'p>>",
                "columnDefs": [ {
                    "targets": [0, 2, 4], // Menonaktifkan sorting untuk kolom No, Gambar, dan Aksi
                    "orderable": false
                } ]
            });

            document.querySelectorAll('.notification .delete').forEach(($delete) => {
                const $notification = $delete.parentNode;
                $delete.addEventListener('click', () => {
                    $notification.parentNode.removeChild($notification);
                });
            });
        });
    </script>
@endpush
