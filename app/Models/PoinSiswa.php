<?php

namespace App\Models;

use App\Models\Traits\BelongsToUnit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PoinSiswa extends Model
{
    use HasFactory, BelongsToUnit;

    protected $fillable = [
        'siswa_id',
        'kategori_id',
        'unit_id',
        'poin',
        'tanggal',
        'catatan',
        'pencatat_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'poin' => 'integer',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    public function siswaProfile(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'user_id');
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriPoin::class, 'kategori_id');
    }

    public function pencatat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pencatat_id');
    }
}
