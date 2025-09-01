<?php

namespace App\Http\Controllers;
use App\Models\Kurikulum;
use App\Models\Materi;
use App\Models\Resep;

use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        // Nanti kita bisa tambahkan data dari database di sini
        return view('landing.index');
    }

    /**
     * Menampilkan detail kurikulum spesifik (ID 1) beserta materinya.
     */
    public function showKurikulum()
    {
        // Ambil SEMUA Kurikulum, bukan hanya find(1)
        // Urutkan kurikulum berdasarkan nama
        $kurikulums = Kurikulum::with(['materis' => function ($query) {
            $query->orderBy('urutan', 'asc');
        }])->orderBy('nama', 'asc')->get();

        // Kirim data jamak ($kurikulums) ke view
        return view('landing.kurikulum', compact('kurikulums'));
    }

    /**
     * Menampilkan halaman detail untuk satu materi spesifik.
     * @param  \App\Models\Materi  $materi
     * @return \Illuminate\View\View
     */
    public function showMateri(Materi $materi)
    {
        // Berkat Route Model Binding, Laravel otomatis menemukan materi berdasarkan slug
        // dan menyediakannya sebagai variabel $materi.

        return view('landing.materi', compact('materi'));
    }

    /**
     * Menampilkan halaman latihan soal (kuis) untuk sebuah materi.
     */
    public function showQuiz(Materi $materi)
    {
        // Ambil semua soal dalam urutan acak
        $soals = $materi->soals()->inRandomOrder()->get();

        return view('landing.quiz', compact('materi', 'soals'));
    }

    /**
     * Memproses jawaban kuis, mengakumulasi skor, dan menyimpan ke session.
     */
    public function submitQuiz(Request $request, Materi $materi)
    {
        $userAnswers = $request->input('answers', []);
        $soals = $materi->soals()->get();

        $correctAnswers = 0;
        $totalQuestions = $soals->count();
        $resultsData = [];

        foreach ($soals as $soal) {
            $userAnswer = $userAnswers[$soal->id_soal] ?? null;
            $isCorrect = ($userAnswer === $soal->jawaban);

            if ($isCorrect) {
                $correctAnswers++;
            }

            $resultsData[] = [
                'pertanyaan' => $soal->pertanyaan,
                'opsi' => $soal->opsi,
                'jawaban_benar' => $soal->jawaban,
                'jawaban_user' => $userAnswer,
                'is_correct' => $isCorrect,
            ];
        }

        $score = ($totalQuestions > 0) ? round(($correctAnswers / $totalQuestions) * 100) : 0;

        session()->put('quiz_results', [
            'materi_judul' => $materi->judul,
            'materi_slug' => $materi->slug,
            'score' => $score,
            'correct_answers' => $correctAnswers,
            'total_questions' => $totalQuestions,
            'results_data' => $resultsData,
        ]);

        return redirect()->route('latihan.result', $materi->slug);
    }

    /**
     * Menampilkan halaman hasil kuis dari data session.
     */
    public function showResult(Materi $materi)
    {
        $results = session()->get('quiz_results');

        // Pastikan hasil hanya bisa dilihat sekali dan sesuai dengan materi
        if (!$results || $results['materi_slug'] !== $materi->slug) {
            return redirect()->route('latihan.show', $materi->slug)
                             ->with('error', 'Anda harus menyelesaikan latihan soal terlebih dahulu.');
        }

        // Hapus session setelah data diambil agar tidak bisa di-refresh
        session()->forget('quiz_results');

        return view('landing.result', compact('results'));
    }

    /**
     * Menampilkan halaman jelajah semua resep dengan fitur pencarian.
     */
    public function indexResep(Request $request)
    {
        $search = $request->input('search');

        $query = Resep::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('bahan', 'like', '%' . $search . '%');
            });
        }

        $reseps = $query->latest()->paginate(12); // Tampilkan 12 resep per halaman

        return view('landing.resep-index', compact('reseps'));
    }

     /**
     * Menampilkan halaman detail resep publik.
     * @param  \App\P\Models\Resep  $resep
     * @return \Illuminate\View\View
     */
    public function showResep(Resep $resep)
    {
        // Eager load relasi nutrisi untuk efisiensi
        $resep->load('nutrisi');

        return view('landing.resep-detail', compact('resep'));
    }
}
