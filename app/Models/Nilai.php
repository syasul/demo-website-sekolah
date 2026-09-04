<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nilai extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'kelas_id',
        'mapel_id',
        'guru_id',
        'semester',
        'tahun_ajaran',
        'nilai_pengetahuan',
        'nilai_keterampilan',
        'nilai_sikap',
        'catatan',
        'status_remidi',
        'is_locked',
    ];

    protected function casts(): array
    {
        return [
            'nilai_pengetahuan' => 'float',
            'nilai_keterampilan' => 'float',
            'is_locked' => 'boolean',
        ];
    }

    /**
     * Get the student (siswa) associated with this grade.
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    /**
     * Get the class (kelas) associated with this grade.
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    /**
     * Get the subject (mata pelajaran) associated with this grade.
     */
    public function mapel(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'mapel_id');
    }

    /**
     * Get the teacher (guru) that input this grade.
     */
    public function guru(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    /**
     * Calculate the average grade (nilai akhir).
     */
    public function getNilaiAkhirAttribute(): ?float
    {
        if ($this->nilai_pengetahuan === null && $this->nilai_keterampilan === null) {
            return null;
        }

        $p = $this->nilai_pengetahuan ?? 0;
        $k = $this->nilai_keterampilan ?? 0;

        return round(($p + $k) / 2, 1);
    }

    /**
     * Get grade predicate (A, B, C, D).
     */
    public function getPredikatAttribute(): string
    {
        $akhir = $this->nilai_akhir;
        if ($akhir === null) return '-';
        if ($akhir >= 90) return 'A (Sangat Baik)';
        if ($akhir >= 80) return 'B (Baik)';
        if ($akhir >= 70) return 'C (Cukup)';
        return 'D (Kurang)';
    }
}
