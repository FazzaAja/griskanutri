@extends('layouts.landing')

@section('title', 'Struktur Kurikulum Pembelajaran')

@push('styles')
<style>
    /* Gaya dasar seperti :root, body, container, h1, dll. sudah dihapus.
      Gaya tersebut akan otomatis diambil dari file landing.css Anda,
      sehingga warna dan font akan konsisten dengan halaman lain.
    */

    /* Ganti style .kurikulum-hero yang lama dengan ini */
    .kurikulum-hero {
        /* Menambahkan background gambar dan overlay gelap */
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
        url("{{ asset('images/img/pembukaan-sekolah-perempuan-griska.jpg') }}") no-repeat center 80%/cover;
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
    .kurikulum-hero .hero-content h1 {
        color: white;
        font-size: 3.5rem; /* Sedikit perbesar font */
        font-weight: 700;
    }

    /* Card untuk Kurikulum/Semester */
    .kurikulum-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }
    .kurikulum-card {
        background-color: var(--white-color, #f0f8ff);
        border-radius: 10px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .kurikulum-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }
    .kurikulum-card h3 {
        font-family: var(--header-font, "Poppins", sans-serif);
        color: var(--primary-color, #4682b4);
        border-bottom: 2px solid var(--secondary-color, #a9cce3);
        padding-bottom: 0.5rem;
        margin-bottom: 1rem;
        font-size: 1.4rem;
    }
    .kurikulum-card ul {
        list-style: none;
        padding-left: 0;
        margin-bottom: 1rem;
    }
    .kurikulum-card li {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        border-bottom: 1px solid #eee;
    }
    .kurikulum-card li .materi-name {
        text-align: left;
        flex-grow: 1;
    }
    .kurikulum-card .materi-urutan {
        font-weight: 600;
        background-color: var(--background-color, #f0f4f8);
        color: var(--primary-color, #4682b4);
        padding: 2px 8px;
        border-radius: 5px;
        margin-right: 10px;
        flex-shrink: 0;
    }
    .total-materi {
        text-align: right;
        font-weight: 700;
        font-size: 1.1rem;
        color: var(--primary-color, #4682b4);
        margin-top: 1rem;
    }
    .kurikulum-card.placeholder {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        color: #888;
    }

    .btn-download-wrapper {
    text-align: center;
    margin-bottom: 2.5rem; /* Memberi jarak ke grid di bawahnya */
    }

    .btn-download {
        display: inline-block; /* Agar bisa diatur padding & margin */
        padding: 10px 25px;
        border: 2px solid var(--primary-color, #4682b4);
        background-color: var(--primary-color, #4682b4);
        color: white;
        border-radius: 50px; /* Membuat sudut melengkung */
        text-decoration: none;
        font-weight: 600;
        transition: background-color 0.3s, color 0.3s; /* Animasi transisi */
    }

    .btn-download:hover {
        background-color: transparent; /* Background menjadi transparan saat hover */
        color: var(--primary-color, #4682b4); /* Warna teks menjadi warna utama */
    }

    /* Hapus CSS lama untuk materi-card dan ganti dengan ini */

    .materi-card-item {
        border: 1px solid #eee;
        border-radius: 8px;
        overflow: hidden;
    }

    .materi-card-header {
        display: flex;
        align-items: center;
        padding: 0.9rem 1.25rem;
        background-color: #f8f9fa;
        cursor: pointer;
        text-decoration: none;
        color: var(--text-color);
        width: 100%;
        border: none; /* Style untuk button */
        text-align: left; /* Style untuk button */
        font-size: 1rem; /* Sesuaikan font agar sama */
    }

    .materi-card-header:hover {
        background-color: #e9ecef;
    }

    /* Logika untuk menyembunyikan dan menampilkan konten */
    .materi-card-content {
        max-height: 0; /* Awalnya konten disembunyikan */
        overflow: hidden;
        transition: max-height 0.4s ease-in-out; /* Animasi transisi */
    }

    /* Saat class 'open' ditambahkan oleh JS, konten akan muncul */
    .materi-card-content.open {
        max-height: 500px; /* Atur ke tinggi maksimal yang cukup untuk konten Anda */
    }

    .materi-card-body {
        padding: 1.25rem;
        border-top: 1px solid #eee;
    }

    /* Animasi untuk ikon panah */
    .materi-chevron {
        transition: transform 0.3s ease;
    }

    /* Saat class 'open' ditambahkan, ikon akan berputar */
    .materi-card-header.open .materi-chevron {
        transform: rotate(180deg);
    }

    /* Responsive Design */
    /* Aturan untuk layar dengan lebar maksimal 768px (tablet dan ponsel) */
    @media (max-width: 768px) {
        .kurikulum-hero {
            /* Buat lebih pendek di mobile, misal 50% tinggi layar */
            min-height: 20vh;

            /* Kurangi sedikit padding vertikal agar tidak terlalu makan tempat */
            padding: 4rem 1.5rem;
        }

        .kurikulum-hero .hero-content h1 {
            /* Kecilkan juga ukuran font agar pas */
            font-size: 2.5rem;
        }

        .section-title{
            font-size: 1.5rem;
        }
    }
</style>
@endpush

@section('content')

<header class="kurikulum-hero">
    <div class="hero-content">
        <h1>Kurikulum & Materi</h1>
    </div>
</header>

<main id="kurikulum">
    <section class="container">
        <br><br>
        {{-- Class .section-title ini diambil dari landing.css --}}
        @forelse ($kurikulums as $kurikulum)

        {{-- ... --}}
        <div class="section-title">
            <h3>{{ $kurikulum->nama }}</h3>
        </div>

        <div class="section-subtitle">
            <h7>{{ $kurikulum->keterangan }}</h7>
        </div>

        {{-- TEMPEL TOMBOL DOWNLOAD DI BAWAH KETERANGAN --}}
        @if($kurikulum->file)
            <div class="btn-download-wrapper">
                <a href="{{ asset('files/' . $kurikulum->file) }}" class="btn-download" download>
                    <i class="fa-solid fa-download me-2" style="padding-right: 5px"></i>Download Silabus
                </a>
            </div>
        @endif

        <div class="kurikulum-grid">
            {{-- ... sisa kode tidak berubah ... --}}
        </div>
        {{-- ... --}}

        </div>

        <div class="kurikulum-grid">

                <div class="kurikulum-card">
                    <h3></h3>

                    @if($kurikulum->materis->isNotEmpty())
                    <div class="materi-cards-container">
                        @foreach($kurikulum->materis as $materi)
                        <div class="materi-card-item mb-2">
                            {{-- Bagian Header Card yang Bisa di-klik --}}
                            <button type="button" class="materi-card-header">
                                <span class="materi-urutan">{{ $materi->urutan }}</span>
                                <span class="materi-name">{{ $materi->judul }}</span>
                                <i class="fa-solid fa-chevron-down ms-auto materi-chevron" style="padding-left: 11px"></i>
                            </button>

                            {{-- Bagian Konten yang Tersembunyi --}}
                            <div class="materi-card-content">
                                <div class="materi-card-body">
                                    <p class="text-muted">{{ $materi->keterangan }}</p>
                                </div>
                                {{-- Ubah link ini agar mengarah ke halaman detail --}}
                                <a href="{{ route('materi.show', $materi->slug) }}" class="btn btn-primary btn-sm ms-3 flex-shrink-0">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                        <br>
                        @endforeach
                    </div>
                    <div class="total-materi">Total: {{ $kurikulum->materis->count() }} Materi</div>
                @else
                    <p class="text-muted">Belum ada materi untuk kurikulum ini.</p>
                @endif
                </div>
            @empty
                <div class="kurikulum-card placeholder">
                    <h3>Belum Ada Kurikulum</h3>
                    <p>Data kurikulum belum ditambahkan ke dalam sistem.</p>
                </div>

        </div>
        @endforelse
    </section>
    <br><br>
</main>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Ambil semua tombol header materi
    const toggles = document.querySelectorAll('.materi-card-header');

    toggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            // Tambah/hapus class 'open' pada tombol yang di-klik
            this.classList.toggle('open');

            // Ambil elemen konten yang berada tepat setelah tombol
            const content = this.nextElementSibling;

            // Tambah/hapus class 'open' pada konten untuk memicu animasi CSS
            content.classList.toggle('open');
        });
    });
});
</script>
@endpush
