@extends('layouts.app')

@section('title', 'Edit Kurikulum')

@section('content')
    {{-- Header Halaman --}}
    <div class="content-header">
        <h4 class="title is-4">Edit Kurikulum</h4>
        <span class="separator"></span>
        <nav class="breadcrumb has-bullet-separator" aria-label="breadcrumbs">
            <ul>
                <li><a href="{{ route('kurikulums.index') }}">Kurikulum</a></li>
                <li class="is-active"><a href="#" aria-current="page">Edit Data</a></li>
            </ul>
        </nav>
    </div>

    {{-- Konten Utama --}}
    <div class="content-body">
        <div class="card">
            <div class="card-content">
                {{-- Notifikasi Error --}}
                @if ($errors->any())
                    <div class="notification is-danger is-light">
                        <button class="delete"></button>
                        <strong>Ups!</strong> Ada masalah dengan input Anda:
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('kurikulums.update', $kurikulum->id_kurikulum) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Field Nama Kurikulum --}}
                    <div class="field">
                        <label for="nama" class="label">Nama Kurikulum</label>
                        <div class="control">
                            <input type="text" name="nama" class="input @error('nama') is-danger @enderror" value="{{ $kurikulum->nama }}" required>
                        </div>
                        @error('nama')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Field Keterangan --}}
                    <div class="field">
                        <label for="keterangan" class="label">Keterangan</label>
                        <div class="control">
                            <textarea class="textarea @error('keterangan') is-danger @enderror" name="keterangan">{{ $kurikulum->keterangan }}</textarea>
                        </div>
                         @error('keterangan')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Field Gambar --}}
                    <div class="field">
                        <label for="img" class="label">Gambar (Cover)</label>
                        <div class="file has-name">
                            <label class="file-label">
                                <input class="file-input" type="file" name="img">
                                <span class="file-cta">
                                    <span class="file-icon"><i class="fa fa-upload"></i></span>
                                    <span class="file-label">Pilih gambar baru…</span>
                                </span>
                                <span class="file-name">{{ $kurikulum->img ?? 'Tidak ada file terpilih' }}</span>
                            </label>
                        </div>
                        @if($kurikulum->img)
                            <p class="help">Biarkan kosong jika tidak ingin mengubah gambar.</p>
                        @endif
                        @error('img')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Field File --}}
                     <div class="field">
                        <label for="file" class="label">File (Silabus/Modul)</label>
                        <div class="file has-name">
                            <label class="file-label">
                                <input class="file-input" type="file" name="file">
                                <span class="file-cta">
                                    <span class="file-icon"><i class="fa fa-upload"></i></span>
                                    <span class="file-label">Pilih file baru…</span>
                                </span>
                                <span class="file-name">{{ $kurikulum->file ?? 'Tidak ada file terpilih' }}</span>
                            </label>
                        </div>
                        @if($kurikulum->file)
                            <p class="help">Biarkan kosong jika tidak ingin mengubah file.</p>
                        @endif
                        @error('file')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="field is-grouped mt-5">
                        <div class="control">
                            <button type="submit" class="button is-primary">Perbarui</button>
                        </div>
                        <div class="control">
                             <a href="{{ route('kurikulums.index') }}" class="button is-text">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Script untuk menampilkan nama file pada input file Bulma
    document.querySelectorAll('.file-input').forEach(input => {
        input.onchange = () => {
            if (input.files.length > 0) {
                const fileName = input.closest('.file').querySelector('.file-name');
                fileName.textContent = input.files[0].name;
            }
        }
    });

    // Script untuk menutup notifikasi
    document.querySelectorAll('.notification .delete').forEach(($delete) => {
        const $notification = $delete.parentNode;
        $delete.addEventListener('click', () => {
            $notification.parentNode.removeChild($notification);
        });
    });
</script>
@endpush
