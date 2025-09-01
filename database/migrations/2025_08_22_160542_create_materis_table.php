<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materis', function (Blueprint $table) {
            $table->bigIncrements('id_materi');

            // Foreign key ke tabel kurikulums
            $table->unsignedBigInteger('id_kurikulum');
            $table->foreign('id_kurikulum')->references('id_kurikulum')->on('kurikulums')->onDelete('cascade');

            $table->string('judul');
            $table->text('keterangan')->nullable();
            $table->text('rangkuman')->nullable();
            $table->string('file')->nullable();
            $table->string('youtube')->nullable();
            $table->timestamp('upload_at')->nullable()->useCurrent();
            $table->timestamp('update_at')->nullable()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materis');
    }
};
