<?php

namespace App\Models;

use App\Models\Traits\BelongsToUnit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RdmSyncLog extends Model
{
    use HasFactory, BelongsToUnit;

    protected $fillable = [
        'waktu',
        'kelas_id',
        'unit_id',
        'jumlah_data',
        'status', // sukses, sebagian, gagal
        'pesan',
    ];

    protected $casts = [
        'waktu' => 'datetime',
        'jumlah_data' => 'integer',
    ];

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}
