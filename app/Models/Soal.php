<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_soal';

    // Menonaktifkan timestamp karena tidak ada di tabel
    public $timestamps = false;

    protected $fillable = [
        'id_materi',
        'pertanyaan',
        'img',
        'opsi',
        'jawaban',
    ];

    // Cast kolom 'opsi' dari JSON ke array secara otomatis
    protected $casts = [
        'opsi' => 'array',
    ];

    /**
     * Relasi: Satu Soal milik satu Materi.
     */
    public function materi()
    {
        return $this->belongsTo(Materi::class, 'id_materi', 'id_materi');
    }
}
