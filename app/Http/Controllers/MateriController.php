<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Kurikulum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MateriController extends Controller
{
    /**
     * Menampilkan daftar semua materi.
     */
    public function index()
    {
        // Menggunakan eager loading (with) untuk efisiensi query ke database
        $materis = Materi::with('kurikulum')
                     ->orderBy('urutan', 'asc') // <-- URUTKAN BERDASARKAN NOMOR URUTAN
                     ->latest()
                     ->paginate(10);
        return view('materis.index', compact('materis'));
    }

    /**
     * Menampilkan form untuk membuat materi baru.
     */
    public function create()
    {
        // Mengambil semua data kurikulum untuk ditampilkan di dropdown
        $kurikulums = Kurikulum::orderBy('nama', 'asc')->get();
        return view('materis.create', compact('kurikulums'));
    }

    /**
     * Menyimpan materi baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'id_kurikulum' => 'required|exists:kurikulums,id_kurikulum',
            'urutan' => 'required|integer|min:0',
            'judul' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'rangkuman' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:5120', // 5MB Max
            'youtube' => 'nullable|url'
        ]);

        $fileName = null;

        // 2. Proses Upload File jika ada
        if ($request->hasFile('file')) {
            $fileName = time() . '_' . $request->file->getClientOriginalName();
            $request->file->move(public_path('files'), $fileName);
        }

        // 3. Simpan ke Database
        Materi::create([
            'id_kurikulum' => $request->id_kurikulum,
            'urutan' => $request->urutan,
            'judul' => $request->judul,
            'keterangan' => $request->keterangan,
            'rangkuman' => $request->rangkuman,
            'youtube' => $request->youtube,
            'file' => $fileName,
        ]);

        return redirect()->route('materis.index')
                         ->with('success', 'Materi berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail satu materi.
     */
    public function show(Materi $materi)
    {
        return view('materis.show', compact('materi'));
    }

    /**
     * Menampilkan form untuk mengedit materi.
     */
    public function edit(Materi $materi)
    {
        // Mengambil semua data kurikulum untuk dropdown
        $kurikulums = Kurikulum::orderBy('nama', 'asc')->get();
        return view('materis.edit', compact('materi', 'kurikulums'));
    }

    /**
     * Memperbarui data materi di database.
     */
    public function update(Request $request, Materi $materi)
    {
        // 1. Validasi Input
        $request->validate([
            'id_kurikulum' => 'required|exists:kurikulums,id_kurikulum',
            'urutan' => 'required|integer|min:0',
            'judul' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'rangkuman' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:5120',
            'youtube' => 'nullable|url'
        ]);

        $input = $request->except('file'); // Ambil semua input kecuali file

        // 2. Proses Upload File baru jika ada
        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($materi->file && File::exists(public_path('files/' . $materi->file))) {
                File::delete(public_path('files/' . $materi->file));
            }
            // Simpan file baru
            $fileName = time() . '_' . $request->file->getClientOriginalName();
            $request->file->move(public_path('files'), $fileName);
            $input['file'] = $fileName;
        }

        // 3. Update data di database
        $materi->update($input);

        return redirect()->route('materis.index')
                         ->with('success', 'Materi berhasil diperbarui.');
    }

    /**
     * Menghapus materi dari database.
     */
    public function destroy(Materi $materi)
    {
        // 1. Hapus file dari folder public jika ada
        if ($materi->file && File::exists(public_path('files/' . $materi->file))) {
            File::delete(public_path('files/' . $materi->file));
        }

        // 2. Hapus data dari database
        $materi->delete();

        return redirect()->route('materis.index')
                         ->with('success', 'Materi berhasil dihapus.');
    }

    // app/Http/Controllers/MateriController.php

    // ... (tambahkan di dalam class MateriController)

    /**
     * Menampilkan halaman kuis untuk sebuah materi.
     */
    public function quiz(Materi $materi)
    {
        // Mengambil semua soal dalam urutan acak
        $soals = $materi->soals()->inRandomOrder()->get();
        return view('materis.quiz', compact('materi', 'soals'));
    }

    /**
     * Memproses jawaban kuis, mengakumulasi skor, dan menyimpan ke session.
     */
    public function submitQuiz(Request $request, Materi $materi)
    {
        // 1. Ambil semua jawaban pengguna dari form
        $userAnswers = $request->input('answers', []);

        // 2. Ambil semua soal dari database untuk perbandingan
        $soals = $materi->soals()->get();

        // 3. Inisialisasi variabel untuk akumulasi
        $correctAnswers = 0;
        $totalQuestions = $soals->count();
        $resultsData = []; // Array untuk menyimpan detail setiap jawaban

        // 4. Loop setiap soal untuk memeriksa jawaban
        foreach ($soals as $soal) {
            $userAnswer = $userAnswers[$soal->id_soal] ?? null; // Ambil jawaban user untuk soal ini
            $isCorrect = ($userAnswer === $soal->jawaban);

            if ($isCorrect) {
                $correctAnswers++;
            }

            // Akumulasi data ke dalam array untuk ditampilkan di halaman hasil
            $resultsData[] = [
                'pertanyaan' => $soal->pertanyaan,
                'opsi' => $soal->opsi,
                'jawaban_benar' => $soal->jawaban,
                'jawaban_user' => $userAnswer,
                'is_correct' => $isCorrect,
            ];
        }

        // 5. Hitung skor akhir
        $score = ($totalQuestions > 0) ? ($correctAnswers / $totalQuestions) * 100 : 0;

        // 6. Simpan seluruh hasil ke dalam session
        session()->put('quiz_results', [
            'materi_judul' => $materi->judul,
            'score' => round($score),
            'correct_answers' => $correctAnswers,
            'total_questions' => $totalQuestions,
            'results_data' => $resultsData, // Simpan array detail jawaban
        ]);

        // 7. Arahkan pengguna ke halaman hasil
        return redirect()->route('materis.result', $materi->slug);
    }

    /**
     * Menampilkan halaman hasil kuis dari data session.
     */
    public function result(Materi $materi)
    {
        // Ambil data hasil dari session, lalu langsung hapus (agar tidak bisa di-refresh)
        $results = session()->pull('quiz_results');

        // Jika pengguna mencoba akses halaman hasil tanpa mengerjakan kuis, kembalikan
        if (!$results) {
            return redirect()->route('materis.quiz', $materi->slug)
                            ->with('error', 'Anda harus menyelesaikan kuis terlebih dahulu untuk melihat hasil.');
        }

        return view('materis.result', compact('results'));
    }

}
