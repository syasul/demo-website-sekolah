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
        Schema::create('kategori_poins', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 150);
            $table->enum('tipe', ['pelanggaran', 'prestasi']);
            $table->integer('bobot')->default(5);
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('poin_siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('kategori_id')->constrained('kategori_poins')->cascadeOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->integer('poin'); // minus for pelanggaran, plus for prestasi
            $table->date('tanggal');
            $table->text('catatan')->nullable();
            $table->foreignId('pencatat_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('poin_gurus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('users')->cascadeOnDelete();
            $table->enum('jenis', ['prestasi', 'pelanggaran'])->default('prestasi');
            $table->string('judul', 150);
            $table->integer('poin')->default(10);
            $table->date('tanggal');
            $table->text('catatan')->nullable();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poin_gurus');
        Schema::dropIfExists('poin_siswas');
        Schema::dropIfExists('kategori_poins');
    }
};
