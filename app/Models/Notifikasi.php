<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notifikasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tipe', // absen, poin, spp, umum
        'judul',
        'isi',
        'link',
        'dibaca_at',
    ];

    protected $casts = [
        'dibaca_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getIsReadAttribute(): bool
    {
        return $this->dibaca_at !== null;
    }

    public function getIconAttribute(): string
    {
        return match($this->tipe) {
            'absen' => 'fa-clipboard-user text-amber-500',
            'poin' => 'fa-shield-halved text-rose-500',
            'spp' => 'fa-credit-card text-emerald-500',
            default => 'fa-bell text-blue-500',
        };
    }
}
