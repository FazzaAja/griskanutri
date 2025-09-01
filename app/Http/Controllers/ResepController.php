<?php

namespace App\Http\Controllers;

use App\Models\Resep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ResepController extends Controller
{
    /**
     * Menampilkan daftar semua resep.
     */
    public function index(Request $request)
    {
        // 1. Ambil input pencarian dari URL query string (?search=...)
        $search = $request->input('search');

        // 2. Query dasar untuk mengambil resep
        $query = Resep::query();

        // 3. Jika ada query pencarian, tambahkan kondisi WHERE
        if ($search) {
            // Gunakan closure untuk mengelompokkan kondisi OR
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                ->orWhere('bahan', 'like', '%' . $search . '%'); // Mencari di dalam kolom JSON bahan
            });
        }

        // 4. Ambil hasil query yang sudah difilter, urutkan, dan paginasi
        $reseps = $query->latest()->paginate(10);

        // 5. Kembalikan view dengan data resep
        return view('reseps.index', compact('reseps'));
    }

    /**
     * Menampilkan form untuk membuat resep baru.
     */
    public function create()
    {
        return view('reseps.create'); // Anda perlu membuat view ini
    }

    /**
     * Menyimpan resep baru beserta data nutrisinya.
     */
    public function store(Request $request)
    {
        // 1. Validasi semua input, termasuk nutrisi
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bahan' => 'required|array|min:1',
            'bahan.*' => 'required|string',
            'alat' => 'required|array|min:1',
            'alat.*' => 'required|string',
            'langkah' => 'required|array|min:1',
            'langkah.*' => 'required|string',
            // Validasi untuk nutrisi
            'kalori' => 'required|numeric|min:0',
            'protein' => 'required|numeric|min:0',
            'karbo' => 'required|numeric|min:0',
            'lemak' => 'required|numeric|min:0',
        ]);

        // 2. Gunakan DB Transaction untuk memastikan kedua data tersimpan
        try {
            DB::beginTransaction();

            $imageName = null;
            if ($request->hasFile('img')) {
                $imageName = time() . '.' . $request->img->extension();
                $request->img->move(public_path('images/reseps'), $imageName);
            }

            // 3. Buat resep terlebih dahulu
            $resep = Resep::create([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'bahan' => $request->bahan, // Array akan di-cast ke JSON oleh model
                'alat' => $request->alat,
                'langkah' => $request->langkah,
                'img' => $imageName,
            ]);

            // 4. Buat data nutrisi menggunakan relasi
            $resep->nutrisi()->create([
                'kalori' => $request->kalori,
                'protein' => $request->protein,
                'karbo' => $request->karbo,
                'lemak' => $request->lemak,
            ]);

            DB::commit(); // Simpan perubahan jika semua berhasil
        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan semua jika ada error
            return back()->with('error', 'Gagal menyimpan resep: ' . $e->getMessage());
        }

        return redirect()->route('reseps.index')
                         ->with('success', 'Resep baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail satu resep.
     */
    public function show(Resep $resep)
    {
        // Eager load relasi nutrisi untuk efisiensi
        $resep->load('nutrisi');
        return view('reseps.show', compact('resep')); // Anda perlu membuat view ini
    }

    /**
     * Menampilkan form untuk mengedit resep.
     */
    public function edit(Resep $resep)
    {
        return view('reseps.edit', compact('resep')); // Anda perlu membuat view ini
    }

    /**
     * Memperbarui resep beserta data nutrisinya.
     */
    public function update(Request $request, Resep $resep)
    {
        // Validasi (sama seperti store)
        $request->validate([
            'judul' => 'required|string|max:255',
            // ... (tambahkan validasi lain seperti di store) ...
            'kalori' => 'required|numeric|min:0',
            'protein' => 'required|numeric|min:0',
            'karbo' => 'required|numeric|min:0',
            'lemak' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $inputResep = $request->only(['judul', 'deskripsi', 'bahan', 'alat', 'langkah']);

            if ($request->hasFile('img')) {
                // Hapus gambar lama
                if ($resep->img && File::exists(public_path('images/reseps/' . $resep->img))) {
                    File::delete(public_path('images/reseps/' . $resep->img));
                }
                // Simpan gambar baru
                $imageName = time() . '.' . $request->img->extension();
                $request->img->move(public_path('images/reseps'), $imageName);
                $inputResep['img'] = $imageName;
            }

            // Update data resep
            $resep->update($inputResep);

            // Update data nutrisi (atau buat baru jika belum ada)
            $inputNutrisi = $request->only(['kalori', 'protein', 'karbo', 'lemak']);
            $resep->nutrisi()->updateOrCreate(['id_resep' => $resep->id_resep], $inputNutrisi);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui resep: ' . $e->getMessage());
        }

        return redirect()->route('reseps.index')
                         ->with('success', 'Resep berhasil diperbarui.');
    }

    /**
     * Menghapus resep.
     */
    public function destroy(Resep $resep)
    {
        // Hapus gambar dari storage
        if ($resep->img && File::exists(public_path('images/reseps/' . $resep->img))) {
            File::delete(public_path('images/reseps/' . $resep->img));
        }

        // Hapus resep dari database
        // Data nutrisi akan otomatis terhapus karena onDelete('cascade') di migrasi
        $resep->delete();

        return redirect()->route('reseps.index')
                         ->with('success', 'Resep berhasil dihapus.');
    }


    public function autocomplete(Request $request)
    {
        $query = $request->input('term');

        // Inisialisasi array hasil dengan beberapa kategori
        $results = [
            'reseps' => [],
            'bahans' => [],
        ];

        if (strlen($query) < 2) {
            return response()->json($results);
        }

        // 1. Cari di Judul Resep (maksimal 4 hasil)
        $reseps = Resep::where('judul', 'LIKE', '%' . $query . '%')
                        ->take(4)
                        ->select('judul', 'slug', 'img') // Ambil juga gambar
                        ->get();

        // Tambahkan hasil pencarian resep ke array
        foreach ($reseps as $resep) {
            $results['reseps'][] = [
                'judul' => $resep->judul,
                'slug' => $resep->slug,
                'img' => $resep->img ? asset('images/reseps/' . $resep->img) : 'https://via.placeholder.com/40', // URL gambar
                'kategori' => 'Resep Makanan'
            ];
        }

        // 2. Cek apakah query cocok dengan salah satu bahan
        // Kita buat satu rekomendasi "Cari berdasarkan bahan" jika ada kecocokan
        $resepDenganBahan = Resep::where('bahan', 'LIKE', '%' . $query . '%')->exists();

        if ($resepDenganBahan) {
            $results['bahans'][] = [
                'nama' => 'Cari resep dengan bahan: ' . $query,
                'search_url' => route('reseps.index', ['search' => $query])
            ];
        }

        return response()->json($results);
    }

}
