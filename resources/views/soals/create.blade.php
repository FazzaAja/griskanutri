@extends('layouts.app')

@section('title', 'Tambah Soal Baru')

@section('content')
    <div class="content-header">
        <h4 class="title is-4">Tambah Soal Baru</h4>
        <span class="separator"></span>
        <nav class="breadcrumb has-bullet-separator" aria-label="breadcrumbs">
            <ul>
                <li><a href="{{ route('materis.index') }}">Materi</a></li>
                <li><a href="{{ route('materis.soals.index', $materi->slug) }}">Daftar Soal</a></li>
                <li class="is-active"><a href="#" aria-current="page">Tambah Soal</a></li>
            </ul>
        </nav>
    </div>

    <div class="content-body">
        <div class="card">
            <div class="card-header">
                <h5 class="card-header-title">Tambah Soal untuk: {{ $materi->judul }}</h5>
            </div>
            <div class="card-content">
                @if ($errors->any())
                    <div class="notification is-danger is-light">
                        <button class="delete"></button>
                        <strong>Ups!</strong> Ada masalah dengan input Anda.<br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('materis.soals.store', $materi->slug) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="field">
                        <label for="pertanyaan" class="label">Pertanyaan</label>
                        <div class="control">
                            <textarea class="textarea" name="pertanyaan" placeholder="Tulis pertanyaan di sini..." required>{{ old('pertanyaan') }}</textarea>
                        </div>
                    </div>

                    <div class="field">
                        <label for="img" class="label">Gambar (Opsional)</label>
                        <div class="file has-name is-fullwidth">
                            <label class="file-label">
                                <input class="file-input" type="file" name="img">
                                <span class="file-cta">
                                    <span class="file-icon"><i class="fa fa-upload"></i></span>
                                    <span class="file-label">Pilih gambar…</span>
                                </span>
                                <span class="file-name">Tidak ada file terpilih</span>
                            </label>
                        </div>
                    </div>

                    <hr>
                    <h5 class="title is-5">Opsi Jawaban & Kunci Jawaban</h5>
                    <p class="subtitle is-6">Pilih salah satu radio button untuk menentukan kunci jawaban.</p>
                    <div id="options-container">
                        {{-- Opsi jawaban akan ditambahkan oleh JavaScript --}}
                    </div>
                    <button type="button" id="add-option-btn" class="button is-success is-small mt-2">
                        <span class="icon is-small"><i class="fa fa-plus"></i></span>
                        <span>Tambah Opsi</span>
                    </button>

                    <div class="field is-grouped mt-5">
                        <div class="control">
                            <button type="submit" class="button is-primary">Simpan Soal</button>
                        </div>
                        <div class="control">
                            <a href="{{ route('materis.soals.index', $materi->slug) }}" class="button is-text">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const optionsContainer = document.getElementById('options-container');
    const addOptionBtn = document.getElementById('add-option-btn');

    // Fungsi untuk membuat baris opsi jawaban dengan gaya Bulma
    const createOptionRow = (index, isChecked = false, value = '') => {
        const char = String.fromCharCode(65 + index); // A, B, C, ...
        const newRow = document.createElement('div');
        newRow.classList.add('field', 'has-addons', 'mb-2');
        newRow.innerHTML = `
            <div class="control">
                <label class="button is-static">${char}</label>
            </div>
            <div class="control">
                <label class="button">
                    <input type="radio" name="jawaban" value="${index}" ${isChecked ? 'checked' : ''} required>
                </label>
            </div>
            <div class="control is-expanded">
                <input type="text" name="opsi[]" class="input" placeholder="Teks Jawaban ${char}" value="${value}" required>
            </div>
            <div class="control">
                <button type="button" class="button is-danger remove-option-btn">
                    <span class="icon is-small"><i class="fa fa-trash"></i></span>
                </button>
            </div>
        `;
        return newRow;
    };

    // Fungsi untuk memperbarui nilai radio button dan label setelah menghapus
    const updateOptionAttributes = () => {
        const rows = optionsContainer.querySelectorAll('.field.has-addons');
        rows.forEach((row, index) => {
            const char = String.fromCharCode(65 + index);
            row.querySelector('label.button.is-static').textContent = char;
            row.querySelector('input[type="radio"]').value = index;
            row.querySelector('input[type="text"]').placeholder = `Teks Jawaban ${char}`;
        });
        // Pastikan minimal satu radio button terpilih jika yang terpilih sebelumnya dihapus
        if (!optionsContainer.querySelector('input[type="radio"]:checked') && rows.length > 0) {
            optionsContainer.querySelector('input[type="radio"]').checked = true;
        }
    };

    // Event listener untuk tombol 'Tambah Opsi'
    addOptionBtn.addEventListener('click', () => {
        const currentIndex = optionsContainer.children.length;
        optionsContainer.appendChild(createOptionRow(currentIndex));
    });

    // Event listener untuk tombol 'Hapus'
    optionsContainer.addEventListener('click', function(e) {
        const removeBtn = e.target.closest('.remove-option-btn');
        if (removeBtn) {
            if (optionsContainer.children.length > 2) {
                removeBtn.closest('.field.has-addons').remove();
                updateOptionAttributes();
            } else {
                alert('Minimal harus ada 2 opsi jawaban.');
            }
        }
    });

    // Tambahkan 4 opsi default saat halaman dimuat
    for (let i = 0; i < 4; i++) {
        optionsContainer.appendChild(createOptionRow(i, i === 0)); // Opsi pertama terpilih
    }
});
</script>
@endpush
