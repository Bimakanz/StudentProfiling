<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sertifikasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('nama_sertifikat');
            $table->string('lembaga_penerbit');
            $table->date('tanggal_terbit');
            $table->string('nomor_sertifikat')->unique();
            $table->string('file_sertifikat')->nullable();
            $table->text('deskripsi');
            $table->string('tools');
            $table->string('kategori'); // Nasional, Internasional, BNSP
            $table->string('jurusan'); // Relevansi jurusan RPL, TKJ dll
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sertifikasis');
    }
};
