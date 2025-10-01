@extends('layouts.app')

@section('title', 'Buat Resep Baru')

@section('content')
    <div class="content-header">
        <h4 class="title is-4">Buat Resep Baru</h4>
        <span class="separator"></span>
        <nav class="breadcrumb has-bullet-separator">
            <ul>
                <li><a href="{{ route('reseps.index') }}">Resep</a></li>
                <li class="is-active"><a href="#">Buat Baru</a></li>
            </ul>
        </nav>
    </div>

    <div class="content-body">
        <div class="card">
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

                <form action="{{ route('reseps.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h5 class="title is-5">Informasi Dasar</h5>
                    <div class="field">
                        <label for="judul" class="label">Judul Resep</label>
                        <div class="control">
                            <input type="text" name="judul" class="input @error('judul') is-danger @enderror" placeholder="Contoh: Nasi Goreng Spesial" value="{{ old('judul') }}" required>
                        </div>
                        @error('judul')<p class="help is-danger">{{ $message }}</p>@enderror
                    </div>

                    <div class="field">
                        <label for="deskripsi" class="label">Deskripsi Singkat</label>
                        <div class="control">
                             <textarea class="textarea @error('deskripsi') is-danger @enderror" name="deskripsi" rows="3" placeholder="Jelaskan sedikit tentang resep ini" required>{{ old('deskripsi') }}</textarea>
                        </div>
                        @error('deskripsi')<p class="help is-danger">{{ $message }}</p>@enderror
                    </div>

                     <div class="field">
                        <label for="img" class="label">Gambar Masakan</label>
                        <div class="file has-name is-fullwidth">
                            <label class="file-label">
                                <input class="file-input" type="file" name="img">
                                <span class="file-cta">
                                    <span class="file-icon"><i class="fa fa-upload"></i></span>
                                    <span class="file-label">Pilih gambar…</span>
                                </span>
                                <span class="file-name">Tidak ada file yang dipilih</span>
                            </label>
                        </div>
                        @error('img')<p class="help is-danger">{{ $message }}</p>@enderror
                    </div>

                    <hr>

                    <div class="columns">
                        <div class="column is-6">
                            @include('reseps.partials.dynamic-input', ['name' => 'bahan', 'label' => 'Bahan-Bahan'])
                        </div>
                        <div class="column is-6">
                            @include('reseps.partials.dynamic-input', ['name' => 'alat', 'label' => 'Alat-Alat'])
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column is-12">
                            @include('reseps.partials.dynamic-input', ['name' => 'langkah', 'label' => 'Langkah-Langkah'])
                        </div>
                    </div>

                    <hr>

                    <h5 class="title is-5">Informasi Nutrisi (per porsi)</h5>
                    <div class="columns is-multiline">
                        <div class="column is-6-tablet is-3-desktop">
                             <div class="field">
                                <label for="kalori" class="label">Kalori (kcal)</label>
                                <div class="control">
                                    <input type="number" step="0.01" name="kalori" class="input" value="{{ old('kalori', 0) }}" required>
                                </div>
                            </div>
                        </div>
                         <div class="column is-6-tablet is-3-desktop">
                             <div class="field">
                                <label for="protein" class="label">Protein (g)</label>
                                <div class="control">
                                    <input type="number" step="0.01" name="protein" class="input" value="{{ old('protein', 0) }}" required>
                                </div>
                            </div>
                        </div>
                         <div class="column is-6-tablet is-3-desktop">
                             <div class="field">
                                <label for="karbo" class="label">Karbohidrat (g)</label>
                                <div class="control">
                                    <input type="number" step="0.01" name="karbo" class="input" value="{{ old('karbo', 0) }}" required>
                                </div>
                            </div>
                        </div>
                         <div class="column is-6-tablet is-3-desktop">
                             <div class="field">
                                <label for="lemak" class="label">Lemak (g)</label>
                                <div class="control">
                                    <input type="number" step="0.01" name="lemak" class="input" value="{{ old('lemak', 0) }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="field is-grouped mt-5">
                        <div class="control">
                            <button type="submit" class="button is-primary">Simpan Resep</button>
                        </div>
                        <div class="control">
                            <a href="{{ route('reseps.index') }}" class="button is-text">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

{{-- Panggil script untuk input dinamis --}}
@include('reseps.partials.dynamic-input-script')

@push('scripts')
<script>
// Skrip tambahan untuk notifikasi dan input file
document.addEventListener('DOMContentLoaded', function() {
    // Skrip untuk menutup notifikasi
    document.querySelectorAll('.notification .delete').forEach(($delete) => {
        const $notification = $delete.parentNode;
        $delete.addEventListener('click', () => {
            $notification.parentNode.removeChild($notification);
        });
    });

    // Skrip untuk menampilkan nama file pada input file Bulma
    document.querySelectorAll('.file-input').forEach(input => {
        input.onchange = () => {
            if (input.files.length > 0) {
                const fileName = input.closest('.file').querySelector('.file-name');
                fileName.textContent = input.files[0].name;
            }
        }
    });
});
</script>
@endpush
