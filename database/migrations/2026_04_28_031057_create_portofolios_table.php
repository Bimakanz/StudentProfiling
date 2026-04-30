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
        Schema::create('portofolios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ID pemilik (ForeignID)
            $table->string('judul');                                           // Nama proyek (String)
            $table->text('deskripsi');                                         // Penjelasan mendalam mengenai karya (Text)
            $table->string('link_github')->nullable();                         // Link repositori kode (String, Nullable)
            $table->string('thumbnail')->nullable();                           // Link gambar sampul (String, Nullable)
            $table->string('kategori');                                        // Bidang porto (misal: Web, Mobile, IoT) (String)
            $table->enum('nilai', ['A', 'B', 'C', 'D']);                       // Kualitas karya (Enum: A, B, C, D)
            $table->string('jenis_porto');                                     // Tugas Sekolah, Project Mandiri, atau Freelance (String)
            $table->string('tools');                                           // Alat yang digunakan (misal: VS Code, Figma, Postman) (String)
            $table->string('teknologi');                                       // Bahasa/Framework (misal: PHP, React, Tailwind) (String)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portofolios');
    }
};
