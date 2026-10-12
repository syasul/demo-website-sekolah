<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\RdmSyncLog;
use App\Models\Siswa;
use Illuminate\Http\Request;

class RdmController extends Controller
{
    /**
     * Halaman simulasi integrasi RDM Kemenag.
     */
    public function index(Request $request)
    {
        $kelasList = Kelas::with('unit')->orderBy('tingkat')->orderBy('nama_rombel')->get();
        $selectedKelasId = $request->input('kelas_id', $kelasList->first()?->id);
        $semester = $request->input('semester', 'ganjil');

        $selectedKelas = Kelas::with('unit')->find($selectedKelasId);

        // Preview grades for this class
        $nilais = collect();
        if ($selectedKelas) {
            $nilais = Nilai::with(['siswa.siswa', 'mapel', 'guru'])
                ->where('kelas_id', $selectedKelas->id)
                ->where('semester', $semester)
                ->get();
        }

        $logs = RdmSyncLog::with('kelas')->latest()->take(10)->get();

        return view('admin.rdm.index', compact('kelasList', 'selectedKelas', 'selectedKelasId', 'semester', 'nilais', 'logs'));
    }

    /**
     * Proses kirim / sinkronisasi nilai ke RDM Kemenag (Simulasi Mock).
     */
    public function sync(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'semester' => 'required|in:ganjil,genap',
        ]);

        $kelas = Kelas::with('unit')->findOrFail($request->kelas_id);
        $totalNilai = Nilai::where('kelas_id', $kelas->id)->where('semester', $request->semester)->count();

        // Create mock sync log
        RdmSyncLog::create([
            'waktu' => now(),
            'kelas_id' => $kelas->id,
            'unit_id' => $kelas->unit_id,
            'jumlah_data' => $totalNilai > 0 ? $totalNilai : 24,
            'status' => 'sukses',
            'pesan' => "Sinkronisasi {$totalNilai} butir nilai raport kelas {$kelas->nama_lengkap} semester {$request->semester} berhasil dikirim ke server RDM Kemenag (Simulasi).",
        ]);

        return back()->with('success', "Simulasi Integrasi Berhasil: Data raport kelas {$kelas->nama_lengkap} telah disinkronkan ke format RDM Kemenag.");
    }
}
