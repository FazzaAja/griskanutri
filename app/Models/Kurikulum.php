<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurikulum extends Model
{
    use HasFactory;

    // Menentukan nama primary key
    protected $primaryKey = 'id_kurikulum';

    // Menggunakan nama timestamp kustom
    const CREATED_AT = 'upload_at';
    const UPDATED_AT = 'update_at';

    // Kolom yang boleh diisi massal
    protected $fillable = [
        'nama',
        'keterangan',
        'file',
        'img',
    ];

    /**
     * Relasi: Satu Kurikulum memiliki banyak Materi.
     */
    public function materis()
    {
        return $this->hasMany(Materi::class, 'id_kurikulum', 'id_kurikulum');
    }
}
