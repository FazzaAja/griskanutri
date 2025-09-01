<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kurikulum;
use App\Models\Materi;
use Illuminate\Support\Str;

class StuntingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama jika ada untuk menghindari duplikat
        Kurikulum::query()->delete();

        // == KURIKULUM 1: PENCEGAHAN STUNTING ==
        $kurikulum1 = Kurikulum::create([
            'nama' => 'Panduan Lengkap Pencegahan Stunting',
            'keterangan' => 'Kurikulum ini membahas semua aspek penting dalam mencegah stunting sejak dini, mulai dari gizi ibu hamil hingga pola asuh anak.',
        ]);

        // -- Materi untuk Kurikulum 1 --
        $materi1_1 = $kurikulum1->materis()->create([
            'judul' => 'Pentingnya Gizi 1000 Hari Pertama Kehidupan',
            'slug' => Str::slug('Pentingnya Gizi 1000 Hari Pertama Kehidupan'),
            'keterangan' => 'Memahami mengapa 1000 HPK adalah periode emas untuk pertumbuhan otak dan fisik anak.',
            'rangkuman' => 'Periode 1000 Hari Pertama Kehidupan (HPK) adalah jendela kritis yang dimulai sejak anak dalam kandungan hingga ulang tahun kedua. Gizi yang optimal pada periode ini sangat menentukan perkembangan jangka panjang anak dan merupakan kunci utama pencegahan stunting.',
            'urutan' => 1,
        ]);

        // Soal untuk Materi 1.1
        $this->createSoalUntukMateri($materi1_1, [
            [
                'pertanyaan' => 'Apa yang dimaksud dengan 1000 Hari Pertama Kehidupan (HPK)?',
                'opsi' => ['A' => 'Sejak lahir hingga usia 1000 hari', 'B' => 'Sejak dalam kandungan hingga anak berusia 2 tahun', 'C' => 'Sejak lahir hingga anak berusia 3 tahun', 'D' => 'Masa sekolah dasar anak'],
                'jawaban' => 'B',
            ],
            [
                'pertanyaan' => 'Mengapa periode 1000 HPK disebut sebagai "periode emas"?',
                'opsi' => ['A' => 'Karena biaya perawatannya mahal', 'B' => 'Karena sangat menentukan perkembangan otak dan fisik', 'C' => 'Karena anak mendapatkan banyak hadiah', 'D' => 'Karena anak mulai belajar berbicara'],
                'jawaban' => 'B',
            ],
            [
                'pertanyaan' => 'Kekurangan gizi pada masa 1000 HPK dapat menyebabkan kondisi apa?',
                'opsi' => ['A' => 'Anak menjadi hiperaktif', 'B' => 'Stunting atau gagal tumbuh', 'C' => 'Anak cepat merasa bosan', 'D' => 'Anak memiliki bakat seni'],
                'jawaban' => 'B',
            ],
            [
                'pertanyaan' => 'Kapan periode 1000 HPK dimulai?',
                'opsi' => ['A' => 'Saat bayi lahir', 'B' => 'Saat ibu mulai menyusui', 'C' => 'Sejak awal kehamilan', 'D' => 'Saat anak mulai MPASI'],
                'jawaban' => 'C',
            ],
            [
                'pertanyaan' => 'Apa fokus utama intervensi gizi pada 1000 HPK?',
                'opsi' => ['A' => 'Memberi makanan manis', 'B' => 'Memastikan anak kenyang', 'C' => 'Pemberian gizi seimbang dan cukup', 'D' => 'Mengurangi jam tidur anak'],
                'jawaban' => 'C',
            ],
        ]);

        $materi1_2 = $kurikulum1->materis()->create([
            'judul' => 'Peran Protein Hewani dalam Mencegah Stunting',
            'slug' => Str::slug('Peran Protein Hewani dalam Mencegah Stunting'),
            'keterangan' => 'Mengenal sumber protein hewani dan manfaatnya untuk tumbuh kembang anak.',
            'rangkuman' => 'Protein hewani seperti telur, ikan, daging, dan susu mengandung asam amino esensial yang lengkap. Kandungan ini sangat mudah diserap tubuh dan berperan penting dalam pembentukan sel-sel baru, termasuk sel otak, sehingga sangat efektif untuk mencegah stunting.',
            'urutan' => 2,
        ]);

        // Soal untuk Materi 1.2
        $this->createSoalUntukMateri($materi1_2, [
            [
                'pertanyaan' => 'Manakah di bawah ini yang termasuk sumber protein hewani?',
                'opsi' => ['A' => 'Tahu dan tempe', 'B' => 'Kacang-kacangan', 'C' => 'Telur dan ikan', 'D' => 'Sayur bayam'],
                'jawaban' => 'C',
            ],
            [
                'pertanyaan' => 'Apa keunggulan utama protein hewani dibandingkan protein nabati?',
                'opsi' => ['A' => 'Lebih murah harganya', 'B' => 'Mengandung asam amino esensial yang lebih lengkap', 'C' => 'Lebih mudah ditemukan', 'D' => 'Memiliki rasa yang lebih manis'],
                'jawaban' => 'B',
            ],
            [
                'pertanyaan' => 'Zat gizi apa yang terkandung dalam protein hewani dan penting untuk perkembangan otak?',
                'opsi' => ['A' => 'Vitamin C', 'B' => 'Serat', 'C' => 'Asam Amino Esensial', 'D' => 'Karbohidrat'],
                'jawaban' => 'C',
            ],
            [
                'pertanyaan' => 'Pemberian MPASI yang kaya protein hewani direkomendasikan mulai usia berapa?',
                'opsi' => ['A' => '4 bulan', 'B' => '6 bulan', 'C' => '1 tahun', 'D' => '2 tahun'],
                'jawaban' => 'B',
            ],
            [
                'pertanyaan' => 'Selain pertumbuhan fisik, apa manfaat lain dari konsumsi protein hewani yang cukup?',
                'opsi' => ['A' => 'Meningkatkan nafsu makan', 'B' => 'Meningkatkan daya tahan tubuh', 'C' => 'Membuat anak lebih pendiam', 'D' => 'Mengurangi kebutuhan tidur'],
                'jawaban' => 'B',
            ],
        ]);

        // == KURIKULUM 2: MENGENAL DAN MENDETEKSI STUNTING ==
        $kurikulum2 = Kurikulum::create([
            'nama' => 'Mengenal dan Mendeteksi Gejala Stunting',
            'keterangan' => 'Kurikulum untuk kader posyandu dan orang tua dalam mengenali tanda-tanda stunting dan cara melakukan deteksi dini.',
        ]);

        $materi2_1 = $kurikulum2->materis()->create([
            'judul' => 'Apa Itu Stunting?',
            'slug' => Str::slug('Apa Itu Stunting?'),
            'keterangan' => 'Definisi dan ciri-ciri utama anak yang mengalami stunting.',
            'rangkuman' => 'Stunting adalah kondisi gagal tumbuh pada anak balita akibat kekurangan gizi kronis, terutama pada 1000 Hari Pertama Kehidupan. Ciri utamanya adalah perawakan anak yang lebih pendek dari standar usianya. Ini bukan masalah genetik pendek, melainkan indikator masalah gizi.',
            'urutan' => 1,
        ]);

        // Soal untuk Materi 2.1
        $this->createSoalUntukMateri($materi2_1, [
            [
                'pertanyaan' => 'Apa definisi stunting yang paling tepat?',
                'opsi' => ['A' => 'Anak yang kurus', 'B' => 'Anak yang pendek karena keturunan', 'C' => 'Kondisi gagal tumbuh akibat kekurangan gizi kronis', 'D' => 'Anak yang tidak suka makan'],
                'jawaban' => 'C',
            ],
            [
                'pertanyaan' => 'Bagaimana cara utama mengukur atau mendeteksi stunting pada anak?',
                'opsi' => ['A' => 'Menimbang berat badannya', 'B' => 'Mengukur tinggi atau panjang badannya dan membandingkan dengan standar usia', 'C' => 'Melihat lingkar lengannya', 'D' => 'Melihat nafsu makannya'],
                'jawaban' => 'B',
            ],
            [
                'pertanyaan' => 'Stunting paling sering disebabkan oleh kekurangan gizi yang terjadi pada periode...',
                'opsi' => ['A' => 'Saat remaja', 'B' => 'Masa sekolah', 'C' => '1000 Hari Pertama Kehidupan', 'D' => 'Saat dewasa'],
                'jawaban' => 'C',
            ],
            [
                'pertanyaan' => 'Apakah anak yang pendek sudah pasti stunting?',
                'opsi' => ['A' => 'Ya, sudah pasti', 'B' => 'Tidak, perlu dibandingkan dengan standar pertumbuhan WHO', 'C' => 'Ya, jika orang tuanya juga pendek', 'D' => 'Tidak, jika anak tersebut aktif'],
                'jawaban' => 'B',
            ],
            [
                'pertanyaan' => 'Dampak jangka panjang dari stunting adalah...',
                'opsi' => ['A' => 'Hanya berpengaruh pada tinggi badan', 'B' => 'Anak menjadi atlet', 'C' => 'Penurunan kecerdasan dan rentan terhadap penyakit', 'D' => 'Anak menjadi lebih kreatif'],
                'jawaban' => 'C',
            ],
        ]);
    }

    /**
     * Helper function untuk membuat soal pada materi yang spesifik.
     */
    private function createSoalUntukMateri(Materi $materi, array $soals)
    {
        foreach ($soals as $soal) {
            $materi->soals()->create($soal);
        }
    }
}
