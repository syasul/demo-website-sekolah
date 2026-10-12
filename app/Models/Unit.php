<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenjang_id',
        'gender', // 'putra', 'putri'
        'nama',   // e.g. 'MA Putra', 'MA Putri'
        'deskripsi',
    ];

    /**
     * Get the educational stage.
     */
    public function jenjang(): BelongsTo
    {
        return $this->belongsTo(Jenjang::class, 'jenjang_id');
    }

    /**
     * Get classes in this unit.
     */
    public function kelas(): HasMany
    {
        return $this->hasMany(Kelas::class, 'unit_id');
    }

    /**
     * Get students in this unit.
     */
    public function siswas(): HasMany
    {
        return $this->hasMany(Siswa::class, 'unit_id');
    }

    /**
     * Get teachers teaching in this unit.
     */
    public function gurus(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'guru_unit', 'unit_id', 'guru_id');
    }

    /**
     * Get gender badge color styling.
     */
    public function getBadgeColorAttribute(): string
    {
        return $this->gender === 'putra' 
            ? 'bg-blue-100 text-blue-700 border-blue-200' 
            : 'bg-purple-100 text-purple-700 border-purple-200';
    }
}
