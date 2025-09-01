@extends('layouts.app')

@section('title', 'Tambah Soal Baru')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3>Tambah Soal Baru untuk Materi: <span class="text-primary">{{ $materi->judul }}</span></h3>
        <a class="btn btn-secondary" href="{{ route('materis.soals.index', $materi->slug) }}"> Kembali</a>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Ups!</strong> Ada masalah dengan input Anda.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('materis.soals.store', $materi->slug) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="pertanyaan" class="form-label"><strong>Pertanyaan:</strong></label>
                <textarea class="form-control" style="height:100px" name="pertanyaan" placeholder="Tulis pertanyaan di sini..." required>{{ old('pertanyaan') }}</textarea>
            </div>
            <div class="mb-3">
                <label for="img" class="form-label"><strong>Gambar (Opsional):</strong></label>
                <input type="file" name="img" class="form-control">
            </div>

            <hr>
            <h5>Opsi Jawaban & Kunci Jawaban</h5>
            <div id="options-container">
                </div>
            <button type="button" id="add-option-btn" class="btn btn-success btn-sm mt-2">Tambah Opsi</button>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">Simpan Soal</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const optionsContainer = document.getElementById('options-container');
    const addOptionBtn = document.getElementById('add-option-btn');

    const createOptionRow = (index, isChecked = false) => {
        const char = String.fromCharCode(65 + index); // A, B, C, ...
        const newRow = document.createElement('div');
        newRow.classList.add('input-group', 'mb-2');
        newRow.innerHTML = `
            <div class="input-group-text">
                <input class="form-check-input mt-0" type="radio" name="jawaban" value="${index}" ${isChecked ? 'checked' : ''} required>
            </div>
            <span class="input-group-text">${char}.</span>
            <input type="text" name="opsi[]" class="form-control" placeholder="Teks Jawaban ${char}" required>
            <button type="button" class="btn btn-danger remove-option-btn">Hapus</button>
        `;
        return newRow;
    };

    const updateRadioValues = () => {
        const rows = optionsContainer.querySelectorAll('.input-group');
        rows.forEach((row, index) => {
            const radio = row.querySelector('input[type="radio"]');
            radio.value = index;
            const char = String.fromCharCode(65 + index);
            row.querySelector('.input-group-text:nth-child(2)').textContent = `${char}.`;
            row.querySelector('input[type="text"]').placeholder = `Teks Jawaban ${char}`;
        });
    };

    addOptionBtn.addEventListener('click', () => {
        const currentIndex = optionsContainer.children.length;
        const newRow = createOptionRow(currentIndex);
        optionsContainer.appendChild(newRow);
    });

    optionsContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-option-btn')) {
            if (optionsContainer.children.length > 2) {
                e.target.closest('.input-group').remove();
                updateRadioValues();
            } else {
                alert('Minimal harus ada 2 opsi jawaban.');
            }
        }
    });

    // Tambahkan 4 opsi default saat halaman dimuat
    for (let i = 0; i < 4; i++) {
        // Opsi pertama otomatis terpilih sebagai jawaban
        const newRow = createOptionRow(i, i === 0);
        optionsContainer.appendChild(newRow);
    }
});
</script>
@endsection
