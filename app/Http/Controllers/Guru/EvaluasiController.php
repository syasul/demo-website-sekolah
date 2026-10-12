<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\EvaluasiGuru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluasiController extends Controller
{
    /**
     * Tampilkan hasil evaluasi kinerja diri sendiri bagi guru.
     */
    public function index()
    {
        $guru = Auth::user();

        $evaluasis = EvaluasiGuru::with('penilai')
            ->where('guru_id', $guru->id)
            ->latest('periode_tahun')
            ->get();

        $latestEvaluasi = $evaluasis->first();

        return view('guru.evaluasi.index', compact('guru', 'evaluasis', 'latestEvaluasi'));
    }
}
