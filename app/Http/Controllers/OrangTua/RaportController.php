<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use App\Models\NilaiKomponen;
use App\Models\SchoolSetting;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RaportController extends Controller
{
    /**
     * Tampilkan raport digital ananda bagi orang tua.
     */
    public function index(Request $request)
    {
        /** @var User $parent */
        $parent = Auth::user();
        $anaks = $parent->anaks()->with(['siswa.kelas.waliKelas', 'siswa.unit'])->get();

        $activeAnakId = session('active_anak_id', $anaks->first()?->id);
        $selectedAnak = $anaks->firstWhere('id', $activeAnakId) ?: $anaks->first();

        if (! $selectedAnak) {
            return redirect()->route('orang-tua.dashboard');
        }

        $semester = strtolower($request->input('semester', 'ganjil'));
        $tahunAjaran = $request->input('tahun_ajaran', '2024/2025');

        $daftarTahun = Nilai::where('siswa_id', $selectedAnak->id)
            ->pluck('tahun_ajaran')
            ->unique()
            ->values()
            ->all();

        if (empty($daftarTahun)) {
            $daftarTahun = ['2024/2025', '2025/2026'];
        }

        $nilais = Nilai::with(['mapel', 'guru'])
            ->where('siswa_id', $selectedAnak->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahunAjaran)
            ->get();

        $komponens = NilaiKomponen::where('siswa_id', $selectedAnak->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahunAjaran)
            ->orderBy('tanggal')
            ->get()
            ->groupBy('mapel_id');

        $rataRataPengetahuan = $nilais->isNotEmpty() ? round($nilais->avg('nilai_pengetahuan'), 1) : 0;
        $rataRataKeterampilan = $nilais->isNotEmpty() ? round($nilais->avg('nilai_keterampilan'), 1) : 0;
        $rataRataAkhir = $nilais->isNotEmpty() ? round($nilais->avg('nilai_akhir'), 1) : 0;

        return view('orang_tua.raport.index', compact(
            'anaks',
            'selectedAnak',
            'nilais',
            'komponens',
            'semester',
            'tahunAjaran',
            'daftarTahun',
            'rataRataPengetahuan',
            'rataRataKeterampilan',
            'rataRataAkhir'
        ));
    }

    /**
     * Unduh PDF raport ananda bagi orang tua.
     */
    public function pdf(Request $request)
    {
        /** @var User $parent */
        $parent = Auth::user();
        $activeAnakId = session('active_anak_id');
        $selectedAnak = $parent->anaks()->with(['siswa.kelas.waliKelas', 'siswa.unit'])->findOrFail($activeAnakId);

        $semester = strtolower($request->input('semester', 'ganjil'));
        $tahunAjaran = $request->input('tahun_ajaran', '2024/2025');

        $nilais = Nilai::with(['mapel', 'guru'])
            ->where('siswa_id', $selectedAnak->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahunAjaran)
            ->get();

        $rataRataPengetahuan = $nilais->isNotEmpty() ? round($nilais->avg('nilai_pengetahuan'), 1) : 0;
        $rataRataKeterampilan = $nilais->isNotEmpty() ? round($nilais->avg('nilai_keterampilan'), 1) : 0;
        $rataRataAkhir = $nilais->isNotEmpty() ? round($nilais->avg('nilai_akhir'), 1) : 0;

        $setting = SchoolSetting::getActive();

        $logoPath = public_path('images/logo.png');
        if ($setting->logo_custom && file_exists(storage_path('app/public/' . $setting->logo_custom))) {
            $logoPath = storage_path('app/public/' . $setting->logo_custom);
        }

        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        }

        $data = [
            'siswa' => $selectedAnak,
            'nilais' => $nilais,
            'semester' => $semester,
            'tahunAjaran' => $tahunAjaran,
            'rataRataPengetahuan' => $rataRataPengetahuan,
            'rataRataKeterampilan' => $rataRataKeterampilan,
            'rataRataAkhir' => $rataRataAkhir,
            'logoBase64' => $logoBase64,
            'setting' => $setting,
            'tanggalCetak' => now()->translatedFormat('d F Y'),
        ];

        $pdf = Pdf::loadView('siswa.raport.pdf', $data);
        $pdf->setPaper('a4', 'portrait');

        $safeName = Str::slug($selectedAnak->name);
        $safeTahun = str_replace('/', '-', $tahunAjaran);
        $filename = "Raport_{$safeName}_{$semester}_{$safeTahun}.pdf";

        return $pdf->download($filename);
    }
}
