@extends('layouts.landing')

@section('title', 'Jelajah Resep Makanan Sehat')

@push('styles')
<style>
    /* Ganti style .kurikulum-hero yang lama dengan ini */
    .resep-hero {
        /* Menambahkan background gambar dan overlay gelap */
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
        url("{{ asset('images/img/proses-mengukus-siomay-lele.JPG') }}") no-repeat center 100%/cover;
        background-size: 100% auto;
        color: white; /* Mengubah warna teks utama menjadi putih */
        text-align: center;
        padding: 6rem 1.5rem;
        display: flex; /* Menggunakan flexbox untuk centering */
        justify-content: center; /* Centering horizontal */
        align-items: center; /* Centering vertikal */
        min-height: 50vh; /* Sesuaikan tinggi sesuai selera */
    }

    /* Pastikan warna heading di dalam hero menjadi putih */
    .resep-hero .hero-content h1 {
        color: white;
        font-size: 3.5rem; /* Sedikit perbesar font */
        font-weight: 700;
    }

    /* Ganti semua style search-hero dan search-bar dengan ini */

    .search-hero-section {
        padding: 4rem 1rem;
        border-bottom: 1px solid #eee;
        text-align: center;
    }
    .search-hero-section h1 {
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    .search-hero-section p {
        margin-bottom: 1.5rem;
        color: #6c757d;
    }

    /* Container untuk menjaga posisi ikon tetap relatif */
    .search-bar-container {
        max-width: 600px;
        margin: 0 auto;
        position: relative; /* Kuncinya di sini */
    }

    /* HAPUS TOTAL BLOK .search-bar-container .search-icon */

    /* GANTI BLOK LAMA .search-bar-container .form-control DENGAN INI */
    .search-bar-container .form-control {
        height: 50px;
        border-radius: 50px !important;

        /* Jadikan Ikon sebagai Background dari Input Field */
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="%23aaa" class="bi bi-search" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/></svg>');
        background-repeat: no-repeat;
        background-position: 15px center; /* Posisi ikon: 15px dari kiri, di tengah vertikal */
        background-size: 16px; /* Ukuran ikon */

        /* Beri ruang agar teks tidak menimpa ikon background */
        padding-left: 45px;
    }

    /* Posisikan tombol "Cari" di atas input (untuk Z-index) */
    .search-bar-container .btn {
        position: relative;
        z-index: 5;
    }

    .recipe-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1.5rem;
    }
    .recipe-card {
        text-decoration: none;
        color: white;
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        aspect-ratio: 1 / 1;
        display: flex;
        align-items: flex-end;
        padding: 1rem;
        background-size: cover;
        background-position: center;
        transition: transform 0.2s ease;
    }
    .recipe-card:hover {
        transform: scale(1.03);
    }
    .recipe-card::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent 50%);
    }
    .recipe-card .title {
        z-index: 2;
        font-weight: 600;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.7);
    }

    /* Style untuk autocomplete tetap sama */
    #search-results {
        position: absolute; width: 100%; z-index: 1000;
    }
    #search-results .list-group-item { cursor: pointer; }

    /* Responsive Design */
    /* Aturan untuk layar dengan lebar maksimal 768px (tablet dan ponsel) */
    @media (max-width: 768px) {
        .resep-hero {
            /* Buat lebih pendek di mobile, misal 50% tinggi layar */
            min-height: 20vh;

            /* Kurangi sedikit padding vertikal agar tidak terlalu makan tempat */
            padding: 4rem 1.5rem;
        }

        .resep-hero .hero-content h1 {
            /* Kecilkan juga ukuran font agar pas */
            font-size: 2.5rem;
        }

    }

    /* ... CSS Anda yang sudah ada untuk .recipe-grid ... */

    /* --- TAMBAHKAN KODE INI DI BAGIAN BAWAH CSS ANDA --- */

    /* Aturan untuk layar dengan lebar maksimal 576px (ponsel) */
    @media (max-width: 576px) {
        .recipe-grid {
            /* Paksa grid menjadi 2 kolom */
            grid-template-columns: 1fr 1fr;

            /* Perkecil jarak antar kartu di mobile (opsional) */
            gap: 1rem;
        }
    }
</style>
@endpush

@section('content')
<header class="resep-hero">
    <div class="hero-content">
        <h1>Resep Sehat</h1>
    </div>
</header>

<div class="search-hero-section">
    <div class="container">
        <h1>Jelajahi Resep Favorit Anda</h1>
        <p>Temukan inspirasi memasak dari ribuan resep yang tersedia.</p>

        {{-- Kunci ada di container ini --}}
        <div class="search-bar-container">
            <form action="{{ route('resep.index') }}" method="GET">
                {{-- Ikon diletakkan sebelum input group --}}
                <div class="input-group">
                    <input type="text" id="search-input" name="search" class="form-control"
                        placeholder="Cari resep..." value="{{ request('search') }}" autocomplete="off"
                        data-autocomplete-url="{{ route('reseps.autocomplete') }}"
                        data-base-url="{{ url('/reseps') }}">
                    <button class="btn" type="submit">Cari</button>
                </div>
            </form>
            {{-- Wadah untuk hasil live search --}}
            <div id="search-results" class="list-group mt-1"></div>
        </div>
    </div>
</div>

<div class="container py-4">
    {{-- BAGIAN BANNER SUDAH DIHAPUS --}}

    <h2 class="section-title">{{ request('search') ? 'Hasil Pencarian' : 'Semua Resep' }}</h2>

    <div class="recipe-grid">
        @forelse ($reseps as $resep)
            <a href="{{ route('resep.show', $resep->slug) }}" class="recipe-card" style="background-image: url('{{ $resep->img ? asset('images/reseps/' . $resep->img) : 'https://placehold.co/400x400/eee/ccc?text=Resep' }}');">
                <span class="title">{{ $resep->judul }}</span>
            </a>
        @empty
            <div class="col-12">
                <p>Resep tidak ditemukan.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {!! $reseps->appends(request()->query())->links() !!}
    </div>
</div>

<br><br>
@endsection

@push('scripts')
{{-- Skrip Autocomplete tidak perlu diubah --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search-input');
    const resultsContainer = document.getElementById('search-results');

    // ... (kode JavaScript autocomplete tetap sama) ...
    searchInput.addEventListener('input', function (e) {
        const query = e.target.value;
        if (query.length < 2) { resultsContainer.innerHTML = ''; return; }
        fetch(`{{ route('reseps.autocomplete') }}?term=${query}`)
            .then(response => response.json())
            .then(data => {
                resultsContainer.innerHTML = '';
                if (data.reseps && data.reseps.length > 0) {
                    data.reseps.forEach(resep => {
                        const item = document.createElement('a');
                        item.href = `/reseps/${resep.slug}`;
                        item.classList.add('list-group-item', 'list-group-item-action');
                        item.textContent = resep.judul;
                        resultsContainer.appendChild(item);
                    });
                }
            });
    });
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.search-bar-container')) {
            resultsContainer.innerHTML = '';
        }
    });
});
</script>
@endpush
