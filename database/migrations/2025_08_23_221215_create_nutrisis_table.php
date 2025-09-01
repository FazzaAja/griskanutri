<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nutrisis', function (Blueprint $table) {
            $table->bigIncrements('id_nutrisi'); // Primary key kustom

            // Foreign key ke tabel reseps
            $table->unsignedBigInteger('id_resep')->unique(); // unique() untuk relasi one-to-one
            $table->foreign('id_resep')
                  ->references('id_resep')
                  ->on('reseps')
                  ->onDelete('cascade'); // Jika resep dihapus, nutrisi ikut terhapus

            $table->decimal('kalori', 10, 2)->default(0);
            $table->decimal('protein', 10, 2)->default(0);
            $table->decimal('karbo', 10, 2)->default(0);
            $table->decimal('lemak', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nutrisis');
    }
};
