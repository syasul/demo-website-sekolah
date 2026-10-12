<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\AbsensiGuru;
use App\Models\Jadwal;
use App\Models\Jurnal;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JurnalController extends Controller
{
    /**
     * Tampilkan riwayat dan form input Jurnal Mengajar.
     */
    public function index(Request $request)
    {
        $guru = Auth::user();
        $today = Carbon::today();

        // 1. GATE CHECK: Wajib Absen Masuk terlebih dahulu
        $isAbsenToday = AbsensiGuru::where('guru_id', $guru->id)
            ->whereDate('tanggal', $today->toDateString())
            ->exists();

        $jurnals = Jurnal::with(['kelas.unit', 'mapel'])
            ->where('guru_id', $guru->id)
            ->latest('tanggal')
            ->paginate(15);

        $kelasList = $guru->guruMapels->pluck('kelas')->unique();
        if ($kelasList->isEmpty()) {
            $kelasList = Kelas::with('unit')->get();
        }

        $mapelList = $guru->guruMapels->pluck('mapel')->unique();
        if ($mapelList->isEmpty()) {
            $mapelList = MataPelajaran::all();
        }

        return view('guru.jurnal.index', compact('guru', 'isAbsenToday', 'jurnals', 'kelasList', 'mapelList', 'today'));
    }

    /**
     * Simpan jurnal mengajar baru.
     */
    public function store(Request $request)
    {
        $guru = Auth::user();
        $today = Carbon::today();

        // GATE CHECK ENFORCEMENT
        $isAbsenToday = AbsensiGuru::where('guru_id', $guru->id)
            ->whereDate('tanggal', $today->toDateString())
            ->exists();

        if (! $isAbsenToday) {
            return back()->with('error', 'Akses Terkunci: Anda belum melakukan Absen Masuk hari ini. Silakan lakukan Absen Masuk terlebih dahulu di Dashboard Guru.');
        }

        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mata_pelajarans,id',
            'tanggal' => 'required|date',
            'jam_ke' => 'nullable|string',
            'materi' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        $kelas = Kelas::with('unit')->findOrFail($request->kelas_id);

        Jurnal::create([
            'guru_id' => $guru->id,
            'kelas_id' => $kelas->id,
            'mapel_id' => $request->mapel_id,
            'unit_id' => $kelas->unit_id,
            'tanggal' => $request->tanggal,
            'jam_ke' => $request->jam_ke,
            'materi' => $request->materi,
            'catatan' => $request->catatan,
        ]);

        return back()->with('success', "Alhamdulillah, Jurnal Mengajar untuk materi '{$request->materi}' di kelas {$kelas->nama_lengkap} berhasil disimpan.");
    }
}
