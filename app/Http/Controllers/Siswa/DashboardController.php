<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use App\Models\NilaiKomponen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Tampilkan ringkasan dashboard untuk Siswa.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $siswa = $user->load(['kelas.waliKelas']);

        $rawSemester = $request->input('semester', 'ganjil');
        $semester = strtolower($rawSemester);
        $tahunAjaran = $request->input('tahun_ajaran', '2024/2025');

        // Ambil data nilai raport siswa untuk semester & tahun ajaran terpilih
        $nilais = Nilai::with(['mapel', 'guru'])
            ->where('siswa_id', $user->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahunAjaran)
            ->get();

        // Ambil riwayat penilaian komponen terbaru (Tugas, UH, UTS, UAS, Remidi)
        $aktivitasTerbaru = NilaiKomponen::with('mapel')
            ->where('siswa_id', $user->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahunAjaran)
            ->latest('tanggal')
            ->latest('id')
            ->take(5)
            ->get();

        // Hitung statistik
        $totalMapel = $nilais->count();
        $rataRataPengetahuan = $nilais->isNotEmpty() ? round($nilais->avg('nilai_pengetahuan'), 1) : null;
        $rataRataAkhir = $nilais->isNotEmpty() ? round($nilais->avg('nilai_akhir'), 1) : null;
        $mapelTuntas = $nilais->filter(function ($n) {
            $kkm = $n->mapel ? $n->mapel->kkm : 75;
            return ($n->nilai_pengetahuan >= $kkm) && ($n->status_remidi !== 'perlu');
        })->count();
        $mapelRemidi = $nilais->filter(function ($n) {
            $kkm = $n->mapel ? $n->mapel->kkm : 75;
            return ($n->nilai_pengetahuan < $kkm) || ($n->status_remidi === 'perlu');
        })->count();

        return view('siswa.dashboard', compact(
            'siswa',
            'nilais',
            'aktivitasTerbaru',
            'semester',
            'tahunAjaran',
            'totalMapel',
            'rataRataPengetahuan',
            'rataRataAkhir',
            'mapelTuntas',
            'mapelRemidi'
        ));
    }
}
