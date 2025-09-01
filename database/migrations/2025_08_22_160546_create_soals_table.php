<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('soals', function (Blueprint $table) {
            $table->bigIncrements('id_soal');

            // Foreign key ke tabel materis
            $table->unsignedBigInteger('id_materi');
            $table->foreign('id_materi')->references('id_materi')->on('materis')->onDelete('cascade');

            $table->text('pertanyaan');
            $table->string('img')->nullable();
            // Tipe data 'opsi' lebih cocok JSON atau text
            $table->json('opsi')->nullable();
            $table->string('jawaban');
            // Diagram tidak memiliki timestamp, jadi kita tidak menambahkannya
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('soals');
    }
};
