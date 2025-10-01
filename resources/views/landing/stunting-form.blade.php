@extends('layouts.landing')

@section('title', 'Kalkulator Potensi Stunting')

@push('styles')
<style>
    /* Menggunakan gaya dasar seperti Google Form */
    body { background-color: #f0f4f8; }
    .form-container { max-width: 800px; margin: 2rem auto; }
    .form-header {
        background-color: #fff;
        border: 1px solid #dadce0;
        border-radius: 8px;
        padding: 24px;
        border-top: 10px solid var(--primary-color, #4682b4);
        margin-bottom: 1rem;
    }
    .form-header h2 { font-weight: 600; color: #333; }
    .form-card {
        background-color: #fff;
        border: 1px solid #dadce0;
        border-radius: 8px;
        margin-bottom: 1rem;
        padding: 24px;
    }
    .question-title { display: block; font-weight: 500; margin-bottom: 0.75rem; }

    /* Input dengan Ikon */
    .input-group-with-icon { position: relative; }
    .input-group-with-icon .icon {
        position: absolute; left: 15px; top: 50%;
        transform: translateY(-50%); color: #adb5bd;
    }

    .input-group-with-icon .form-control {
        padding-left: 45px;
        height: 44px;
        border-radius: 8px;
        border: 1px solid #ced4da; /* <-- WARNA BORDER DITAMBAHKAN */
    }
    .input-group-with-icon .form-control:focus { /* <-- EFEK SAAT DI-KLIK */
        border-color: var(--primary-color, #4682b4);
        box-shadow: 0 0 0 0.2rem rgba(70, 130, 180, 0.25);
    }

    /* Pilihan Jenis Kelamin */
    .gender-selector { display: flex; gap: 1rem; }
    .gender-selector input[type="radio"] { display: none; }
    .gender-selector label {
        flex: 1; padding: 0.75rem; border: 2px solid #dee2e6;
        border-radius: 8px; text-align: center; cursor: pointer;
        transition: all 0.2s ease-in-out;
    }
    .gender-selector input[type="radio"]:checked + label {
        background-color: var(--primary-color, #4682b4);
        border-color: var(--primary-color, #4682b4);
        color: white; font-weight: 600;
    }

    /* Hasil Perhitungan */
    .result-box {
        background-color: #f0f8ff;
        border-left: 5px solid var(--primary-color, #4682b4);
        border-radius: 8px;
        padding: 1.5rem;
    }
</style>
@endpush

@section('content')
<div class="container form-container">
    {{-- KARTU HEADER --}}
    <div class="form-header">
        <h2>📊 Kalkulator Potensi Stunting (Z-Score)</h2>
        <p class="text-muted mb-0">
            Kalkulator ini menggunakan metode Z-Score untuk anak usia <strong>0 s/d 5 tahun (60 bulan)</strong>.
        </p>
        <p class="text-muted small mt-1">
            Sumber data & metodologi: <a href="https://www.who.int/tools/child-growth-standards" target="_blank">Standar Pertumbuhan Anak WHO</a>.
        </p>
    </div>

    {{-- KARTU HASIL (JIKA ADA) --}}
    @if (session('result'))
        @php $result = session('result'); @endphp
        <div class="result-box mb-3">
            <h4 class="mb-3" style="color: var(--primary-color, #4682b4);">Hasil Analisis untuk {{ $result['nama_anak'] }}</h4>
            <p>
                Dengan data usia <strong>{{ $result['usia_bulan'] }} bulan</strong> dan tinggi badan <strong>{{ $result['tinggi_badan'] }} cm</strong>, status gizi anak adalah:
            </p>
            <h3 class="text-center fw-bold" style="color: {{ $result['color'] }};">{{ $result['status'] }}</h3>
            <p class="text-center small">(Z-Score: {{ $result['z_score'] }})</p>
        </div>
    @endif

    {{-- FORM INPUT --}}
    <form action="{{ route('stunting.calculate') }}" method="POST" id="stuntingForm">
        @csrf

        <div class="form-card">
            <label for="nama_anak" class="question-title">Nama Anak</label>
            <div class="input-group-with-icon">
                <i class="fa-solid fa-child icon"></i>
                <input type="text" class="form-control" id="nama_anak" name="nama_anak" value="{{ old('nama_anak') }}" placeholder="Contoh: Budi" required>
            </div>
            <small class="form-text text-muted d-block mt-1">Untuk anak usia 0 - 5 tahun (60 bulan).</small>
        </div>

        <div class="form-card">
            <label for="tanggal_lahir" class="question-title">Tanggal Lahir</label>
            <div class="input-group-with-icon">
                <i class="fa-solid fa-calendar-days icon"></i>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
            </div>
        </div>

        <div class="form-card">
            <label class="question-title">Jenis Kelamin</label>
            <div class="gender-selector">
                <input type="radio" name="jenis_kelamin" id="laki" value="L" {{ old('jenis_kelamin') == 'L' ? 'checked' : '' }} required>
                <label for="laki"><i class="fa-solid fa-person me-2"></i>Laki-laki</label>

                <input type="radio" name="jenis_kelamin" id="perempuan" value="P" {{ old('jenis_kelamin') == 'P' ? 'checked' : '' }} required>
                <label for="perempuan"><i class="fa-solid fa-person-dress me-2"></i>Perempuan</label>
            </div>
        </div>

        <div class="form-card">
            <label for="tinggi_badan" class="question-title">Tinggi/Panjang Badan (cm)</label>
            <div class="input-group-with-icon">
                <i class="fa-solid fa-ruler-vertical icon"></i>
                <input type="number" step="0.1" class="form-control" id="tinggi_badan" name="tinggi_badan" placeholder="Contoh: 75.5" value="{{ old('tinggi_badan') }}" required>
            </div>
        </div>

        <div class="d-flex justify-content-end align-items-center mt-3">
            <button type="submit" class="btn btn-primary">Hitung Status Gizi</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('clearBtn').addEventListener('click', function() {
        document.getElementById('stuntingForm').reset();
    });
</script>
@endpush
