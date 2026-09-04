<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'tingkat',
        'nama_rombel',
        'wali_kelas_id',
    ];

    /**
     * Get the wali kelas associated with the class.
     */
    public function waliKelas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'wali_kelas_id');
    }

    /**
     * Get the teachers and subjects assigned to this class.
     */
    public function guruMapels(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(GuruMapel::class, 'kelas_id');
    }

    /**
     * Get the students in this class.
     */
    public function siswas(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class, 'kelas_id')->where('role', 'siswa');
    }

    /**
     * Get the student profiles in this class.
     */
    public function siswaProfiles(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Siswa::class, 'kelas_id');
    }

    /**
     * Get the grades recorded for this class.
     */
    public function nilais(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Nilai::class, 'kelas_id');
    }

    /**
     * Get the class full name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function namaLengkap(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $attributes['tingkat'] . ' ' . $attributes['nama_rombel'],
        );
    }
}
