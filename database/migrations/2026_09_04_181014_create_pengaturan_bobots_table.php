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
        Schema::create('pengaturan_bobots', function (Blueprint $table) {
            $table->id();
            $table->string('jenis')->unique(); // 'tugas', 'uh', 'uts', 'uas'
            $table->integer('bobot_persen'); // 20, 30, 20, 30
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturan_bobots');
    }
};
