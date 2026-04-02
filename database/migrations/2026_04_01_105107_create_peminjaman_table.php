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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_alat')->constrained('alat')->onDelete('cascade');
            $table->string('nama_peminjam');
            $table->date('tgl_pinjam');
            $table->date('tgl_kembali');
            $table->enum('kondisi', ['baik', 'rusak'])->default('baik');
            $table->enum('status', ['belum kembali', 'selesai'])->default('belum kembali');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
