@extends('layouts.app')

@section('title', 'Edit Soal')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3>Edit Soal</h3>
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

        <form action="{{ route('materis.soals.update', [$materi->slug, $soal->id_soal]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="pertanyaan" class="form-label"><strong>Pertanyaan:</strong></label>
                <textarea class="form-control" style="height:100px" name="pertanyaan" required>{{ old('pertanyaan', $soal->pertanyaan) }}</textarea>
            </div>
            <div class="mb-3">
                <label for="img" class="form-label"><strong>Gambar (Opsional):</strong></label>
                <input type="file" name="img" class="form-control">
                @if($soal->img)
                    <div class="mt-2">
                        <small>Gambar saat ini:</small><br>
                        <img src="{{ asset('images/soal/' . $soal->img) }}" alt="Gambar Soal" height="100" class="img-thumbnail">
                    </div>
                @endif
            </div>

            <hr>
            <h5>Opsi Jawaban & Kunci Jawaban</h5>
            <div id="options-container">
                @foreach($soal->opsi as $key => $value)
                    @php $index = ord($key) - 65; @endphp
                    <div class="input-group mb-2">
                        <div class="input-group-text">
                            <input class="form-check-input mt-0" type="radio" name="jawaban" value="{{ $index }}" {{ $soal->jawaban == $key ? 'checked' : '' }} required>
                        </div>
                        <span class="input-group-text">{{ $key }}.</span>
                        <input type="text" name="opsi[]" class="form-control" placeholder="Teks Jawaban {{ $key }}" value="{{ $value }}" required>
                        <button type="button" class="btn btn-danger remove-option-btn">Hapus</button>
                    </div>
                @endforeach
            </div>
            <button type="button" id="add-option-btn" class="btn btn-success btn-sm mt-2">Tambah Opsi</button>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">Perbarui Soal</button>
            </div>
        </form>
    </div>
</div>

<script>
// Salin dan tempel blok <script> yang SAMA PERSIS dari file create.blade.php di sini
document.addEventListener('DOMContentLoaded', function () {
    const optionsContainer = document.getElementById('options-container');
    const addOptionBtn = document.getElementById('add-option-btn');

    const createOptionRow = (index, isChecked = false, value = '') => {
        const char = String.fromCharCode(65 + index); // A, B, C, ...
        const newRow = document.createElement('div');
        newRow.classList.add('input-group', 'mb-2');
        newRow.innerHTML = `
            <div class="input-group-text">
                <input class="form-check-input mt-0" type="radio" name="jawaban" value="${index}" ${isChecked ? 'checked' : ''} required>
            </div>
            <span class="input-group-text">${char}.</span>
            <input type="text" name="opsi[]" class="form-control" placeholder="Teks Jawaban ${char}" value="${value}" required>
            <button type="button" class="btn btn-danger remove-option-btn">Hapus</button>
        `;
        return newRow;
    };

    const updateRadioValuesAndLabels = () => {
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
                updateRadioValuesAndLabels();
            } else {
                alert('Minimal harus ada 2 opsi jawaban.');
            }
        }
    });

    // Jika tidak ada opsi saat edit, tambahkan 2 default
    if (optionsContainer.children.length === 0) {
        optionsContainer.appendChild(createOptionRow(0, true));
        optionsContainer.appendChild(createOptionRow(1));
    }
});
</script>
@endsection
