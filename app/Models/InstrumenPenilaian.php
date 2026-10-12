<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstrumenPenilaian extends Model
{
    use HasFactory;

    protected $fillable = [
        'kompetensi', // Pedagogik, Profesional, Kepribadian, Sosial
        'indikator',
        'bobot',
    ];
}
