<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AbsensiSiswa;
use App\Models\Kelas;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AbsensiSiswaController extends Controller
{
    /**
     * Tampilkan rekapitulasi absensi santri / siswa.
     */
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal', Carbon::today()->toDateString());
        $kelasId = $request->input('kelas_id');
        $status = $request->input('status');

        $kelasList = Kelas::with('unit')->orderBy('tingkat')->orderBy('nama_rombel')->get();

        $query = AbsensiSiswa::with(['siswa', 'siswaProfile', 'kelas', 'unit', 'mapel', 'guru'])
            ->whereDate('tanggal', $tanggal);

        if ($kelasId) {
            $query->where('kelas_id', $kelasId);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $absensis = $query->latest()->paginate(25)->withQueryString();

        // Calculate summary counts for the selected date
        $baseQuery = AbsensiSiswa::whereDate('tanggal', $tanggal);
        if ($kelasId) {
            $baseQuery->where('kelas_id', $kelasId);
        }

        $summary = [
            'total' => (clone $baseQuery)->count(),
            'hadir' => (clone $baseQuery)->where('status', 'hadir')->count(),
            'izin' => (clone $baseQuery)->where('status', 'izin')->count(),
            'sakit' => (clone $baseQuery)->where('status', 'sakit')->count(),
            'alpa' => (clone $baseQuery)->where('status', 'alpa')->count(),
        ];

        return view('admin.absensi.siswa', compact('absensis', 'kelasList', 'tanggal', 'kelasId', 'status', 'summary'));
    }
}
