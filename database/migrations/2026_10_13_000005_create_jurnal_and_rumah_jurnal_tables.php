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
        Schema::create('jurnals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('jadwal_id')->nullable()->constrained('jadwals')->nullOnDelete();
            $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete();
            $table->foreignId('mapel_id')->constrained('mata_pelajarans')->cascadeOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->date('tanggal');
            $table->string('jam_ke', 20)->nullable();
            $table->text('materi');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        Schema::create('rumah_jurnals', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 255);
            $table->string('penulis', 150);
            $table->foreignId('guru_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->string('kategori', 100);
            $table->text('abstrak');
            $table->string('file_path')->nullable();
            $table->integer('tahun')->default(2026);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rumah_jurnals');
        Schema::dropIfExists('jurnals');
    }
};
