<?php

namespace App\Http\Controllers;
use App\Models\Kurikulum;
use App\Models\Materi;
use App\Models\Resep;
use App\Models\User;
use App\Models\Soal;

use Illuminate\Http\Request;
use Carbon\Carbon;

class LandingPageController extends Controller
{

    public function dashboard()
    {
        // Hitung jumlah total data dari setiap model
        $userCount = User::count();
        $materiCount = Materi::count();
        $soalCount = Soal::count();
        $resepCount = Resep::count();

        // Nanti kita bisa tambahkan data dari database di sini
        return view('dashboard' , compact(
            'userCount',
            'materiCount',
            'soalCount',
            'resepCount'
        ));
    }

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

     /**
     * Menampilkan halaman form kalkulator.
     */
    public function showForm()
    {
        return view('landing.stunting-form');
    }

    /**
     * Memproses data dan menghitung Z-score.
     */
    public function calculate(Request $request)
    {
        // 1. Validasi
        $validated = $request->validate([
            'nama_anak' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date|before_or_equal:today',
            'jenis_kelamin' => 'required|in:L,P',
            'tinggi_badan' => 'required|numeric|min:40|max:130',
        ]);

        // 2. Hitung Umur
        $tanggalLahir = Carbon::parse($validated['tanggal_lahir']);
        $umurBulan = $tanggalLahir->diffInMonths(now());

        // 3. Ambil data WHO
        $whoData = $this->getWhoData();
        $jenisKelaminKey = ($validated['jenis_kelamin'] == 'L') ? 'laki' : 'perempuan';

        if (!isset($whoData[$jenisKelaminKey][$umurBulan])) {
            return back()->withInput()->with('error', 'Data standar WHO untuk anak usia ' . $umurBulan . ' bulan tidak tersedia.');
        }

        $standar = $whoData[$jenisKelaminKey][$umurBulan];
        $l = $standar['l'];
        $m = $standar['m'];
        $s = $standar['s'];
        $tinggiBadan = $validated['tinggi_badan'];

        // 4. Hitung Z-Score
        $zscore = (pow(($tinggiBadan / $m), $l) - 1) / ($l * $s);

        // 5. Tentukan Status Gizi
        $statusGizi = '';
        if ($zscore < -3) {
            $statusGizi = 'Sangat Pendek (Severely Stunted)';
        } elseif ($zscore < -2) {
            $statusGizi = 'Pendek (Stunted)';
        } else {
            $statusGizi = 'Normal';
        }

        // 6. Kembalikan hasil ke view
        return view('landing.stunting-hasil', [
            'input' => $validated,
            'umurBulan' => $umurBulan,
            // BARIS YANG DIUBAH: Bulatkan Z-score menjadi 2 desimal
            'zscore' => round($zscore, 2),
            'statusGizi' => $statusGizi
        ]);
    }

    /**
     * Menyediakan data sampel standar pertumbuhan WHO (LMS values).
     * Sumber: WHO Child Growth Standards, Tabel Length/Height-for-age
     * PENTING: Di aplikasi production, data ini sebaiknya disimpan di database.
     */
    private function getWhoData()
    {
        // Format: [umur_bulan => ['l' => Box-Cox power, 'm' => median, 's' => coefficient of variation]]
        return [
            'laki' => [
                0 => ['l' => 1, 'm' => 49.9, 's' => 0.0380],
                1 => ['l' => 1, 'm' => 54.7, 's' => 0.0366],
                2 => ['l' => 1, 'm' => 58.4, 's' => 0.0355],
                3 => ['l' => 1, 'm' => 61.4, 's' => 0.0346],
                4 => ['l' => 1, 'm' => 63.9, 's' => 0.0339],
                5 => ['l' => 1, 'm' => 65.9, 's' => 0.0334],
                6 => ['l' => 1, 'm' => 67.6, 's' => 0.0330],
                7 => ['l' => 1, 'm' => 69.2, 's' => 0.0326],
                8 => ['l' => 1, 'm' => 70.6, 's' => 0.0323],
                9 => ['l' => 1, 'm' => 72.0, 's' => 0.0321],
                10 => ['l' => 1, 'm' => 73.3, 's' => 0.0319],
                11 => ['l' => 1, 'm' => 74.5, 's' => 0.0318],
                12 => ['l' => 1, 'm' => 75.7, 's' => 0.0317],
                13 => ['l' => 1, 'm' => 76.9, 's' => 0.0316],
                14 => ['l' => 1, 'm' => 78.0, 's' => 0.0316],
                15 => ['l' => 1, 'm' => 79.1, 's' => 0.0316],
                16 => ['l' => 1, 'm' => 80.2, 's' => 0.0316],
                17 => ['l' => 1, 'm' => 81.2, 's' => 0.0316],
                18 => ['l' => 1, 'm' => 82.3, 's' => 0.0317],
                19 => ['l' => 1, 'm' => 83.2, 's' => 0.0318],
                20 => ['l' => 1, 'm' => 84.2, 's' => 0.0319],
                21 => ['l' => 1, 'm' => 85.1, 's' => 0.0320],
                22 => ['l' => 1, 'm' => 86.0, 's' => 0.0322],
                23 => ['l' => 1, 'm' => 86.9, 's' => 0.0323],
                24 => ['l' => -0.5, 'm' => 87.1, 's' => 0.0329],
                25 => ['l' => -0.5, 'm' => 87.9, 's' => 0.0330],
                26 => ['l' => -0.5, 'm' => 88.7, 's' => 0.0331],
                27 => ['l' => -0.5, 'm' => 89.6, 's' => 0.0332],
                28 => ['l' => -0.5, 'm' => 90.4, 's' => 0.0333],
                29 => ['l' => -0.5, 'm' => 91.2, 's' => 0.0334],
                30 => ['l' => -0.5, 'm' => 91.9, 's' => 0.0335],
                31 => ['l' => -0.5, 'm' => 92.7, 's' => 0.0336],
                32 => ['l' => -0.5, 'm' => 93.4, 's' => 0.0337],
                33 => ['l' => -0.5, 'm' => 94.1, 's' => 0.0338],
                34 => ['l' => -0.5, 'm' => 94.8, 's' => 0.0339],
                35 => ['l' => -0.5, 'm' => 95.4, 's' => 0.0340],
                36 => ['l' => -0.5, 'm' => 96.1, 's' => 0.0341],
                37 => ['l' => -0.5, 'm' => 96.7, 's' => 0.0342],
                38 => ['l' => -0.5, 'm' => 97.4, 's' => 0.0343],
                39 => ['l' => -0.5, 'm' => 98.0, 's' => 0.0344],
                40 => ['l' => -0.5, 'm' => 98.6, 's' => 0.0345],
                41 => ['l' => -0.5, 'm' => 99.2, 's' => 0.0346],
                42 => ['l' => -0.5, 'm' => 99.9, 's' => 0.0347],
                43 => ['l' => -0.5, 'm' => 100.4, 's' => 0.0348],
                44 => ['l' => -0.5, 'm' => 101.0, 's' => 0.0349],
                45 => ['l' => -0.5, 'm' => 101.6, 's' => 0.0350],
                46 => ['l' => -0.5, 'm' => 102.2, 's' => 0.0351],
                47 => ['l' => -0.5, 'm' => 102.8, 's' => 0.0352],
                48 => ['l' => -0.5, 'm' => 103.3, 's' => 0.0353],
                49 => ['l' => -0.5, 'm' => 103.9, 's' => 0.0354],
                50 => ['l' => -0.5, 'm' => 104.5, 's' => 0.0355],
                51 => ['l' => -0.5, 'm' => 105.0, 's' => 0.0356],
                52 => ['l' => -0.5, 'm' => 105.6, 's' => 0.0357],
                53 => ['l' => -0.5, 'm' => 106.1, 's' => 0.0358],
                54 => ['l' => -0.5, 'm' => 106.7, 's' => 0.0359],
                55 => ['l' => -0.5, 'm' => 107.2, 's' => 0.0360],
                56 => ['l' => -0.5, 'm' => 107.8, 's' => 0.0361],
                57 => ['l' => -0.5, 'm' => 108.3, 's' => 0.0362],
                58 => ['l' => -0.5, 'm' => 108.9, 's' => 0.0363],
                59 => ['l' => -0.5, 'm' => 109.4, 's' => 0.0364],
                60 => ['l' => -0.5, 'm' => 110.0, 's' => 0.0365],
            ],
            'perempuan' => [
                0 => ['l' => 1, 'm' => 49.1, 's' => 0.0388],
                1 => ['l' => 1, 'm' => 53.7, 's' => 0.0371],
                2 => ['l' => 1, 'm' => 57.1, 's' => 0.0359],
                3 => ['l' => 1, 'm' => 59.8, 's' => 0.0349],
                4 => ['l' => 1, 'm' => 62.1, 's' => 0.0342],
                5 => ['l' => 1, 'm' => 64.0, 's' => 0.0336],
                6 => ['l' => 1, 'm' => 65.7, 's' => 0.0331],
                7 => ['l' => 1, 'm' => 67.3, 's' => 0.0327],
                8 => ['l' => 1, 'm' => 68.7, 's' => 0.0324],
                9 => ['l' => 1, 'm' => 70.1, 's' => 0.0322],
                10 => ['l' => 1, 'm' => 71.5, 's' => 0.0320],
                11 => ['l' => 1, 'm' => 72.8, 's' => 0.0318],
                12 => ['l' => 1, 'm' => 74.0, 's' => 0.0317],
                13 => ['l' => 1, 'm' => 75.2, 's' => 0.0317],
                14 => ['l' => 1, 'm' => 76.4, 's' => 0.0316],
                15 => ['l' => 1, 'm' => 77.5, 's' => 0.0316],
                16 => ['l' => 1, 'm' => 78.6, 's' => 0.0316],
                17 => ['l' => 1, 'm' => 79.7, 's' => 0.0317],
                18 => ['l' => 1, 'm' => 80.7, 's' => 0.0317],
                19 => ['l' => 1, 'm' => 81.7, 's' => 0.0318],
                20 => ['l' => 1, 'm' => 82.7, 's' => 0.0319],
                21 => ['l' => 1, 'm' => 83.7, 's' => 0.0320],
                22 => ['l' => 1, 'm' => 84.6, 's' => 0.0322],
                23 => ['l' => 1, 'm' => 85.5, 's' => 0.0323],
                24 => ['l' => -0.4, 'm' => 85.7, 's' => 0.0332],
                25 => ['l' => -0.4, 'm' => 86.6, 's' => 0.0333],
                26 => ['l' => -0.4, 'm' => 87.4, 's' => 0.0334],
                27 => ['l' => -0.4, 'm' => 88.3, 's' => 0.0335],
                28 => ['l' => -0.4, 'm' => 89.1, 's' => 0.0336],
                29 => ['l' => -0.4, 'm' => 89.9, 's' => 0.0337],
                30 => ['l' => -0.4, 'm' => 90.7, 's' => 0.0338],
                31 => ['l' => -0.4, 'm' => 91.4, 's' => 0.0339],
                32 => ['l' => -0.4, 'm' => 92.2, 's' => 0.0340],
                33 => ['l' => -0.4, 'm' => 92.9, 's' => 0.0341],
                34 => ['l' => -0.4, 'm' => 93.6, 's' => 0.0342],
                35 => ['l' => -0.4, 'm' => 94.4, 's' => 0.0343],
                36 => ['l' => -0.4, 'm' => 95.1, 's' => 0.0344],
                37 => ['l' => -0.4, 'm' => 95.7, 's' => 0.0345],
                38 => ['l' => -0.4, 'm' => 96.4, 's' => 0.0346],
                39 => ['l' => -0.4, 'm' => 97.1, 's' => 0.0347],
                40 => ['l' => -0.4, 'm' => 97.7, 's' => 0.0348],
                41 => ['l' => -0.4, 'm' => 98.4, 's' => 0.0349],
                42 => ['l' => -0.4, 'm' => 99.0, 's' => 0.0350],
                43 => ['l' => -0.4, 'm' => 99.7, 's' => 0.0351],
                44 => ['l' => -0.4, 'm' => 100.3, 's' => 0.0352],
                45 => ['l' => -0.4, 'm' => 100.9, 's' => 0.0353],
                46 => ['l' => -0.4, 'm' => 101.5, 's' => 0.0354],
                47 => ['l' => -0.4, 'm' => 102.1, 's' => 0.0355],
                48 => ['l' => -0.4, 'm' => 102.7, 's' => 0.0356],
                49 => ['l' => -0.4, 'm' => 103.3, 's' => 0.0357],
                50 => ['l' => -0.4, 'm' => 103.9, 's' => 0.0358],
                51 => ['l' => -0.4, 'm' => 104.5, 's' => 0.0359],
                52 => ['l' => -0.4, 'm' => 105.0, 's' => 0.0360],
                53 => ['l' => -0.4, 'm' => 105.6, 's' => 0.0361],
                54 => ['l' => -0.4, 'm' => 106.2, 's' => 0.0362],
                55 => ['l' => -0.4, 'm' => 106.7, 's' => 0.0363],
                56 => ['l' => -0.4, 'm' => 107.3, 's' => 0.0364],
                57 => ['l' => -0.4, 'm' => 107.8, 's' => 0.0365],
                58 => ['l' => -0.4, 'm' => 108.4, 's' => 0.0366],
                59 => ['l' => -0.4, 'm' => 108.9, 's' => 0.0367],
                60 => ['l' => -0.4, 'm' => 109.4, 's' => 0.0368],
            ],
        ];
    }
}
