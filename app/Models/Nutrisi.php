<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nutrisi extends Model
{
    use HasFactory;

    /**
     * Menentukan primary key tabel karena bukan 'id'.
     *
     * @var string
     */
    protected $primaryKey = 'id_nutrisi';

    /**
     * Kolom-kolom yang boleh diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_resep',
        'kalori',
        'protein',
        'karbo',
        'lemak',
    ];

    /**
     * Mendefinisikan relasi "belongsTo" ke model Resep.
     * Artinya, satu data Nutrisi dimiliki oleh satu Resep.
     */
    public function resep()
    {
        // Parameter kedua ('id_resep') adalah foreign key di tabel nutrisis.
        // Parameter ketiga ('id_resep') adalah primary key di tabel reseps.
        return $this->belongsTo(Resep::class, 'id_resep', 'id_resep');
    }
}
