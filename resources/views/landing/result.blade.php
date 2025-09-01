@extends('layouts.landing')

@section('title', 'Hasil Latihan Soal')

@push('styles')
<style>
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

    body { background-color: #f0f4f8; }
    .result-container { max-width: 800px; margin: 2rem auto; }
    .result-card {
        background-color: #fff;
        border: 1px solid #dadce0;
        border-radius: 8px;
        padding: 24px;
    }
    .result-header {
        border-top: 10px solid var(--primary-color, #4682b4);
        padding-bottom: 1.5rem;
        margin-bottom: 1.5rem;
        border-bottom: 1px solid #eee;
    }
    .result-header h2 { font-weight: 400; }
    .score-section { text-align: center; margin: 2rem 0; }

    /* --- STYLE BARU UNTUK DROPDOWN RINCIAN --- */
    .details-toggle {
        background: none;
        border: none;
        color: var(--primary-color, #4682b4);
        font-weight: 500;
        cursor: pointer;
        padding: 8px 0;
        margin-top: 1rem;
    }
    .details-toggle i {
        transition: transform 0.3s ease;
    }
    .details-toggle.open i {
        transform: rotate(180deg);
    }

    .answer-details {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.5s ease-in-out;
        border-top: 1px solid #eee;
        margin-top: 1rem;
    }
    .answer-details.open {
        max-height: 2000px; /* Nilai besar agar cukup untuk semua konten */
    }
    .answer-item {
        padding: 1rem 0;
        border-bottom: 1px solid #eee;
    }
    .answer-item:last-child {
        border-bottom: none;
    }
    .answer-item p {
        margin-bottom: 0.5rem;
    }
    .user-answer.incorrect {
        color: #dc3545;
        text-decoration: line-through;
    }
    .correct-answer {
        color: #198754;
        font-weight: 600;
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
        <h1>Hasil Latihan</h1>
    </div>
</header>

<div class="container result-container">
    <div class="result-card">
        <div class="result-header">
            <h2>{{ $results['materi_judul'] }}</h2>
            {{-- <p class="text-success">Jawaban Anda telah direkam.</p> --}}
        </div>

        <div class="score-section">
            <h4>Skor Anda:</h4>
            <h1 class="display-4 fw-bold">{{ $results['score'] }} / 100</h1>
            <p>Anda menjawab benar {{ $results['correct_answers'] }} dari {{ $results['total_questions'] }} soal.</p>
        </div>

        {{-- TOMBOL UNTUK MEMBUKA/TUTUP RINCIAN --}}
        <div class="text-center">
            <button id="details-toggle" class="details-toggle">
                Lihat Rincian Jawaban <i class="fa-solid fa-chevron-down ms-2"></i>
            </button>
        </div>

        {{-- WADAH UNTUK RINCIAN JAWABAN (AWALNYA TERSEMBUNYI) --}}
        <div id="answer-details" class="answer-details">
            @foreach($results['results_data'] as $index => $result)
            <div class="answer-item">
                <p class="fw-bold">{{ $index + 1 }}. {{ $result['pertanyaan'] }}</p>
                @if($result['is_correct'])
                    <p class="correct-answer">
                        <i class="fa-solid fa-check me-2"></i>Jawaban Anda: {{ $result['jawaban_user'] }} (Benar)
                    </p>
                @else
                    <p class="user-answer incorrect">
                        <i class="fa-solid fa-xmark me-2"></i>Jawaban Anda: {{ $result['jawaban_user'] ?? 'Tidak Dijawab' }}
                    </p>
                    <p class="correct-answer">
                        Jawaban Benar: {{ $result['jawaban_benar'] }}
                    </p>
                @endif
            </div>
            @endforeach
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('latihan.show', $results['materi_slug']) }}" class="btn btn-outline-primary me-2">Kerjakan Lagi</a>
            <a href="{{ route('materi.show', $results['materi_slug']) }}">Kembali</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('details-toggle');
    const detailsContainer = document.getElementById('answer-details');

    if(toggleBtn && detailsContainer) {
        toggleBtn.addEventListener('click', () => {
            // Toggle class 'open' pada tombol dan container
            toggleBtn.classList.toggle('open');
            detailsContainer.classList.toggle('open');
        });
    }
});
</script>
@endpush
