<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\AbsensiGuru;
use App\Models\Jadwal;
use App\Models\Jurnal;
use App\Models\Nilai;
use App\Models\SchoolSetting;
use App\Models\User;
use Carbon\Carbon;
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

        $today = Carbon::today();
        $namaHari = [
            0 => 'Minggu',
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
        ][$today->dayOfWeek];

        // 1. Check teacher check-in status today
        $absenToday = AbsensiGuru::where('guru_id', $guru->id)
            ->whereDate('tanggal', $today->toDateString())
            ->first();

        $isAbsenToday = (bool) $absenToday;

        // 2. Today's schedules & weekly schedule
        $jadwalHariIni = Jadwal::with(['kelas.unit', 'mapel'])
            ->where('guru_id', $guru->id)
            ->where('hari', $namaHari)
            ->orderBy('jam_mulai')
            ->get();

        $jadwalMingguan = Jadwal::with(['kelas.unit', 'mapel'])
            ->where('guru_id', $guru->id)
            ->orderBy('jam_mulai')
            ->get();

        // 3. Count journals filled today
        $jurnalTodayCount = Jurnal::where('guru_id', $guru->id)
            ->whereDate('tanggal', $today->toDateString())
            ->count();

        // Load assignments with class and subjects
        $guru->load(['guruMapels.kelas.siswas', 'guruMapels.mapel', 'kelasWali.siswas', 'units']);

        $kelasIds = $guru->guruMapels->pluck('kelas_id')->unique();
        $totalKelas = $kelasIds->count();
        $totalMapel = $guru->guruMapels->pluck('mapel_id')->unique()->count();
        
        $totalSiswaDiajar = User::where('role', 'siswa')
            ->whereIn('kelas_id', $kelasIds)
            ->count();

        $setting = SchoolSetting::first();
        $currentSemester = $setting ? $setting->semester_aktif : 'ganjil';
        $currentTahun = $setting ? $setting->tahun_ajaran_aktif : '2024/2025';

        $assignments = $guru->guruMapels->map(function ($gm) use ($currentSemester, $currentTahun) {
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
            'isAbsenToday' => $isAbsenToday,
            'absenToday' => $absenToday,
            'namaHari' => $namaHari,
            'jadwalHariIni' => $jadwalHariIni,
            'jadwalMingguan' => $jadwalMingguan,
            'jurnalTodayCount' => $jurnalTodayCount,
        ]);
    }
}
