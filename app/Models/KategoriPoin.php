<?php

namespace App\Models;

use App\Models\Traits\BelongsToUnit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriPoin extends Model
{
    use HasFactory, BelongsToUnit;

    protected $fillable = [
        'nama',
        'tipe', // 'pelanggaran', 'prestasi'
        'bobot',
        'unit_id',
    ];

    public function poinSiswas(): HasMany
    {
        return $this->hasMany(PoinSiswa::class, 'kategori_id');
    }
}
