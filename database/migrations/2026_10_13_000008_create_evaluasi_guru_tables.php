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
        Schema::create('instrumen_penilaians', function (Blueprint $table) {
            $table->id();
            $table->enum('kompetensi', ['Pedagogik', 'Profesional', 'Kepribadian', 'Sosial']);
            $table->text('indikator');
            $table->integer('bobot')->default(25);
            $table->timestamps();
        });

        Schema::create('evaluasi_gurus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('penilai_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->string('periode_tahun', 20)->default('2024/2025');
            $table->enum('semester', ['ganjil', 'genap'])->default('ganjil');
            $table->decimal('skor_pedagogik', 5, 2)->default(85.00);
            $table->decimal('skor_profesional', 5, 2)->default(85.00);
            $table->decimal('skor_kepribadian', 5, 2)->default(90.00);
            $table->decimal('skor_sosial', 5, 2)->default(88.00);
            $table->decimal('skor_total', 5, 2)->default(87.00);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluasi_gurus');
        Schema::dropIfExists('instrumen_penilaians');
    }
};
