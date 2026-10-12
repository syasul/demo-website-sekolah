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
        Schema::table('users', function (Blueprint $table) {
            $table->string('admin_level', 20)->nullable()->after('role'); // 'global', 'putra', 'putri'
        });

        Schema::table('kelas', function (Blueprint $table) {
            $table->foreignId('unit_id')->nullable()->after('wali_kelas_id')->constrained('units')->nullOnDelete();
        });

        Schema::table('siswas', function (Blueprint $table) {
            $table->foreignId('unit_id')->nullable()->after('kelas_id')->constrained('units')->nullOnDelete();
        });

        Schema::table('pendaftars', function (Blueprint $table) {
            $table->foreignId('jenjang_id')->nullable()->after('asal_sekolah')->constrained('jenjangs')->nullOnDelete();
            $table->foreignId('unit_id')->nullable()->after('jenjang_id')->constrained('units')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftars', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
            $table->dropForeign(['jenjang_id']);
            $table->dropColumn(['jenjang_id', 'unit_id']);
        });

        Schema::table('siswas', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
            $table->dropColumn(['unit_id']);
        });

        Schema::table('kelas', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
            $table->dropColumn(['unit_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['admin_level']);
        });
    }
};
