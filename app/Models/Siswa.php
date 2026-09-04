<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'kelas_id',
        'nis',
        'nisn',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'nama_orang_tua',
        'no_hp_orang_tua',
        'foto',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
        ];
    }

    /**
     * Get the user account for this student.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the class of the student.
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    /**
     * Get grades for this student (via user_id).
     */
    public function nilais(): HasMany
    {
        return $this->hasMany(Nilai::class, 'siswa_id', 'user_id');
    }

    /**
     * Get daily grade components for this student (via user_id).
     */
    public function nilaiKomponens(): HasMany
    {
        return $this->hasMany(NilaiKomponen::class, 'siswa_id', 'user_id');
    }

    /**
     * Get student full name helper.
     */
    public function getNamaLengkapAttribute(): string
    {
        return $this->user ? $this->user->name : 'Tanpa Nama';
    }

    /**
     * Get formatted gender label.
     */
    public function getJenisKelaminLabelAttribute(): string
    {
        return $this->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
    }
}
