<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class SoalController extends Controller
{
    // ... method index(), create(), show(), edit() biarkan sama ...
    public function index(Materi $materi)
    {
        $soals = $materi->soals()->paginate(10);
        return view('soals.index', compact('materi', 'soals'));
    }

    public function create(Materi $materi)
    {
        return view('soals.create', compact('materi'));
    }

    public function store(Request $request, Materi $materi)
    {
        // 1. Validasi Input Dinamis
        $opsiCount = count($request->input('opsi', []));
        $request->validate([
            'pertanyaan' => 'required|string',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'opsi' => 'required|array|min:2',
            'opsi.*' => 'required|string|distinct', // distinct: opsi tidak boleh sama
            'jawaban' => ['required', 'numeric', 'min:0', 'max:' . ($opsiCount - 1)], // jawaban harus index yang valid
        ]);

        $imageName = null;
        if ($request->hasFile('img')) {
            $imageName = time() . '.' . $request->img->extension();
            $request->img->move(public_path('images/soal'), $imageName);
        }

        // 2. Format Ulang Data Opsi dan Jawaban
        $formattedOpsi = [];
        $opsiKeys = [];
        $char = 'A';
        foreach ($request->opsi as $option) {
            $formattedOpsi[$char] = $option;
            $opsiKeys[] = $char;
            $char++;
        }

        $formattedJawaban = $opsiKeys[$request->jawaban]; // Konversi index (misal: 1) menjadi kunci (misal: 'B')

        // 3. Simpan ke Database
        $materi->soals()->create([
            'pertanyaan' => $request->pertanyaan,
            'opsi' => $formattedOpsi,
            'jawaban' => $formattedJawaban,
            'img' => $imageName,
        ]);

        return redirect()->route('materis.soals.index', $materi->slug)
                         ->with('success', 'Soal berhasil ditambahkan.');
    }

    public function show(Materi $materi, Soal $soal)
    {
        return view('soals.show', compact('materi', 'soal'));
    }

    public function edit(Materi $materi, Soal $soal)
    {
        return view('soals.edit', compact('materi', 'soal'));
    }

    public function update(Request $request, Materi $materi, Soal $soal)
    {
        // 1. Validasi Input Dinamis
        $opsiCount = count($request->input('opsi', []));
        $request->validate([
            'pertanyaan' => 'required|string',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'opsi' => 'required|array|min:2',
            'opsi.*' => 'required|string|distinct',
            'jawaban' => ['required', 'numeric', 'min:0', 'max:' . ($opsiCount - 1)],
        ]);

        // 2. Format Ulang Data Opsi dan Jawaban
        $formattedOpsi = [];
        $opsiKeys = [];
        $char = 'A';
        foreach ($request->opsi as $option) {
            $formattedOpsi[$char] = $option;
            $opsiKeys[] = $char;
            $char++;
        }
        $formattedJawaban = $opsiKeys[$request->jawaban];

        $input = [
            'pertanyaan' => $request->pertanyaan,
            'opsi' => $formattedOpsi,
            'jawaban' => $formattedJawaban,
        ];

        // 3. Proses Upload Gambar
        if ($request->hasFile('img')) {
            if ($soal->img && File::exists(public_path('images/soal/' . $soal->img))) {
                File::delete(public_path('images/soal/' . $soal->img));
            }
            $imageName = time() . '.' . $request->img->extension();
            $request->img->move(public_path('images/soal'), $imageName);
            $input['img'] = $imageName;
        }

        // 4. Update Database
        $soal->update($input);

        return redirect()->route('materis.soals.index', $materi->slug)
                         ->with('success', 'Soal berhasil diperbarui.');
    }

    public function destroy(Materi $materi, Soal $soal)
    {
        if ($soal->img && File::exists(public_path('images/soal/' . $soal->img))) {
            File::delete(public_path('images/soal/' . $soal->img));
        }
        $soal->delete();
        return redirect()->route('materis.soals.index', $materi->slug)
                         ->with('success', 'Soal berhasil dihapus.');
    }
}
