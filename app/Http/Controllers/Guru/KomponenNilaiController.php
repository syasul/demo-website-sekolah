<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\NilaiKomponen;
use App\Models\PengaturanBobot;
use App\Models\User;
use App\Services\HitungNilaiAkhirService;
use Illuminate\Http\Request;

class KomponenNilaiController extends Controller
{
    /**
     * Halaman Manajemen Tugas & Ulangan Harian (UH).
     */
    public function indexTugasUh(Request $request)
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
        $sessions = collect();

        if ($selectedKelasId && $selectedMapelId) {
            $isAssigned = $guru->guruMapels()
                ->where('kelas_id', $selectedKelasId)
                ->where('mapel_id', $selectedMapelId)
                ->exists();

            if (!$isAssigned) {
                abort(403);
            }

            $kelas = Kelas::with(['siswas' => function ($q) {
                $q->orderBy('name');
            }])->find($selectedKelasId);

            $mapel = MataPelajaran::find($selectedMapelId);

            if ($kelas && $mapel) {
                // Ambil daftar sesi yang sudah dibuat
                $rawSessions = NilaiKomponen::where('kelas_id', $selectedKelasId)
                    ->where('mapel_id', $selectedMapelId)
                    ->where('semester', $semester)
                    ->where('tahun_ajaran', $tahunAjaran)
                    ->whereIn('jenis', ['tugas', 'uh'])
                    ->orderBy('created_at', 'desc')
                    ->get();

                $sessions = $rawSessions->groupBy(function ($item) {
                    return $item->jenis . '_' . $item->judul . '_' . ($item->tanggal ? $item->tanggal->format('Y-m-d') : '');
                })->map(function ($items) {
                    $first = $items->first();
                    return [
                        'jenis' => $first->jenis,
                        'judul' => $first->judul,
                        'tanggal' => $first->tanggal,
                        'created_at' => $first->created_at,
                        'count' => $items->count(),
                        'avg' => round($items->avg('nilai'), 1),
                        'items' => $items,
                    ];
                });
            }
        }

        return view('guru.nilai.tugas-uh', compact(
            'guru',
            'guruMapels',
            'selectedKelasId',
            'selectedMapelId',
            'semester',
            'tahunAjaran',
            'kelas',
            'mapel',
            'sessions'
        ));
    }

    /**
     * Simpan sesi Tugas / UH baru beserta input nilai massal siswa.
     */
    public function storeTugasUh(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mata_pelajarans,id',
            'semester' => 'required|in:ganjil,genap',
            'tahun_ajaran' => 'required|string',
            'jenis' => 'required|in:tugas,uh',
            'judul' => 'required|string|max:100',
            'tanggal' => 'nullable|date',
            'nilai' => 'required|array',
            'nilai.*' => 'nullable|numeric|min:0|max:100',
        ], [
            'judul.required' => 'Nama/Judul sesi (misal Tugas 1 / UH Bab 1) wajib diisi.',
            'nilai.*.min' => 'Nilai minimal 0.',
            'nilai.*.max' => 'Nilai maksimal 100.',
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

        foreach ($request->nilai as $siswaId => $val) {
            if ($val !== null && $val !== '') {
                NilaiKomponen::updateOrCreate(
                    [
                        'siswa_id' => $siswaId,
                        'kelas_id' => $request->kelas_id,
                        'mapel_id' => $request->mapel_id,
                        'semester' => $request->semester,
                        'tahun_ajaran' => $request->tahun_ajaran,
                        'jenis' => $request->jenis,
                        'judul' => $request->judul,
                    ],
                    [
                        'guru_id' => $guru->id,
                        'nilai' => $val,
                        'tanggal' => $request->tanggal ?? now(),
                    ]
                );
            }
        }

        // Kalkulasi otomatis nilai akhir
        HitungNilaiAkhirService::hitung($request->kelas_id, $request->mapel_id, $request->semester, $request->tahun_ajaran);

        return back()->with('success', "Sesi {$request->judul} berhasil disimpan dan nilai akhir raport telah dikalkulasi.");
    }

    /**
     * Hapus seluruh sesi tugas/UH tertentu.
     */
    public function destroySession(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mata_pelajarans,id',
            'semester' => 'required|in:ganjil,genap',
            'tahun_ajaran' => 'required|string',
            'jenis' => 'required|in:tugas,uh',
            'judul' => 'required|string',
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

        NilaiKomponen::where('kelas_id', $request->kelas_id)
            ->where('mapel_id', $request->mapel_id)
            ->where('semester', $request->semester)
            ->where('tahun_ajaran', $request->tahun_ajaran)
            ->where('jenis', $request->jenis)
            ->where('judul', $request->judul)
            ->delete();

        HitungNilaiAkhirService::hitung($request->kelas_id, $request->mapel_id, $request->semester, $request->tahun_ajaran);

        return back()->with('success', "Sesi {$request->judul} berhasil dihapus.");
    }

    /**
     * Halaman Input Nilai UTS & UAS.
     */
    public function indexUtsUas(Request $request)
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
        $utsRecords = collect();
        $uasRecords = collect();

        if ($selectedKelasId && $selectedMapelId) {
            $isAssigned = $guru->guruMapels()
                ->where('kelas_id', $selectedKelasId)
                ->where('mapel_id', $selectedMapelId)
                ->exists();

            if (!$isAssigned) {
                abort(403);
            }

            $kelas = Kelas::with(['siswas' => function ($q) {
                $q->orderBy('name');
            }])->find($selectedKelasId);

            $mapel = MataPelajaran::find($selectedMapelId);

            if ($kelas && $mapel) {
                $utsRecords = NilaiKomponen::where('kelas_id', $selectedKelasId)
                    ->where('mapel_id', $selectedMapelId)
                    ->where('semester', $semester)
                    ->where('tahun_ajaran', $tahunAjaran)
                    ->where('jenis', 'uts')
                    ->get()
                    ->keyBy('siswa_id');

                $uasRecords = NilaiKomponen::where('kelas_id', $selectedKelasId)
                    ->where('mapel_id', $selectedMapelId)
                    ->where('semester', $semester)
                    ->where('tahun_ajaran', $tahunAjaran)
                    ->where('jenis', 'uas')
                    ->get()
                    ->keyBy('siswa_id');
            }
        }

        return view('guru.nilai.uts-uas', compact(
            'guru',
            'guruMapels',
            'selectedKelasId',
            'selectedMapelId',
            'semester',
            'tahunAjaran',
            'kelas',
            'mapel',
            'utsRecords',
            'uasRecords'
        ));
    }

    /**
     * Simpan nilai UTS & UAS massal.
     */
    public function storeUtsUas(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mata_pelajarans,id',
            'semester' => 'required|in:ganjil,genap',
            'tahun_ajaran' => 'required|string',
            'nilai_uts' => 'nullable|array',
            'nilai_uts.*' => 'nullable|numeric|min:0|max:100',
            'nilai_uas' => 'nullable|array',
            'nilai_uas.*' => 'nullable|numeric|min:0|max:100',
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

        // Simpan UTS
        if ($request->has('nilai_uts')) {
            foreach ($request->nilai_uts as $siswaId => $val) {
                if ($val !== null && $val !== '') {
                    NilaiKomponen::updateOrCreate(
                        [
                            'siswa_id' => $siswaId,
                            'kelas_id' => $request->kelas_id,
                            'mapel_id' => $request->mapel_id,
                            'semester' => $request->semester,
                            'tahun_ajaran' => $request->tahun_ajaran,
                            'jenis' => 'uts',
                        ],
                        [
                            'guru_id' => $guru->id,
                            'judul' => 'UTS Semester ' . ucfirst($request->semester),
                            'nilai' => $val,
                            'tanggal' => now(),
                        ]
                    );
                }
            }
        }

        // Simpan UAS
        if ($request->has('nilai_uas')) {
            foreach ($request->nilai_uas as $siswaId => $val) {
                if ($val !== null && $val !== '') {
                    NilaiKomponen::updateOrCreate(
                        [
                            'siswa_id' => $siswaId,
                            'kelas_id' => $request->kelas_id,
                            'mapel_id' => $request->mapel_id,
                            'semester' => $request->semester,
                            'tahun_ajaran' => $request->tahun_ajaran,
                            'jenis' => 'uas',
                        ],
                        [
                            'guru_id' => $guru->id,
                            'judul' => 'UAS Semester ' . ucfirst($request->semester),
                            'nilai' => $val,
                            'tanggal' => now(),
                        ]
                    );
                }
            }
        }

        // Kalkulasi otomatis nilai akhir
        HitungNilaiAkhirService::hitung($request->kelas_id, $request->mapel_id, $request->semester, $request->tahun_ajaran);

        return back()->with('success', 'Nilai UTS & UAS berhasil disimpan dan nilai akhir telah dikalkulasi.');
    }

    /**
     * Halaman Program Remedial (Siswa di bawah KKM).
     */
    public function indexRemidi(Request $request)
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
        $kkm = 75;
        $remedialCandidates = collect();

        if ($selectedKelasId && $selectedMapelId) {
            $isAssigned = $guru->guruMapels()
                ->where('kelas_id', $selectedKelasId)
                ->where('mapel_id', $selectedMapelId)
                ->exists();

            if (!$isAssigned) {
                abort(403);
            }

            $kelas = Kelas::find($selectedKelasId);
            $mapel = MataPelajaran::find($selectedMapelId);

            if ($kelas && $mapel) {
                $kkm = $mapel->kkm ?? 75;

                // Ambil semua UH di mana nilai < KKM
                $uhBelowKkm = NilaiKomponen::where('kelas_id', $selectedKelasId)
                    ->where('mapel_id', $selectedMapelId)
                    ->where('semester', $semester)
                    ->where('tahun_ajaran', $tahunAjaran)
                    ->where('jenis', 'uh')
                    ->where('nilai', '<', $kkm)
                    ->with(['siswa', 'remidis'])
                    ->get();

                $remedialCandidates = $uhBelowKkm->map(function ($uh) use ($kkm) {
                    $remidi = $uh->remidis->first();
                    $effectiveScore = $remidi ? min($kkm, $remidi->nilai) : $uh->nilai;
                    $status = $remidi ? 'sudah_remidi' : 'perlu_remidi';

                    return [
                        'uh' => $uh,
                        'siswa' => $uh->siswa,
                        'nilai_asli' => $uh->nilai,
                        'remidi' => $remidi,
                        'effective_score' => $effectiveScore,
                        'status' => $status,
                    ];
                });
            }
        }

        return view('guru.nilai.remidi', compact(
            'guru',
            'guruMapels',
            'selectedKelasId',
            'selectedMapelId',
            'semester',
            'tahunAjaran',
            'kelas',
            'mapel',
            'kkm',
            'remedialCandidates'
        ));
    }

    /**
     * Simpan nilai remedial untuk UH tertentu.
     */
    public function storeRemidi(Request $request)
    {
        $request->validate([
            'uh_id' => 'required|exists:nilai_komponens,id',
            'nilai_remidi' => 'required|numeric|min:0|max:100',
        ], [
            'nilai_remidi.required' => 'Nilai remidi wajib diisi.',
            'nilai_remidi.min' => 'Nilai minimal 0.',
            'nilai_remidi.max' => 'Nilai maksimal 100.',
        ]);

        /** @var User $guru */
        $guru = auth()->user();

        $uh = NilaiKomponen::with('mapel')->findOrFail($request->uh_id);

        $isAssigned = $guru->guruMapels()
            ->where('kelas_id', $uh->kelas_id)
            ->where('mapel_id', $uh->mapel_id)
            ->exists();

        if (!$isAssigned) {
            abort(403);
        }

        $kkm = $uh->mapel->kkm ?? 75;

        NilaiKomponen::updateOrCreate(
            [
                'komponen_asal_id' => $uh->id,
                'jenis' => 'remidi',
            ],
            [
                'siswa_id' => $uh->siswa_id,
                'kelas_id' => $uh->kelas_id,
                'mapel_id' => $uh->mapel_id,
                'guru_id' => $guru->id,
                'semester' => $uh->semester,
                'tahun_ajaran' => $uh->tahun_ajaran,
                'judul' => 'Remidi ' . $uh->judul,
                'nilai' => $request->nilai_remidi,
                'tanggal' => now(),
            ]
        );

        // Kalkulasi ulang nilai akhir
        HitungNilaiAkhirService::hitung($uh->kelas_id, $uh->mapel_id, $uh->semester, $uh->tahun_ajaran, $uh->siswa_id);

        $effective = min($kkm, $request->nilai_remidi);

        return back()->with('success', "Nilai remedial {$uh->siswa->name} berhasil disimpan (Nilai efektif: {$effective}, Maksimal KKM: {$kkm}).");
    }

    /**
     * Hitung ulang seluruh nilai akhir semester ini.
     */
    public function hitungUlang(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mata_pelajarans,id',
            'semester' => 'required|in:ganjil,genap',
            'tahun_ajaran' => 'required|string',
        ]);

        HitungNilaiAkhirService::hitung($request->kelas_id, $request->mapel_id, $request->semester, $request->tahun_ajaran);

        return back()->with('success', 'Seluruh nilai akhir siswa berhasil dikalkulasi ulang berdasarkan bobot terkini.');
    }
}
