<?php

namespace App\Models;

use App\Models\Traits\BelongsToUnit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PoinGuru extends Model
{
    use HasFactory, BelongsToUnit;

    protected $fillable = [
        'guru_id',
        'jenis', // 'prestasi', 'pelanggaran'
        'judul',
        'poin',
        'tanggal',
        'catatan',
        'unit_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'poin' => 'integer',
    ];

    public function guru(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
}
