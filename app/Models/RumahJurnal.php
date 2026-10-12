<?php

namespace App\Models;

use App\Models\Traits\BelongsToUnit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RumahJurnal extends Model
{
    use HasFactory, BelongsToUnit;

    protected $fillable = [
        'judul',
        'penulis',
        'guru_id',
        'unit_id',
        'kategori',
        'abstrak',
        'file_path',
        'tahun',
        'status', // pending, approved, rejected
    ];

    public function guru(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
}
