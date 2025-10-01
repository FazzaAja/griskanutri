@extends('layouts.app')

@section('title', 'Manajemen Resep')

@push('styles')
<style>
    /* Styling untuk Live Search Autocomplete */
    .search-container { position: relative; }
    #search-results {
        position: absolute; width: 100%; max-height: 400px; overflow-y: auto;
        border: 1px solid #dbdbdb; border-top: none; z-index: 1000;
        background-color: white; box-shadow: 0 8px 8px rgba(10, 10, 10, 0.1);
        display: none;
    }
    .result-item { display: flex; align-items: center; padding: 0.75rem 1rem; color: #363636; text-decoration: none; border-bottom: 1px solid #f5f5f5; }
    .result-item:last-child { border-bottom: none; }
    .result-item:hover { background-color: #fafafa; }
    .result-item .image img { border-radius: 4px; object-fit: cover; }
    .result-item .icon { display: flex; align-items: center; justify-content: center; width: 48px; height: 48px; background-color: #f5f5f5; border-radius: 4px; margin-right: 1rem; color: #7a7a7a; }
    .result-item .text-content .title { font-weight: 600; color: #363636; font-size: 1rem; margin-bottom: 0.25rem !important; }
    .result-item .text-content .category { font-size: 0.8em; color: #7a7a7a; }

    /* Styling untuk Paginasi Bawaan Laravel agar Mirip Bulma */
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 1.5rem;
    }
    .pagination .page-item .page-link {
        color: #363636;
        border-color: #dbdbdb;
        border-radius: 4px;
        margin: 0 0.25rem;
        padding: 0.5em 1em;
    }
    .pagination .page-item.active .page-link {
        background-color: #3273dc;
        border-color: #3273dc;
        color: #fff;
    }
    .pagination .page-item.disabled .page-link {
        background-color: #fff;
        color: #dbdbdb;
    }
    .pagination .page-item .page-link:hover {
        border-color: #b5b5b5;
    }
</style>
@endpush

@section('content')
    <div class="content-header">
        <h4 class="title is-4">Manajemen Resep</h4>
        <span class="separator"></span>
        <nav class="breadcrumb has-bullet-separator">
            <ul>
                <li><a href="#">Master Data</a></li>
                <li class="is-active"><a href="#">Resep</a></li>
            </ul>
        </nav>
    </div>

    <div class="content-body">
        @if ($message = Session::get('success'))
            <div class="notification is-success is-light">
                <button class="delete"></button>
                {{ $message }}
            </div>
        @endif

        <div class="card">
            <div class="card-content">
                <div class="level">
                    <div class="level-left">
                        <div class="field search-container" style="min-width: 300px;">
                             {{-- Form Pencarian Tetap Ada untuk Pencarian Penuh --}}
                             <form action="{{ route('reseps.index') }}" method="GET">
                                <div class="field has-addons">
                                    <div class="control has-icons-left is-expanded">
                                        <input class="input" type="text" id="search-input" name="search" placeholder="Cari resep atau bahan..." value="{{ request('search') }}" autocomplete="off">
                                        <span class="icon is-left"><i class="fa fa-search"></i></span>
                                    </div>
                                    <div class="control">
                                        <button class="button is-primary" type="submit">Cari</button>
                                    </div>
                                </div>
                            </form>
                            <div id="search-results"></div>
                        </div>
                    </div>
                    <div class="level-right">
                        <a class="button is-success" href="{{ route('reseps.create') }}">
                            <span class="icon is-small"><i class="fa fa-plus"></i></span>
                            <span>Buat Resep Baru</span>
                        </a>
                    </div>
                </div>

                <div class="table-container mt-4">
                    <table class="table is-hoverable is-bordered is-fullwidth">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Judul Resep</th>
                                <th>Deskripsi</th>
                                <th class="has-text-centered">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($reseps as $resep)
                            <tr>
                                <td>{{ ($reseps->currentPage() - 1) * $reseps->perPage() + $loop->iteration }}</td>
                                <td>
                                    <figure class="image is-64x64">
                                        @if($resep->img)
                                            <img src="{{ asset('images/reseps/'.$resep->img) }}" alt="{{ $resep->judul }}">
                                        @else
                                            <img src="https://placehold.co/128x128?text=N/A" alt="Tidak ada gambar">
                                        @endif
                                    </figure>
                                </td>
                                <td>{{ $resep->judul }}</td>
                                <td>{{ Str::limit($resep->deskripsi, 100) }}</td>
                                <td class="has-text-centered">
                                    <form action="{{ route('reseps.destroy', $resep->slug) }}" method="POST">
                                        <a href="{{ route('reseps.show', $resep->slug) }}" class="button is-small is-info is-text" title="Lihat"><span class="icon"><i class="fa fa-eye"></i></span></a>
                                        <a href="{{ route('reseps.edit', $resep->slug) }}" class="button is-small is-primary is-text" title="Edit"><span class="icon"><i class="fa fa-edit"></i></span></a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="button is-small is-danger is-text" title="Hapus" onclick="return confirm('Yakin ingin menghapus resep ini?')"><span class="icon"><i class="fa fa-trash"></i></span></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="has-text-centered">
                                    @if(request('search'))
                                        Resep dengan kata kunci "{{ request('search') }}" tidak ditemukan.
                                    @else
                                        Belum ada resep yang dibuat.
                                    @endif
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginasi Bawaan Laravel --}}
                <div class="mt-4">
                    {!! $reseps->appends(request()->query())->links() !!}
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
{{-- Script untuk autocomplete dan notifikasi (sama seperti sebelumnya) --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search-input');
    const resultsContainer = document.getElementById('search-results');
    const searchIconSvg = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/></svg>`;

    const createResepElement = (resep) => {
        const imageUrl = resep.img ? `/storage/images/reseps/${resep.img}` : 'https://placehold.co/48x48?text=N/A';
        return `<a href="/reseps/${resep.slug}" class="result-item"> ... </a>`; // Disingkat
    };

    const createBahanElement = (bahan) => {
        return `<a href="${bahan.search_url}" class="result-item"> ... </a>`; // Disingkat
    };

    // ... (Logika fetch autocomplete Anda tetap di sini) ...

    // Skrip untuk menutup notifikasi
    document.querySelectorAll('.notification .delete').forEach(($delete) => {
        const $notification = $delete.parentNode;
        $delete.addEventListener('click', () => {
            $notification.parentNode.removeChild($notification);
        });
    });
});
</script>
@endpush
