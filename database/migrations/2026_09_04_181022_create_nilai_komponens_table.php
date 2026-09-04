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
        Schema::create('nilai_komponens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete();
            $table->foreignId('mapel_id')->constrained('mata_pelajarans')->cascadeOnDelete();
            $table->foreignId('guru_id')->constrained('users')->cascadeOnDelete();
            $table->enum('semester', ['ganjil', 'genap'])->default('ganjil');
            $table->string('tahun_ajaran', 20)->default('2025/2026');
            $table->enum('jenis', ['tugas', 'uh', 'uts', 'uas', 'remidi']);
            $table->string('judul')->nullable(); // Misal: "Tugas 1", "UH Bab 2", nullable untuk UTS/UAS
            $table->decimal('nilai', 5, 2);
            $table->date('tanggal')->nullable();
            $table->foreignId('komponen_asal_id')->nullable()->constrained('nilai_komponens')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_komponens');
    }
};
