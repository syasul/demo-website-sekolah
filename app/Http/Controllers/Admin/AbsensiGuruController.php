<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AbsensiGuru;
use App\Models\Jurnal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AbsensiGuruController extends Controller
{
    /**
     * Tampilkan rekapitulasi absensi pendidik dan pemantauan jurnal harian.
     */
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal', Carbon::today()->toDateString());

        // Get all teachers
        $gurus = User::where('role', 'guru')
            ->with(['units', 'absensiGurus' => fn($q) => $q->whereDate('tanggal', $tanggal)])
            ->get();

        // Get journals for the day
        $jurnalsToday = Jurnal::with(['guru', 'kelas', 'mapel'])
            ->whereDate('tanggal', $tanggal)
            ->get()
            ->groupBy('guru_id');

        $guruStats = $gurus->map(function ($guru) use ($jurnalsToday) {
            $absen = $guru->absensiGurus->first();
            $jurnals = $jurnalsToday->get($guru->id, collect());

            return [
                'guru' => $guru,
                'absen' => $absen,
                'status_absen' => $absen ? $absen->status : 'Belum Absen',
                'jam_masuk' => $absen ? $absen->jam_masuk : '-',
                'jumlah_jurnal' => $jurnals->count(),
                'jurnals' => $jurnals,
                'is_complete' => $absen && $jurnals->count() > 0,
            ];
        });

        $summary = [
            'total_guru' => $gurus->count(),
            'sudah_absen' => $guruStats->where('status_absen', '!=', 'Belum Absen')->count(),
            'belum_absen' => $guruStats->where('status_absen', '==', 'Belum Absen')->count(),
            'jurnal_terisi' => $guruStats->where('jumlah_jurnal', '>', 0)->count(),
        ];

        return view('admin.absensi.guru', compact('guruStats', 'tanggal', 'summary'));
    }
}
