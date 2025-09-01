<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Import class Str

class Resep extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_resep';

    // Tambahkan 'slug' ke dalam properti $fillable
    protected $fillable = [
        'judul',
        'slug', // <-- TAMBAHKAN INI
        'deskripsi',
        'img',
        'bahan',
        'alat',
        'langkah',
    ];

    protected $casts = [
        'bahan' => 'array',
        'alat' => 'array',
        'langkah' => 'array',
    ];

    /**
     * Memberitahu Laravel untuk menggunakan 'slug' sebagai kunci untuk URL.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Method ini berjalan otomatis saat model disimpan (dibuat atau diupdate)
     * untuk membuat slug dari judul.
     */
    protected static function booted()
    {
        static::creating(function ($resep) {
            $resep->slug = self::createUniqueSlug($resep->judul);
        });

        static::updating(function ($resep) {
            // Buat ulang slug hanya jika judulnya berubah
            if ($resep->isDirty('judul')) {
                $resep->slug = self::createUniqueSlug($resep->judul, $resep->id_resep);
            }
        });
    }

    /**
     * Fungsi bantuan untuk memastikan setiap slug unik.
     * Jika ada judul yang sama, slug akan ditambahkan akhiran angka (misal: nasi-goreng-2).
     */
    private static function createUniqueSlug($title, $id = 0)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (static::where('slug', $slug)->where('id_resep', '!=', $id)->first()) {
            $slug = "{$originalSlug}-" . $count++;
        }

        return $slug;
    }

    public function nutrisi()
    {
        return $this->hasOne(Nutrisi::class, 'id_resep', 'id_resep');
    }
}
