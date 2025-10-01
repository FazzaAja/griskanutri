@extends('layouts.app')

@section('title', 'Edit Materi')

@section('content')
    {{-- Header Halaman --}}
    <div class="content-header">
        <h4 class="title is-4">Edit Materi</h4>
        <span class="separator"></span>
        <nav class="breadcrumb has-bullet-separator" aria-label="breadcrumbs">
            <ul>
                <li><a href="{{ route('materis.index') }}">Materi</a></li>
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
                        <strong>Ups!</strong> Ada masalah dengan input Anda:<br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('materis.update', $materi->slug) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Field Kurikulum --}}
                    <div class="field">
                        <label for="id_kurikulum" class="label">Kurikulum</label>
                        <div class="control">
                            <div class="select is-fullwidth @error('id_kurikulum') is-danger @enderror">
                                <select name="id_kurikulum" required>
                                    <option value="" disabled>-- Pilih Kurikulum --</option>
                                    @foreach ($kurikulums as $kurikulum)
                                        <option value="{{ $kurikulum->id_kurikulum }}" {{ old('id_kurikulum', $materi->id_kurikulum) == $kurikulum->id_kurikulum ? 'selected' : '' }}>
                                            {{ $kurikulum->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @error('id_kurikulum')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Field Judul Materi --}}
                    <div class="field">
                        <label for="judul" class="label">Judul Materi</label>
                        <div class="control">
                            <input type="text" name="judul" class="input @error('judul') is-danger @enderror" value="{{ old('judul', $materi->judul) }}" required>
                        </div>
                        @error('judul')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Field Nomor Urutan Materi --}}
                    <div class="field">
                        <label for="urutan" class="label">Nomor Urutan Materi</label>
                        <div class="control">
                            <input type="number" name="urutan" class="input @error('urutan') is-danger @enderror" value="{{ old('urutan', $materi->urutan) }}" required>
                        </div>
                        <p class="help">Materi akan diurutkan dari angka terkecil ke terbesar.</p>
                        @error('urutan')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Field Keterangan --}}
                    <div class="field">
                        <label for="keterangan" class="label">Keterangan</label>
                        <div class="control">
                            <textarea class="textarea @error('keterangan') is-danger @enderror" name="keterangan" placeholder="Deskripsi singkat materi">{{ old('keterangan', $materi->keterangan) }}</textarea>
                        </div>
                        @error('keterangan')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Field Rangkuman --}}
                    <div class="field">
                        <label for="rangkuman" class="label">Rangkuman</label>
                        <div class="control">
                            <textarea class="textarea @error('rangkuman') is-danger @enderror" style="height:150px" name="rangkuman" placeholder="Rangkuman detail materi">{{ old('rangkuman', $materi->rangkuman) }}</textarea>
                        </div>
                        @error('rangkuman')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Field File --}}
                    <div class="field">
                        <label for="file" class="label">File (Modul/PDF)</label>
                        <div class="file has-name is-fullwidth">
                            <label class="file-label">
                                <input class="file-input" type="file" name="file">
                                <span class="file-cta">
                                    <span class="file-icon"><i class="fa fa-upload"></i></span>
                                    <span class="file-label">Pilih file baru…</span>
                                </span>
                                <span class="file-name">{{ $materi->file ?? 'Tidak ada file terpilih' }}</span>
                            </label>
                        </div>
                        @if($materi->file)
                            <p class="help">File saat ini: <a href="{{ asset('storage/files/'.$materi->file) }}" target="_blank">{{ $materi->file }}</a>. Biarkan kosong jika tidak ingin mengubah file.</p>
                        @else
                            <p class="help">Belum ada file terunggah.</p>
                        @endif
                        @error('file')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Field Link Video YouTube --}}
                    <div class="field">
                        <label for="youtube" class="label">Link Video YouTube</label>
                        <div class="control has-icons-left">
                            <input type="url" name="youtube" class="input @error('youtube') is-danger @enderror" placeholder="https://www.youtube.com/watch?v=xxxxxxxxxxx" value="{{ old('youtube', $materi->youtube) }}">
                            <span class="icon is-small is-left"><i class="fab fa-youtube"></i></span>
                        </div>
                        @error('youtube')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="field is-grouped mt-5">
                        <div class="control">
                            <button type="submit" class="button is-primary">Perbarui</button>
                        </div>
                        <div class="control">
                             <a href="{{ route('materis.index') }}" class="button is-text">Batal</a>
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
            } else {
                // Jika tidak ada file yang dipilih setelah perubahan, kembalikan ke teks default atau nama file lama
                const fileName = input.closest('.file').querySelector('.file-name');
                // Untuk edit, bisa mempertahankan nama file lama jika tidak ada input baru
                const oldFileName = input.closest('.file').dataset.oldFileName || 'Tidak ada file terpilih';
                fileName.textContent = oldFileName;
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
