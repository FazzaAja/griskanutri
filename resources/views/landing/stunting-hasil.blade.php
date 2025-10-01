@extends('layouts.landing')

@section('title', 'Hasil Analisis Status Gizi')

@push('styles')
<style>
    body { background-color: #f0f4f8; }
    .result-container { max-width: 800px; margin: 2rem auto; }

    /* KARTU HASIL UTAMA */
    .result-summary-card {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        text-align: center;
        padding: 2.5rem 2rem;
        margin-bottom: 2rem;
        border-top: 8px solid; /* Warna dinamis dari PHP */
    }
    .result-summary-card .status-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
    }
    .result-summary-card .status-text {
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    .result-summary-card .z-score-value {
        font-size: 1.2rem;
        color: #6c757d;
        margin-bottom: 2rem;
    }

    /* GAUGE Z-SCORE */
    .z-score-gauge-bar {
        height: 15px; width: 100%;
        background: linear-gradient(to right, #d32f2f, #ef5350, #ffc107, #43a047, #1e88e5);
        border-radius: 10px; position: relative;
    }
    .z-score-needle {
        width: 0; height: 0;
        border-left: 8px solid transparent; border-right: 8px solid transparent;
        border-top: 12px solid #343a40; position: absolute;
        top: 15px; transform: translateX(-50%);
        transition: left 0.5s ease-in-out;
    }
    .z-score-labels { display: flex; justify-content: space-between; font-size: 0.8rem; font-weight: 600; padding: 0 5px; color: #6c757d; }

    /* KARTU DETAIL */
    .detail-card {
        background-color: #fff;
        border-radius: 8px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        height: 100%;
    }
    .detail-card h5 {
        font-weight: 600;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #eee;
    }
    .detail-card p { margin-bottom: 0.5rem; }
    .detail-card ul { padding-left: 1.2rem; }
    .detail-card li { margin-bottom: 0.75rem; }
</style>
@endpush

@section('content')
@if(isset($zscore) && isset($input))

{{-- Menyiapkan variabel untuk tampilan dinamis --}}
@php
    $color = '#43a047'; // Hijau (Normal)
    $icon = 'fa-solid fa-circle-check';

    if ($zscore < -3) {
        $color = '#d32f2f'; // Merah Tua (Stunting Berat)
        $icon = 'fa-solid fa-triangle-exclamation';
    } elseif ($zscore < -2) {
        $color = '#ff9800'; // Oranye (Stunting)
        $icon = 'fa-solid fa-circle-exclamation';
    }

    // Menghitung posisi gauge (tanpa mengubah controller)
    $gauge_percentage = (($zscore + 3) / 6) * 100;
    $gauge_percentage = max(0, min(100, $gauge_percentage));
@endphp

<div class="container result-container">

    {{-- KARTU HASIL UTAMA --}}
    <div class="result-summary-card" style="border-top-color: {{ $color }};">
        <div class="status-icon" style="color: {{ $color }};">
            <i class="{{ $icon }}"></i>
        </div>
        <h1 class="status-text" style="color: {{ $color }};">{{ $statusGizi }}</h1>
        <p class="z-score-value">Nilai Z-Score: <strong>{{ $zscore }}</strong></p>

        {{-- Visualisasi Gauge --}}
        <div>
            <div class="z-score-gauge-bar">
                 <div class="z-score-needle" style="left: {{ $gauge_percentage }}%;"></div>
            </div>
            <div class="z-score-labels mt-2">
                <span>-3 SD</span>
                <span>-2 SD</span>
                <span>Median</span>
                <span>+2 SD</span>
                <span>+3 SD</span>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- KARTU DATA ANAK --}}
        <div class="col-md-5" style="margin-bottom: 4vh">
            <div class="detail-card">
                <h5>Data Anak</h5>
                <p><strong>Nama:</strong> {{ $input['nama_anak'] }}</p>
                <p><strong>Usia:</strong> {{ $umurBulan }} bulan</p>
                <p><strong>Jenis Kelamin:</strong> {{ $input['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                <p><strong>Tinggi Badan:</strong> {{ $input['tinggi_badan'] }} cm</p>
            </div>
        </div>

        {{-- KARTU REKOMENDASI --}}
        <div class="col-md-7 mb-5" style="margin-bottom: 4vh">
            <div class="detail-card">
                <h5>Rekomendasi</h5>
                @if ($zscore < -3)
                    <ul>
                        <li><strong>Segera ke Dokter Spesialis Anak:</strong> Jangan tunda untuk mendapatkan pemeriksaan medis yang komprehensif.</li>
                        <li><strong>Investigasi Medis Mendalam:</strong> Dokter mungkin akan melakukan tes lebih lanjut untuk mencari tahu penyebab utama.</li>
                        <li><strong>Terapi Gizi Khusus:</strong> Anak mungkin memerlukan Pangan Olahan untuk Keperluan Medis Khusus (PKMK).</li>
                    </ul>
                @elseif ($zscore < -2)
                    <ul>
                        <li><strong>Konsultasi ke Puskesmas/Dokter:</strong> Validasi hasil pengukuran dan dapatkan pemeriksaan awal.</li>
                        <li><strong>Evaluasi Pola Makan:</strong> Ahli gizi akan membantu memperbaiki asupan nutrisi, terutama fokus pada protein hewani.</li>
                        <li><strong>Periksa Penyakit Penyerta:</strong> Pastikan tidak ada infeksi yang menghambat pertumbuhan.</li>
                    </ul>
                @else
                    <ul>
                        <li><strong>Lanjutkan Pantau di Posyandu:</strong> Pastikan pertumbuhan anak konsisten mengikuti kurva grafiknya setiap bulan.</li>
                        <li><strong>Jaga Gizi Seimbang:</strong> Terus berikan makanan kaya nutrisi.</li>
                    </ul>
                @endif
                <div class="alert alert-info mt-4 small" style="font-size: 1.8vh">
                    <strong>❗ Penting:</strong> Kalkulator ini adalah alat skrining, bukan diagnosis. Hasil akhir diagnosis harus ditentukan oleh tenaga kesehatan profesional.
                </div>
            </div>
        </div>
    </div>



    <div class="text-center mt-4">
        <a href="{{ route('stunting.form') }}" class="btn btn-primary">Kembali ke Kalkulator</a>
    </div>

</div>

@else
    {{-- Jika data tidak ada, tampilkan pesan dan arahkan kembali --}}
    <div class="container text-center py-5">
        <p>Data hasil tidak ditemukan. Anda akan diarahkan kembali ke formulir.</p>
        <a href="{{ route('stunting.form') }}" class="btn btn-primary">Kembali ke Kalkulator Sekarang</a>
    </div>

    <script>
        // Arahkan pengguna kembali ke form setelah 3 detik
        setTimeout(function() {
            window.location.href = "{{ route('stunting.form') }}";
        }, 3000);
    </script>
@endif
@endsection
