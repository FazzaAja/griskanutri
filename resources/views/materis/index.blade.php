@extends('layouts.app')

@section('title', 'Manajemen Materi')

@push('styles')
    {{-- CSS Khusus untuk Datatables Bulma --}}
    <link rel="stylesheet" href="{{ asset('vendor/datatables-bulma/datatables-bulma.min.css') }}">
@endpush

@section('content')
    {{-- Header Halaman --}}
    <div class="content-header">
        <h4 class="title is-4">Manajemen Materi</h4>
        <span class="separator"></span>
        <nav class="breadcrumb has-bullet-separator" aria-label="breadcrumbs">
            <ul>
                <li><a href="#">Master Data</a></li>
                <li class="is-active"><a href="#" aria-current="page">Materi</a></li>
            </ul>
        </nav>
    </div>

    {{-- Konten Utama --}}
    <div class="content-body">

        {{-- Notifikasi Sukses --}}
        @if ($message = Session::get('success'))
            <div class="notification is-success is-light">
                <button class="delete"></button>
                {{ $message }}
            </div>
        @endif

        <div class="card">
            {{-- Filter dan Tombol Aksi --}}
            <div class="card-filter">
                <div class="field">
                    <div class="control has-icons-left">
                        <input class="input" id="table-search" type="text" placeholder="Cari materi...">
                        <span class="icon is-left"><i class="fa fa-search"></i></span>
                    </div>
                </div>
                <div class="field">
                    <div class="select">
                        <select id="table-length">
                            <option>10</option>
                            <option>25</option>
                            <option>50</option>
                        </select>
                    </div>
                </div>
                <div class="field has-addons">
                    <p class="control">
                        <a class="button is-success" href="{{ route('materis.create') }}">
                            <span class="icon is-small"><i class="fa fa-plus"></i></span>
                            <span>Buat Materi</span>
                        </a>
                    </p>
                </div>
            </div>

            {{-- Tabel Data --}}
            <div class="card-content">
                <table class="table is-hoverable is-bordered is-fullwidth" id="datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Materi</th>
                            <th>Kurikulum Induk</th>
                            <th>Keterangan</th>
                            <th class="has-text-centered">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($materis as $materi)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $materi->judul }}</td>
                            <td>{{ optional($materi->kurikulum)->nama ?? 'Tidak Terkait' }}</td>
                            <td>{{ Str::limit($materi->keterangan, 70) }}</td>
                            <td class="has-text-centered">
                                <form action="{{ route('materis.destroy', $materi->slug) }}" method="POST">
                                    <a href="{{ route('materis.show', $materi->slug) }}" class="button is-small is-info is-rounded is-text" title="Lihat">
                                        <span class="icon"><i class="fa fa-eye"></i></span>
                                    </a>
                                    <a href="{{ route('materis.edit', $materi->slug) }}" class="button is-small is-primary is-rounded is-text" title="Edit">
                                        <span class="icon"><i class="fa fa-edit"></i></span>
                                    </a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="button is-small is-danger is-rounded is-text" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        <span class="icon"><i class="fa fa-trash"></i></span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="has-text-centered">Tidak ada data materi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Panggil script library datatables --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('vendor/datatables-bulma/datatables-bulma.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Inisialisasi DataTable
            var table = $('#datatable').DataTable({
                dom: "<'columns table-wrapper'<'column is-12'tr>>" +
                     "<'columns is-vcentered table-footer-wrapper'<'column is-5'i><'column is-7'p>>",
                "columnDefs": [ {
                    "targets": [0, 4], // Target kolom 'No' dan 'Aksi'
                    "orderable": false
                } ]
            });

            // Fungsi Pencarian
            $('#table-search').on('keyup', function() {
                table.search($(this).val()).draw();
            });

            // Fungsi Mengubah Jumlah Entri
            $('#table-length').on('change', function() {
                table.page.len($(this).val()).draw();
            });

            // Fungsi untuk notifikasi Bulma agar bisa ditutup
            document.querySelectorAll('.notification .delete').forEach(($delete) => {
                const $notification = $delete.parentNode;
                $delete.addEventListener('click', () => {
                    $notification.parentNode.removeChild($notification);
                });
            });
        });
    </script>
@endpush
