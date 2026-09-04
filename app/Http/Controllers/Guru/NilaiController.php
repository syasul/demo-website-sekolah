<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\GuruMapel;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\User;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    /**
     * Display selection page for class, subject, semester, and academic year.
     */
    public function pilih(Request $request)
    {
        /** @var User $guru */
        $guru = auth()->user();

        $guruMapels = $guru->guruMapels()->with(['kelas', 'mapel'])->get();

        return view('guru.raport.pilih', compact('guruMapels', 'guru'));
    }

    /**
     * Show bulk grade entry form for a specific class and subject.
     */
    public function create(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mata_pelajarans,id',
            'semester' => 'nullable|in:ganjil,genap',
            'tahun_ajaran' => 'nullable|string',
        ]);

        /** @var User $guru */
        $guru = auth()->user();

        $kelasId = $request->kelas_id;
        $mapelId = $request->mapel_id;
        $semester = $request->semester ?? 'ganjil';
        $tahunAjaran = $request->tahun_ajaran ?? '2025/2026';

        // Authorization: Guru must be assigned to this class and subject
        $isAssigned = $guru->guruMapels()
            ->where('kelas_id', $kelasId)
            ->where('mapel_id', $mapelId)
            ->exists();

        if (!$isAssigned) {
            abort(403, 'Anda tidak memiliki wewenang menginput nilai untuk mata pelajaran di kelas ini.');
        }

        $kelas = Kelas::with(['siswas' => function ($q) {
            $q->orderBy('name');
        }])->findOrFail($kelasId);

        $mapel = MataPelajaran::findOrFail($mapelId);

        // Fetch existing grades for this combination
        $existingNilai = Nilai::where('kelas_id', $kelasId)
            ->where('mapel_id', $mapelId)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahunAjaran)
            ->get()
            ->keyBy('siswa_id');

        // Check if grades are locked
        $isLocked = $existingNilai->contains('is_locked', true);

        return view('guru.raport.create', compact(
            'kelas',
            'mapel',
            'semester',
            'tahunAjaran',
            'existingNilai',
            'isLocked'
        ));
    }

    /**
     * Store bulk grades for students in the class.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mata_pelajarans,id',
            'semester' => 'required|in:ganjil,genap',
            'tahun_ajaran' => 'required|string',
            'nilai' => 'required|array',
            'nilai.*.pengetahuan' => 'nullable|numeric|min:0|max:100',
            'nilai.*.keterampilan' => 'nullable|numeric|min:0|max:100',
            'nilai.*.sikap' => 'nullable|in:A,B,C,D',
            'nilai.*.catatan' => 'nullable|string|max:500',
        ], [
            'nilai.*.pengetahuan.min' => 'Nilai pengetahuan minimal 0.',
            'nilai.*.pengetahuan.max' => 'Nilai pengetahuan maksimal 100.',
            'nilai.*.keterampilan.min' => 'Nilai keterampilan minimal 0.',
            'nilai.*.keterampilan.max' => 'Nilai keterampilan maksimal 100.',
        ]);

        /** @var User $guru */
        $guru = auth()->user();

        $kelasId = $request->kelas_id;
        $mapelId = $request->mapel_id;
        $semester = $request->semester;
        $tahunAjaran = $request->tahun_ajaran;

        // Authorization check
        $isAssigned = $guru->guruMapels()
            ->where('kelas_id', $kelasId)
            ->where('mapel_id', $mapelId)
            ->exists();

        if (!$isAssigned) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah nilai ini.');
        }

        // Check if locked
        $isLocked = Nilai::where('kelas_id', $kelasId)
            ->where('mapel_id', $mapelId)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahunAjaran)
            ->where('is_locked', true)
            ->exists();

        if ($isLocked) {
            return back()->withErrors(['lock' => 'Nilai semester ini telah dikunci/finalisasi dan tidak dapat diubah lagi tanpa izin Admin.']);
        }

        foreach ($request->nilai as $siswaId => $data) {
            // Only update if at least one field has value or record already exists
            $hasInput = !is_null($data['pengetahuan']) || !is_null($data['keterampilan']) || !empty($data['catatan']);

            if ($hasInput) {
                Nilai::updateOrCreate(
                    [
                        'siswa_id' => $siswaId,
                        'mapel_id' => $mapelId,
                        'semester' => $semester,
                        'tahun_ajaran' => $tahunAjaran,
                    ],
                    [
                        'kelas_id' => $kelasId,
                        'guru_id' => $guru->id,
                        'nilai_pengetahuan' => $data['pengetahuan'] !== '' ? $data['pengetahuan'] : null,
                        'nilai_keterampilan' => $data['keterampilan'] !== '' ? $data['keterampilan'] : null,
                        'nilai_sikap' => $data['sikap'] ?? 'A',
                        'catatan' => $data['catatan'] ?? null,
                    ]
                );
            }
        }

        return back()->with('success', 'Seluruh nilai raport siswa berhasil disimpan.');
    }

    /**
     * Display recap of grades for a class.
     */
    public function rekap(Request $request)
    {
        /** @var User $guru */
        $guru = auth()->user();

        $guruMapels = $guru->guruMapels()->with(['kelas', 'mapel'])->get();

        $selectedKelasId = $request->query('kelas_id', $guruMapels->first()?->kelas_id);
        $selectedMapelId = $request->query('mapel_id', $guruMapels->first()?->mapel_id);
        $semester = $request->query('semester', 'ganjil');
        $tahunAjaran = $request->query('tahun_ajaran', '2025/2026');

        $kelas = null;
        $mapel = null;
        $nilais = collect();
        $isLocked = false;

        if ($selectedKelasId && $selectedMapelId) {
            $kelas = Kelas::with(['siswas' => function ($q) {
                $q->orderBy('name');
            }])->find($selectedKelasId);

            $mapel = MataPelajaran::find($selectedMapelId);

            if ($kelas && $mapel) {
                $nilais = Nilai::where('kelas_id', $selectedKelasId)
                    ->where('mapel_id', $selectedMapelId)
                    ->where('semester', $semester)
                    ->where('tahun_ajaran', $tahunAjaran)
                    ->with('siswa')
                    ->get()
                    ->keyBy('siswa_id');

                $komponens = \App\Models\NilaiKomponen::where('kelas_id', $selectedKelasId)
                    ->where('mapel_id', $selectedMapelId)
                    ->where('semester', $semester)
                    ->where('tahun_ajaran', $tahunAjaran)
                    ->get()
                    ->groupBy('siswa_id');

                $isLocked = $nilais->contains('is_locked', true);
            }
        }

        $bobots = \App\Models\PengaturanBobot::getBobotArray();

        return view('guru.raport.rekap', compact(
            'guru',
            'guruMapels',
            'selectedKelasId',
            'selectedMapelId',
            'semester',
            'tahunAjaran',
            'kelas',
            'mapel',
            'nilais',
            'komponens',
            'bobots',
            'isLocked'
        ));
    }

    /**
     * Lock/finalize grades for semester.
     */
    public function lock(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mata_pelajarans,id',
            'semester' => 'required|in:ganjil,genap',
            'tahun_ajaran' => 'required|string',
        ]);

        /** @var User $guru */
        $guru = auth()->user();

        $isAssigned = $guru->guruMapels()
            ->where('kelas_id', $request->kelas_id)
            ->where('mapel_id', $request->mapel_id)
            ->exists();

        if (!$isAssigned) {
            abort(403);
        }

        $kelas = Kelas::with('siswas')->findOrFail($request->kelas_id);

        foreach ($kelas->siswas as $siswa) {
            Nilai::updateOrCreate(
                [
                    'siswa_id' => $siswa->id,
                    'mapel_id' => $request->mapel_id,
                    'semester' => $request->semester,
                    'tahun_ajaran' => $request->tahun_ajaran,
                ],
                [
                    'kelas_id' => $request->kelas_id,
                    'guru_id' => $guru->id,
                    'is_locked' => true,
                ]
            );
        }

        return back()->with('success', 'Nilai semester ini berhasil dikunci dan difinalisasi.');
    }
}
