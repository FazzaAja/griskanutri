<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Import class Str

class Materi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_materi';

    // Nonaktifkan timestamp default karena kita pakai nama kustom
    const CREATED_AT = 'upload_at';
    const UPDATED_AT = 'update_at';

    // Tambahkan 'slug' ke dalam $fillable
    protected $fillable = [
        'id_kurikulum',
        'urutan', // <-- TAMBAHKAN INI
        'judul',
        'slug', // <-- TAMBAHKAN INI
        'keterangan',
        'rangkuman',
        'file',
        'youtube',
    ];

    /**
     * Memberitahu Laravel untuk menggunakan 'slug' sebagai kunci rute.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Method ini akan berjalan secara otomatis saat model dibuat/disimpan.
     * Kita gunakan untuk membuat slug secara otomatis.
     */
    protected static function booted()
    {
        static::creating(function ($materi) {
            $materi->slug = self::createUniqueSlug($materi->judul);
        });

        static::updating(function ($materi) {
            // Buat ulang slug hanya jika judulnya berubah
            if ($materi->isDirty('judul')) {
                $materi->slug = self::createUniqueSlug($materi->judul, $materi->id_materi);
            }
        });
    }

    /**
     * Helper function untuk membuat slug yang unik.
     * Mencegah error jika ada dua materi dengan judul yang sama.
     */
    private static function createUniqueSlug($title, $id = 0)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        // Loop selama slug sudah ada di database (dan bukan milik record yang sedang di-update)
        while (static::where('slug', $slug)->where('id_materi', '!=', $id)->first()) {
            $slug = "{$originalSlug}-" . $count++;
        }

        return $slug;
    }

    // Relasi (biarkan seperti sebelumnya)
    public function kurikulum()
    {
        return $this->belongsTo(Kurikulum::class, 'id_kurikulum', 'id_kurikulum');
    }

    public function soals()
    {
        return $this->hasMany(Soal::class, 'id_materi', 'id_materi');
    }
}
