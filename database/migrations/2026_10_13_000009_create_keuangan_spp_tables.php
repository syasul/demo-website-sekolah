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
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->string('periode', 50); // e.g. "Oktober 2026"
            $table->decimal('nominal', 12, 2)->default(350000);
            $table->date('jatuh_tempo');
            $table->enum('status', ['belum', 'sebagian', 'lunas'])->default('belum');
            $table->timestamps();
        });

        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tagihan_id')->constrained('tagihans')->cascadeOnDelete();
            $table->date('tanggal');
            $table->decimal('nominal', 12, 2);
            $table->string('metode', 50)->default('Tunai / Kasir TU');
            $table->text('catatan')->nullable();
            $table->foreignId('penerima_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
        Schema::dropIfExists('tagihans');
    }
};
