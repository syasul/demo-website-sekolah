<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the teacher dashboard.
     */
    public function index()
    {
        /** @var User $guru */
        $guru = auth()->user();

        // Load assignments with class and subjects
        $guru->load(['guruMapels.kelas.siswas', 'guruMapels.mapel', 'kelasWali.siswas']);

        $kelasIds = $guru->guruMapels->pluck('kelas_id')->unique();
        $totalKelas = $kelasIds->count();
        $totalMapel = $guru->guruMapels->pluck('mapel_id')->unique()->count();
        
        $totalSiswaDiajar = User::where('role', 'siswa')
            ->whereIn('kelas_id', $kelasIds)
            ->count();

        // Calculate grading progress for active semester
        $currentSemester = 'ganjil';
        $currentTahun = '2025/2026';

        $assignments = $guru->guruMapels->map(function ($gm) use ($currentSemester, $currentTahun, $guru) {
            $totalStudents = $gm->kelas->siswas->count();
            $gradedCount = Nilai::where('kelas_id', $gm->kelas_id)
                ->where('mapel_id', $gm->mapel_id)
                ->where('semester', $currentSemester)
                ->where('tahun_ajaran', $currentTahun)
                ->whereNotNull('nilai_pengetahuan')
                ->count();

            $isLocked = Nilai::where('kelas_id', $gm->kelas_id)
                ->where('mapel_id', $gm->mapel_id)
                ->where('semester', $currentSemester)
                ->where('tahun_ajaran', $currentTahun)
                ->where('is_locked', true)
                ->exists();

            $percentage = $totalStudents > 0 ? round(($gradedCount / $totalStudents) * 100) : 0;

            return [
                'guru_mapel' => $gm,
                'kelas' => $gm->kelas,
                'mapel' => $gm->mapel,
                'total_students' => $totalStudents,
                'graded_count' => $gradedCount,
                'percentage' => $percentage,
                'is_locked' => $isLocked,
            ];
        });

        return view('guru.dashboard', [
            'guru' => $guru,
            'totalKelas' => $totalKelas,
            'totalMapel' => $totalMapel,
            'totalSiswaDiajar' => $totalSiswaDiajar,
            'assignments' => $assignments,
            'kelasWali' => $guru->kelasWali,
            'currentSemester' => $currentSemester,
            'currentTahun' => $currentTahun,
        ]);
    }
}
