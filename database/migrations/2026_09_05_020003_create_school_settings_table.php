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
        Schema::create('school_settings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sekolah')->default('Madrasah Aliyah At-Taraqqie Malang');
            $table->string('nsm', 30)->default('131235730005');
            $table->string('npsn', 30)->default('20584478');
            $table->string('akreditasi', 20)->default('A (Unggul)');
            $table->text('alamat')->default('Jl. Arjuno No. 34');
            $table->string('kota', 60)->default('Malang');
            $table->string('provinsi', 60)->default('Jawa Timur');
            $table->string('telepon', 30)->default('(0341) 362819');
            $table->string('email', 100)->default('info@attaraqqie.sch.id');
            $table->string('website', 120)->default('https://attaraqqie.sch.id');
            $table->string('nama_kepala_sekolah')->default('Drs. H. M. Zainul Arifin, M.Pd.I');
            $table->string('nip_kepala_sekolah', 40)->default('19710520 199703 1 003');
            $table->string('tahun_ajaran_aktif', 20)->default('2024/2025');
            $table->enum('semester_aktif', ['ganjil', 'genap'])->default('ganjil');
            $table->string('logo_custom')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_settings');
    }
};
