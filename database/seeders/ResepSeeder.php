<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Resep;

class ResepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama agar tidak duplikat saat seeder dijalankan ulang
        // Data nutrisi akan ikut terhapus karena relasi onDelete('cascade')
        Resep::query()->delete();

        // --- Resep 1: Nasi Goreng Spesial ---
        $resep1 = Resep::create([
            'judul' => 'Nasi Goreng Spesial Ayam',
            'deskripsi' => 'Nasi goreng klasik yang lezat dan mudah dibuat, disajikan dengan telur mata sapi dan ayam suwir.',
            'bahan' => [
                '2 piring nasi putih dingin',
                '100g daging ayam, suwir',
                '2 siung bawang putih, cincang',
                '1 sdm kecap manis',
                '1 butir telur',
                'Garam dan merica secukupnya'
            ],
            'alat' => [
                'Wajan',
                'Spatula',
                'Piring saji'
            ],
            'langkah' => [
                'Panaskan minyak di wajan, tumis bawang putih hingga harum.',
                'Masukkan ayam suwir dan telur, orak-arik hingga matang.',
                'Masukkan nasi, aduk rata.',
                'Tambahkan kecap manis, garam, dan merica. Aduk hingga semua bumbu merata.',
                'Sajikan selagi hangat.'
            ]
        ]);

        // Buat data nutrisi untuk resep1
        $resep1->nutrisi()->create([
            'kalori' => 450.50,
            'protein' => 25.5,
            'karbo' => 55.0,
            'lemak' => 15.8
        ]);


        // --- Resep 2: Soto Ayam Lamongan ---
        $resep2 = Resep::create([
            'judul' => 'Soto Ayam Lamongan Bening',
            'deskripsi' => 'Soto ayam dengan kuah bening yang kaya akan rempah, disajikan dengan koya yang gurih.',
            'bahan' => [
                '1/2 ekor ayam kampung',
                '2 liter air',
                '3 lembar daun salam',
                '2 batang serai, memarkan',
                'Suun, tauge, dan seledri secukupnya',
                'Bubuk koya'
            ],
            'alat' => [
                'Panci besar',
                'Mangkuk saji'
            ],
            'langkah' => [
                'Rebus ayam bersama daun salam dan serai hingga empuk.',
                'Angkat ayam, suwir-suwir dagingnya.',
                'Saring kaldu rebusan ayam.',
                'Tata suun, tauge, dan ayam suwir di mangkuk.',
                'Siram dengan kuah kaldu panas dan taburi dengan koya dan seledri.'
            ]
        ]);

        // Buat data nutrisi untuk resep2
        $resep2->nutrisi()->create([
            'kalori' => 350.00,
            'protein' => 30.2,
            'karbo' => 20.5,
            'lemak' => 18.0
        ]);


        // --- Resep 3: Rendang Daging Sapi ---
        $resep3 = Resep::create([
            'judul' => 'Rendang Daging Sapi Khas Padang',
            'deskripsi' => 'Rendang daging sapi yang dimasak perlahan dengan bumbu rempah melimpah hingga kering dan mengeluarkan minyak.',
             'bahan' => [
                '500g daging sapi rendang',
                '500ml santan kental',
                'Bumbu halus (bawang, cabai, jahe, lengkuas)',
                'Daun kunyit dan daun jeruk'
            ],
            'alat' => [
                'Wajan besar',
                'Spatula kayu'
            ],
            'langkah' => [
                'Tumis bumbu halus hingga harum.',
                'Masukkan daging sapi, aduk hingga berubah warna.',
                'Tuang santan dan masukkan daun-daunan.',
                'Masak dengan api kecil sambil terus diaduk hingga santan mengering dan bumbu meresap.',
                'Sajikan dengan nasi hangat.'
            ]
        ]);

        // Buat data nutrisi untuk resep3
        $resep3->nutrisi()->create([
            'kalori' => 480.75,
            'protein' => 35.5,
            'karbo' => 10.2,
            'lemak' => 32.5
        ]);
    }
}
