@extends('layouts.app')

@section('title', 'Manajemen Kurikulum')

@push('styles')
    {{-- Jika ada CSS khusus untuk datatables, letakkan di sini --}}
    <link rel="stylesheet" href="{{ asset('vendor/datatables-bulma/datatables-bulma.min.css') }}">
@endpush

@section('content')
    {{-- Header Halaman --}}
    <div class="content-header">
        <h4 class="title is-4">Manajemen Kurikulum</h4>
        <span class="separator"></span>
        <nav class="breadcrumb has-bullet-separator" aria-label="breadcrumbs">
            <ul>
                <li><a href="#">Master Data</a></li>
                <li class="is-active"><a href="#" aria-current="page">Kurikulum</a></li>
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
                        <input class="input" id="table-search" type="text" placeholder="Cari kurikulum...">
                        <span class="icon is-left">
                            <i class="fa fa-search"></i>
                        </span>
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
                        <a class="button is-success" href="{{ route('kurikulums.create') }}">
                            <span class="icon is-small">
                                <i class="fa fa-plus"></i>
                            </span>
                            <span>Buat Kurikulum</span>
                        </a>
                    </p>
                </div>
            </div>

            {{-- Tabel Data --}}
            <div class="card-content">
                <table class="table is-hoverable is-bordered is-fullwidth" id="datatable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Keterangan</th>
                            <th class="has-text-centered">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kurikulums as $kurikulum)
                        <tr>
                            <td>{{ $kurikulum->id_kurikulum }}</td>
                            <td>{{ $kurikulum->nama }}</td>
                            <td>{{ Str::limit($kurikulum->keterangan, 100) }}</td>
                            <td class="has-text-centered">
                                {{-- Tombol aksi digabung dalam satu form untuk delete --}}
                                <form action="{{ route('kurikulums.destroy', $kurikulum->id_kurikulum) }}" method="POST" class="action-form">

                                    <a href="{{ route('kurikulums.show', $kurikulum->id_kurikulum) }}" class="button is-small is-info is-rounded is-text">
                                        <span class="icon"><i class="fa fa-eye"></i></span>
                                    </a>

                                    <a href="{{ route('kurikulums.edit', $kurikulum->id_kurikulum) }}" class="button is-small is-primary is-rounded is-text">
                                        <span class="icon"><i class="fa fa-edit"></i></span>
                                    </a>

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="button is-small is-danger is-rounded is-text action-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        <span class="icon"><i class="fa fa-trash"></i></span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="has-text-centered">Tidak ada data kurikulum.</td>
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
                // Mengatur tampilan (wrapper) agar sesuai dengan Bulma
                dom: "<'columns table-wrapper'<'column is-12'tr>>" +
                     "<'columns is-vcentered table-footer-wrapper'<'column is-5'i><'column is-7'p>>",
                // Menonaktifkan ordering bawaan jika kolom aksi tidak perlu di-sort
                "columnDefs": [ {
                    "targets": 3, // Target kolom 'Aksi' (dimulai dari 0)
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
