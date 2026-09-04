<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NilaiKomponen extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'kelas_id',
        'mapel_id',
        'guru_id',
        'semester',
        'tahun_ajaran',
        'jenis',
        'judul',
        'nilai',
        'tanggal',
        'komponen_asal_id',
    ];

    protected function casts(): array
    {
        return [
            'nilai' => 'float',
            'tanggal' => 'date',
        ];
    }

    /**
     * Get the student.
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    /**
     * Get the class.
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    /**
     * Get the subject.
     */
    public function mapel(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'mapel_id');
    }

    /**
     * Get the teacher.
     */
    public function guru(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    /**
     * Original component if this is a remedial entry.
     */
    public function komponenAsal(): BelongsTo
    {
        return $this->belongsTo(NilaiKomponen::class, 'komponen_asal_id');
    }

    /**
     * Remedial entries for this component.
     */
    public function remidis(): HasMany
    {
        return $this->hasMany(NilaiKomponen::class, 'komponen_asal_id');
    }
}
