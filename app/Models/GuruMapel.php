<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GuruMapel extends Model
{
    use HasFactory;

    protected $table = 'guru_kelas_mapel';

    protected $fillable = [
        'guru_id',
        'kelas_id',
        'mapel_id',
    ];

    /**
     * Get the teacher (guru) that owns this assignment.
     */
    public function guru(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    /**
     * Get the class (kelas) associated with this assignment.
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    /**
     * Get the subject (mata pelajaran) associated with this assignment.
     */
    public function mapel(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'mapel_id');
    }
}
