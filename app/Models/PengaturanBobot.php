<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaturanBobot extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis',
        'bobot_persen',
    ];

    /**
     * Get default weights.
     */
    public static function getBobotArray(): array
    {
        $defaults = [
            'tugas' => 20,
            'uh' => 30,
            'uts' => 20,
            'uas' => 30,
        ];

        try {
            $bobots = static::pluck('bobot_persen', 'jenis')->toArray();
            return array_merge($defaults, $bobots);
        } catch (\Throwable $e) {
            return $defaults;
        }
    }
}
