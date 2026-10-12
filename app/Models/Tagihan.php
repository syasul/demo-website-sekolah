<?php

namespace App\Models;

use App\Models\Traits\BelongsToUnit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tagihan extends Model
{
    use HasFactory, BelongsToUnit;

    protected $fillable = [
        'siswa_id',
        'unit_id',
        'periode',
        'nominal',
        'jatuh_tempo',
        'status', // belum, sebagian, lunas
    ];

    protected $casts = [
        'jatuh_tempo' => 'date',
        'nominal' => 'float',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    public function siswaProfile(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'user_id');
    }

    public function pembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran::class, 'tagihan_id');
    }

    public function getTotalDibayarAttribute(): float
    {
        return (float) $this->pembayarans->sum('nominal');
    }

    public function getSisaTagihanAttribute(): float
    {
        return max(0, $this->nominal - $this->total_dibayar);
    }
}
