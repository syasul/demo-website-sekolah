<?php

namespace App\Models;

use App\Models\Traits\BelongsToUnit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EvaluasiGuru extends Model
{
    use HasFactory, BelongsToUnit;

    protected $table = 'evaluasi_gurus';

    protected $fillable = [
        'guru_id',
        'penilai_id',
        'unit_id',
        'periode_tahun',
        'semester',
        'skor_pedagogik',
        'skor_profesional',
        'skor_kepribadian',
        'skor_sosial',
        'skor_total',
        'catatan',
    ];

    protected $casts = [
        'skor_pedagogik' => 'float',
        'skor_profesional' => 'float',
        'skor_kepribadian' => 'float',
        'skor_sosial' => 'float',
        'skor_total' => 'float',
    ];

    public function guru(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function penilai(): BelongsTo
    {
        return $this->belongsTo(User::class, 'penilai_id');
    }

    public function getPredikatAttribute(): string
    {
        if ($this->skor_total >= 90) return 'Amat Baik (A)';
        if ($this->skor_total >= 80) return 'Baik (B)';
        if ($this->skor_total >= 70) return 'Cukup (C)';
        return 'Kurang (D)';
    }
}
