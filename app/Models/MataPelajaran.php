<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_mapel',
        'kode_mapel',
        'tingkat',
        'kkm',
    ];

    /**
     * Get the teacher and class assignments for this subject.
     */
    public function guruMapels(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(GuruMapel::class, 'mapel_id');
    }
}
