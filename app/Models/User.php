<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'admin_level', 'kelas_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user is Admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isAdminGlobal(): bool
    {
        return $this->role === 'admin' && ($this->admin_level === 'global' || empty($this->admin_level));
    }

    public function isAdminPutra(): bool
    {
        return $this->role === 'admin' && $this->admin_level === 'putra';
    }

    public function isAdminPutri(): bool
    {
        return $this->role === 'admin' && $this->admin_level === 'putri';
    }

    /**
     * Check if user is Guru
     */
    public function isGuru(): bool
    {
        return $this->role === 'guru';
    }

    /**
     * Check if user is Siswa
     */
    public function isSiswa(): bool
    {
        return $this->role === 'siswa';
    }

    /**
     * Check if user is Orang Tua
     */
    public function isOrangTua(): bool
    {
        return $this->role === 'orang_tua';
    }

    /**
     * Get children linked to this parent (Orang Tua).
     */
    public function anaks(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'orang_tua_siswa', 'orang_tua_id', 'siswa_id');
    }

    /**
     * Get parents linked to this student.
     */
    public function orangTuas(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'orang_tua_siswa', 'siswa_id', 'orang_tua_id');
    }

    /**
     * Get units where this teacher is assigned.
     */
    public function units(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Unit::class, 'guru_unit', 'guru_id', 'unit_id');
    }

    /**
     * In-app notifications.
     */
    public function notifikasis(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Notifikasi::class, 'user_id');
    }

    public function unreadNotifikasisCount(): int
    {
        return $this->notifikasis()->whereNull('dibaca_at')->count();
    }

    /**
     * Get the class of the student.
     */
    public function kelas(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    /**
     * Get the subject assignments for the teacher.
     */
    public function guruMapels(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(GuruMapel::class, 'guru_id');
    }

    /**
     * Get the class where this user is wali kelas.
     */
    public function kelasWali(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Kelas::class, 'wali_kelas_id');
    }

    /**
     * Get grades for this student.
     */
    public function nilais(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Nilai::class, 'siswa_id');
    }

    /**
     * Get daily grade components for this student.
     */
    public function nilaiKomponens(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(NilaiKomponen::class, 'siswa_id');
    }

    /**
     * Get the student detailed profile.
     */
    public function siswa(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Siswa::class, 'user_id');
    }

    /**
     * Get NISN (formatted student registration number).
     */
    public function getNisnAttribute(): string
    {
        if ($this->relationLoaded('siswa') && $this->siswa && $this->siswa->nisn) {
            return $this->siswa->nisn;
        }

        return sprintf('2024%04d', $this->id);
    }
}
