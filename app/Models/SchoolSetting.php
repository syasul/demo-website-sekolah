<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_sekolah',
        'nsm',
        'npsn',
        'akreditasi',
        'alamat',
        'kota',
        'provinsi',
        'telepon',
        'email',
        'website',
        'nama_kepala_sekolah',
        'nip_kepala_sekolah',
        'tahun_ajaran_aktif',
        'semester_aktif',
        'logo_custom',
    ];

    /**
     * Singleton instance helper for current school settings.
     */
    public static function getActive(): self
    {
        return static::firstOrCreate([], [
            'nama_sekolah' => 'Madrasah Aliyah At-Taraqqie Malang',
            'nsm' => '131235730005',
            'npsn' => '20584478',
            'akreditasi' => 'A (Unggul)',
            'alamat' => 'Jl. Arjuno No. 34',
            'kota' => 'Malang',
            'provinsi' => 'Jawa Timur',
            'telepon' => '(0341) 362819',
            'email' => 'info@attaraqqie.sch.id',
            'website' => 'https://attaraqqie.sch.id',
            'nama_kepala_sekolah' => 'Drs. H. M. Zainul Arifin, M.Pd.I',
            'nip_kepala_sekolah' => '19710520 199703 1 003',
            'tahun_ajaran_aktif' => '2024/2025',
            'semester_aktif' => 'ganjil',
            'logo_custom' => null,
        ]);
    }
}
