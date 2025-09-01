<?php

namespace App\Http\Controllers;

use App\Models\Kurikulum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; // <-- Ganti Storage dengan File

class KurikulumController extends Controller
{
    /**
     * Menampilkan daftar semua kurikulum.
     */
    public function index()
    {
        $kurikulums = Kurikulum::latest()->paginate(10);
        return view('kurikulums.index', compact('kurikulums'));
    }

    /**
     * Menampilkan form untuk membuat kurikulum baru.
     */
    public function create()
    {
        return view('kurikulums.create');
    }

    /**
     * Menyimpan kurikulum baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input (tetap sama)
        $request->validate([
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:5120',
        ]);

        $imageName = null;
        $fileName = null;

        // 2. Proses Upload Gambar (img) dengan metode move()
        if ($request->hasFile('img')) {
            $imageName = time() . '.' . $request->img->extension();
            // Pindahkan file langsung ke folder public/images
            $request->img->move(public_path('images'), $imageName);
        }

        // 3. Proses Upload File (file) dengan metode move()
        if ($request->hasFile('file')) {
            $fileName = time() . '_' . $request->file->getClientOriginalName();
            // Pindahkan file langsung ke folder public/files
            $request->file->move(public_path('files'), $fileName);
        }

        // 4. Simpan ke Database (tetap sama)
        Kurikulum::create([
            'nama' => $request->nama,
            'keterangan' => $request->keterangan,
            'img' => $imageName,
            'file' => $fileName,
        ]);

        return redirect()->route('kurikulums.index')
                         ->with('success', 'Kurikulum berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail satu kurikulum.
     */
    public function show(Kurikulum $kurikulum)
    {
        return view('kurikulums.show', compact('kurikulum'));
    }

    /**
     * Menampilkan form untuk mengedit kurikulum.
     */
    public function edit(Kurikulum $kurikulum)
    {
        return view('kurikulums.edit', compact('kurikulum'));
    }

    /**
     * Memperbarui data kurikulum di database.
     */
    public function update(Request $request, Kurikulum $kurikulum)
    {
        // 1. Validasi Input (tetap sama)
        $request->validate([
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:5120',
        ]);

        $input = $request->all();

        // 2. Cek & Proses Upload Gambar Baru
        if ($request->hasFile('img')) {
            // Hapus gambar lama dari folder public
            if ($kurikulum->img && File::exists(public_path('images/' . $kurikulum->img))) {
                File::delete(public_path('images/' . $kurikulum->img));
            }
            // Simpan gambar baru
            $imageName = time() . '.' . $request->img->extension();
            $request->img->move(public_path('images'), $imageName);
            $input['img'] = $imageName;
        }

        // 3. Cek & Proses Upload File Baru
        if ($request->hasFile('file')) {
            // Hapus file lama dari folder public
            if ($kurikulum->file && File::exists(public_path('files/' . $kurikulum->file))) {
                File::delete(public_path('files/' . $kurikulum->file));
            }
            // Simpan file baru
            $fileName = time() . '_' . $request->file->getClientOriginalName();
            $request->file->move(public_path('files'), $fileName);
            $input['file'] = $fileName;
        }

        // 4. Update data di database
        $kurikulum->update($input);

        return redirect()->route('kurikulums.index')
                         ->with('success', 'Kurikulum berhasil diperbarui.');
    }

    /**
     * Menghapus kurikulum dari database.
     */
    public function destroy(Kurikulum $kurikulum)
    {
        // 1. Hapus gambar dari folder public jika ada
        if ($kurikulum->img && File::exists(public_path('images/' . $kurikulum->img))) {
            File::delete(public_path('images/' . $kurikulum->img));
        }

        // 2. Hapus file dari folder public jika ada
        if ($kurikulum->file && File::exists(public_path('files/' . $kurikulum->file))) {
            File::delete(public_path('files/' . $kurikulum->file));
        }

        // 3. Hapus data dari database
        $kurikulum->delete();

        return redirect()->route('kurikulums.index')
                         ->with('success', 'Kurikulum berhasil dihapus.');
    }
}
