@extends('layouts.app')

@section('title', 'Manajemen Resep')

@push('styles')
<style>
    .search-container {
        position: relative;
    }
    #search-results {
        position: absolute;
        width: 100%;
        max-height: 400px;
        overflow-y: auto;
        border: 1px solid #ddd;
        border-top: none;
        border-radius: 0 0 .375rem .375rem;
        z-index: 1000;
        background-color: white;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .result-item {
        display: flex;
        align-items: center;
        padding: 10px;
        color: #333;
        text-decoration: none;
        border-bottom: 1px solid #eee;
    }
    .result-item:last-child {
        border-bottom: none;
    }
    .result-item:hover {
        background-color: #f5f5f5;
    }
    .result-item img, .result-item .icon {
        width: 40px;
        height: 40px;
        margin-right: 15px;
        border-radius: 4px;
        object-fit: cover;
    }
    .result-item .icon {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #e9ecef;
    }
    .result-item .text-content {
        display: flex;
        flex-direction: column;
    }
    .result-item .title {
        font-weight: 600;
    }
    .result-item .category {
        font-size: 0.8em;
        color: #6c757d;
    }
</style>
@endpush

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items: center">
        <h3>Manajemen Resep Makanan</h3>
        <a class="btn btn-success" href="{{ route('reseps.create') }}"> Buat Resep Baru</a>
    </div>
    <div class="card-body">

        <div class="mb-4 search-container">
            <form action="{{ route('reseps.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" id="search-input" name="search" class="form-control" placeholder="Cari resep berdasarkan judul atau bahan..." value="{{ request('search') }}" autocomplete="off">
                    <button class="btn btn-primary" type="submit">Cari</button>
                </div>
            </form>
            <div id="search-results"></div>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success mt-2">{{ $message }}</div>
        @endif

        {{-- TABEL RESEP --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                {{-- isi thead dan tbody tabel Anda di sini --}}
                <thead class="table-dark">
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Gambar</th>
                        <th>Judul Resep</th>
                        <th>Deskripsi</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reseps as $resep)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if($resep->img)
                                <img src="{{ asset('images/reseps/' . $resep->img) }}" alt="{{ $resep->judul }}" width="120" class="img-thumbnail">
                            @else
                                <span class="text-muted">Tidak ada</span>
                            @endif
                        </td>
                        <td>{{ $resep->judul }}</td>
                        <td>{{ Str::limit($resep->deskripsi, 100) }}</td>
                        <td>
                            <form action="{{ route('reseps.destroy', $resep->slug) }}" method="POST">
                                <a class="btn btn-info btn-sm" href="{{ route('reseps.show', $resep->slug) }}">Lihat</a>
                                <a class="btn btn-primary btn-sm" href="{{ route('reseps.edit', $resep->slug) }}">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus resep ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">
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
        {!! $reseps->appends(request()->query())->links() !!}
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search-input');
    const resultsContainer = document.getElementById('search-results');

    // Ikon SVG untuk pencarian bahan
    const searchIconSvg = `
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
        </svg>
    `;

    // Fungsi untuk membuat elemen HTML untuk hasil resep
    const createResepElement = (resep) => {
        return `
            <a href="/reseps/${resep.slug}" class="result-item">
                <img src="${resep.img}" alt="${resep.judul}">
                <div class="text-content">
                    <span class="title">${resep.judul}</span>
                    <span class="category">${resep.kategori}</span>
                </div>
            </a>
        `;
    };

    // Fungsi untuk membuat elemen HTML untuk hasil bahan
    const createBahanElement = (bahan) => {
        return `
            <a href="${bahan.search_url}" class="result-item">
                <div class="icon">${searchIconSvg}</div>
                <div class="text-content">
                    <span class="title">${bahan.nama}</span>
                    <span class="category">Bahan Makanan</span>
                </div>
            </a>
        `;
    };

    searchInput.addEventListener('input', function (e) {
        const query = e.target.value;

        if (query.length < 2) {
            resultsContainer.innerHTML = '';
            resultsContainer.style.display = 'none';
            return;
        }

        fetch(`{{ route('reseps.autocomplete') }}?term=${query}`)
            .then(response => response.json())
            .then(data => {
                resultsContainer.innerHTML = ''; // Kosongkan hasil lama

                let hasResults = false;

                // Tampilkan hasil pencarian resep
                if (data.reseps && data.reseps.length > 0) {
                    hasResults = true;
                    data.reseps.forEach(resep => {
                        resultsContainer.innerHTML += createResepElement(resep);
                    });
                }

                // Tampilkan hasil pencarian bahan
                if (data.bahans && data.bahans.length > 0) {
                    hasResults = true;
                    data.bahans.forEach(bahan => {
                        resultsContainer.innerHTML += createBahanElement(bahan);
                    });
                }

                // Tampilkan atau sembunyikan container hasil
                resultsContainer.style.display = hasResults ? 'block' : 'none';
            });
    });

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.search-container')) {
            resultsContainer.innerHTML = '';
            resultsContainer.style.display = 'none';
        }
    });
});
</script>
@endpush
