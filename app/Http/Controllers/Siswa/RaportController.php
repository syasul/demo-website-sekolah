<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use App\Models\NilaiKomponen;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RaportController extends Controller
{
    /**
     * Tampilkan halaman raport digital siswa.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $siswa = $user->load(['kelas.waliKelas']);

        $semester = strtolower($request->input('semester', 'ganjil'));
        $tahunAjaran = $request->input('tahun_ajaran', '2024/2025');

        // Daftar tahun ajaran yang tersedia dari histori nilai
        $daftarTahun = Nilai::where('siswa_id', $user->id)
            ->pluck('tahun_ajaran')
            ->unique()
            ->values()
            ->all();

        if (empty($daftarTahun)) {
            $daftarTahun = ['2024/2025', '2025/2026'];
        }

        // Ambil nilai raport final siswa
        $nilais = Nilai::with(['mapel', 'guru'])
            ->where('siswa_id', $user->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahunAjaran)
            ->get();

        // Ambil rincian komponen harian (Tugas, UH, UTS, UAS, Remidi) per mapel
        $komponens = NilaiKomponen::where('siswa_id', $user->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahunAjaran)
            ->orderBy('tanggal')
            ->get()
            ->groupBy('mapel_id');

        // Ringkasan nilai
        $rataRataPengetahuan = $nilais->isNotEmpty() ? round($nilais->avg('nilai_pengetahuan'), 1) : 0;
        $rataRataKeterampilan = $nilais->isNotEmpty() ? round($nilais->avg('nilai_keterampilan'), 1) : 0;
        $rataRataAkhir = $nilais->isNotEmpty() ? round($nilais->avg('nilai_akhir'), 1) : 0;

        return view('siswa.raport.index', compact(
            'siswa',
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
     * Unduh atau cetak raport dalam bentuk PDF resmi sekolah.
     */
    public function pdf(Request $request)
    {
        $user = Auth::user();
        $siswa = $user->load(['kelas.waliKelas']);

        $semester = strtolower($request->input('semester', 'ganjil'));
        $tahunAjaran = $request->input('tahun_ajaran', '2024/2025');

        $nilais = Nilai::with(['mapel', 'guru'])
            ->where('siswa_id', $user->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahunAjaran)
            ->get();

        // Rata-rata
        $rataRataPengetahuan = $nilais->isNotEmpty() ? round($nilais->avg('nilai_pengetahuan'), 1) : 0;
        $rataRataKeterampilan = $nilais->isNotEmpty() ? round($nilais->avg('nilai_keterampilan'), 1) : 0;
        $rataRataAkhir = $nilais->isNotEmpty() ? round($nilais->avg('nilai_akhir'), 1) : 0;

        $setting = \App\Models\SchoolSetting::getActive();

        // Path logo untuk PDF (menggunakan file_get_contents base64 untuk kompatibilitas DomPDF terbaik)
        $logoPath = public_path('images/logo.png');
        if ($setting->logo_custom && file_exists(storage_path('app/public/' . $setting->logo_custom))) {
            $logoPath = storage_path('app/public/' . $setting->logo_custom);
        }

        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        }

        $data = [
            'siswa' => $siswa,
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

        $safeName = Str::slug($siswa->name);
        $safeTahun = str_replace('/', '-', $tahunAjaran);
        $filename = "Raport_{$safeName}_{$semester}_{$safeTahun}.pdf";

        if ($request->input('mode') === 'preview') {
            return $pdf->stream($filename);
        }

        return $pdf->download($filename);
    }
}
