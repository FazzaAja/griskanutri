<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reseps', function (Blueprint $table) {
            $table->bigIncrements('id_resep'); // Primary key kustom
            $table->string('judul');
            $table->longText('deskripsi');
            $table->string('img')->nullable();
            $table->json('bahan');
            $table->json('alat');
            $table->json('langkah');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reseps');
    }
};
