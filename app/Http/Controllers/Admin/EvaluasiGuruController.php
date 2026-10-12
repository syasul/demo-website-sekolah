<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AbsensiGuru;
use App\Models\EvaluasiGuru;
use App\Models\InstrumenPenilaian;
use App\Models\Jurnal;
use App\Models\SchoolSetting;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluasiGuruController extends Controller
{
    /**
     * Daftar evaluasi kinerja dewan asatidz / guru.
     */
    public function index()
    {
        $gurus = User::where('role', 'guru')->with('units')->get();
        $evaluasis = EvaluasiGuru::with(['guru', 'penilai', 'unit'])->latest()->paginate(15);

        return view('admin.evaluasi.index', compact('gurus', 'evaluasis'));
    }

    /**
     * Form penilaian evaluasi kinerja guru.
     */
    public function create(Request $request)
    {
        $guruId = $request->input('guru_id');
        $selectedGuru = $guruId ? User::with('units')->findOrFail($guruId) : null;
        $gurus = User::where('role', 'guru')->get();
        $instrumens = InstrumenPenilaian::all()->groupBy('kompetensi');

        // Otomatis hitung metrik pendukung jika guru dipilih
        $autoMetrics = null;
        if ($selectedGuru) {
            $totalHariAbsen = AbsensiGuru::where('guru_id', $selectedGuru->id)->count();
            $totalHadir = AbsensiGuru::where('guru_id', $selectedGuru->id)->where('status', 'hadir')->count();
            $persenKehadiran = $totalHariAbsen > 0 ? round(($totalHadir / $totalHariAbsen) * 100, 1) : 100.0;
            $totalJurnal = Jurnal::where('guru_id', $selectedGuru->id)->count();

            $autoMetrics = [
                'kehadiran_persen' => $persenKehadiran,
                'total_jurnal' => $totalJurnal,
            ];
        }

        return view('admin.evaluasi.create', compact('gurus', 'selectedGuru', 'instrumens', 'autoMetrics'));
    }

    /**
     * Simpan evaluasi kinerja guru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|exists:users,id',
            'periode_tahun' => 'required|string',
            'semester' => 'required|in:ganjil,genap',
            'skor_pedagogik' => 'required|numeric|min:0|max:100',
            'skor_profesional' => 'required|numeric|min:0|max:100',
            'skor_kepribadian' => 'required|numeric|min:0|max:100',
            'skor_sosial' => 'required|numeric|min:0|max:100',
            'catatan' => 'nullable|string',
        ]);

        $guru = User::with('units')->findOrFail($request->guru_id);

        $skorTotal = round(
            ($request->skor_pedagogik * 0.25) +
            ($request->skor_profesional * 0.25) +
            ($request->skor_kepribadian * 0.25) +
            ($request->skor_sosial * 0.25),
            2
        );

        $evaluasi = EvaluasiGuru::updateOrCreate(
            [
                'guru_id' => $guru->id,
                'periode_tahun' => $request->periode_tahun,
                'semester' => $request->semester,
            ],
            [
                'penilai_id' => Auth::id(),
                'unit_id' => $guru->units->first()?->id,
                'skor_pedagogik' => $request->skor_pedagogik,
                'skor_profesional' => $request->skor_profesional,
                'skor_kepribadian' => $request->skor_kepribadian,
                'skor_sosial' => $request->skor_sosial,
                'skor_total' => $skorTotal,
                'catatan' => $request->catatan,
            ]
        );

        return redirect()->route('admin.evaluasi.index')->with('success', "Evaluasi kinerja untuk {$guru->name} berhasil disimpan.");
    }

    /**
     * Cetak Laporan Kinerja Guru (PDF).
     */
    public function cetakPdf(EvaluasiGuru $evaluasi)
    {
        $evaluasi->load(['guru', 'penilai', 'unit']);
        $school = SchoolSetting::first();

        // Calculate attendance & journal stats
        $guru = $evaluasi->guru;
        $totalHadir = AbsensiGuru::where('guru_id', $guru->id)->where('status', 'hadir')->count();
        $totalJurnal = Jurnal::where('guru_id', $guru->id)->count();

        $pdf = Pdf::loadView('admin.evaluasi.pdf', compact('evaluasi', 'school', 'totalHadir', 'totalJurnal'));
        $pdf->setPaper('a4', 'portrait');

        $fileName = 'Laporan_Kinerja_' . str_replace(' ', '_', $guru->name) . '_' . date('Ymd') . '.pdf';
        return $pdf->download($fileName);
    }
}
