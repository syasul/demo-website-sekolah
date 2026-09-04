<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Display a listing of classes assigned to the logged-in teacher.
     */
    public function index()
    {
        /** @var User $guru */
        $guru = auth()->user();

        // Get IDs of classes taught by this teacher
        $taughtKelasIds = $guru->guruMapels->pluck('kelas_id')->toArray();
        if ($guru->kelasWali) {
            $taughtKelasIds[] = $guru->kelasWali->id;
        }
        $taughtKelasIds = array_unique($taughtKelasIds);

        $kelases = Kelas::whereIn('id', $taughtKelasIds)
            ->with(['waliKelas', 'siswas', 'guruMapels' => function ($q) use ($guru) {
                $q->where('guru_id', $guru->id)->with('mapel');
            }])
            ->orderBy('tingkat')
            ->orderBy('nama_rombel')
            ->get();

        return view('guru.kelas.index', compact('kelases', 'guru'));
    }

    /**
     * Display details of a specific class including its students.
     */
    public function show(Kelas $kelas)
    {
        /** @var User $guru */
        $guru = auth()->user();

        // Authorization check: Guru must teach in this class or be its wali kelas
        $isTeacher = $guru->guruMapels()->where('kelas_id', $kelas->id)->exists();
        $isWali = $guru->kelasWali && $guru->kelasWali->id === $kelas->id;

        if (!$isTeacher && !$isWali) {
            abort(403, 'Anda tidak memiliki akses ke kelas ini.');
        }

        $kelas->load(['waliKelas', 'siswas' => function ($q) {
            $q->orderBy('name');
        }, 'guruMapels.mapel', 'guruMapels.guru']);

        return view('guru.kelas.show', compact('kelas', 'guru', 'isWali'));
    }
}
