<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\AbsensiSiswa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    /**
     * Tampilkan riwayat kehadiran santri bagi orang tua.
     */
    public function index()
    {
        /** @var User $parent */
        $parent = Auth::user();
        $anaks = $parent->anaks()->with('siswa.kelas.unit')->get();

        $activeAnakId = session('active_anak_id', $anaks->first()?->id);
        $selectedAnak = $anaks->firstWhere('id', $activeAnakId) ?: $anaks->first();

        if (! $selectedAnak) {
            return redirect()->route('orang-tua.dashboard');
        }

        $absensis = AbsensiSiswa::with('guru')
            ->where('siswa_id', $selectedAnak->id)
            ->latest('tanggal')
            ->paginate(20);

        $totalHadir = AbsensiSiswa::where('siswa_id', $selectedAnak->id)->where('status', 'hadir')->count();
        $totalIzin = AbsensiSiswa::where('siswa_id', $selectedAnak->id)->where('status', 'izin')->count();
        $totalSakit = AbsensiSiswa::where('siswa_id', $selectedAnak->id)->where('status', 'sakit')->count();
        $totalAlpa = AbsensiSiswa::where('siswa_id', $selectedAnak->id)->where('status', 'alpa')->count();
        $totalSemua = $totalHadir + $totalIzin + $totalSakit + $totalAlpa;

        $persenHadir = $totalSemua > 0 ? round(($totalHadir / $totalSemua) * 100, 1) : 100.0;

        return view('orang_tua.absensi.index', compact(
            'anaks',
            'selectedAnak',
            'absensis',
            'totalHadir',
            'totalIzin',
            'totalSakit',
            'totalAlpa',
            'persenHadir'
        ));
    }
}
