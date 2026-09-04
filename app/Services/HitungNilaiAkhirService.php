<?php

namespace App\Services;

use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\NilaiKomponen;
use App\Models\PengaturanBobot;

class HitungNilaiAkhirService
{
    /**
     * Hitung dan update nilai akhir untuk satu siswa atau seluruh siswa dalam kelas & mapel.
     */
    public static function hitung(int $kelasId, int $mapelId, string $semester, string $tahunAjaran, ?int $siswaId = null): void
    {
        $mapel = MataPelajaran::find($mapelId);
        $kkm = $mapel->kkm ?? 75;
        $bobots = PengaturanBobot::getBobotArray();

        $query = NilaiKomponen::where('kelas_id', $kelasId)
            ->where('mapel_id', $mapelId)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahunAjaran);

        if ($siswaId) {
            $siswaIds = [$siswaId];
        } else {
            $siswaIds = Kelas::find($kelasId)->siswas()->pluck('users.id')->toArray();
        }

        foreach ($siswaIds as $sId) {
            $komponens = NilaiKomponen::where('siswa_id', $sId)
                ->where('kelas_id', $kelasId)
                ->where('mapel_id', $mapelId)
                ->where('semester', $semester)
                ->where('tahun_ajaran', $tahunAjaran)
                ->get();

            if ($komponens->isEmpty()) {
                continue;
            }

            // 1. Hitung Rata-rata Tugas
            $tugasList = $komponens->where('jenis', 'tugas');
            $avgTugas = $tugasList->isNotEmpty() ? $tugasList->avg('nilai') : null;

            // 2. Hitung Rata-rata UH (memperhitungkan remidi)
            $uhList = $komponens->where('jenis', 'uh');
            $hasRemidiTaken = false;
            $needsRemidi = false;

            $uhScores = [];
            foreach ($uhList as $uh) {
                // Cek apakah ada nilai remidi untuk UH ini
                $remidi = $komponens->where('jenis', 'remidi')->where('komponen_asal_id', $uh->id)->first();
                if ($remidi) {
                    $hasRemidiTaken = true;
                    // Nilai remidi menggantikan nilai lama, dibatasi maksimal KKM
                    $uhScores[] = min($kkm, $remidi->nilai);
                } else {
                    $uhScores[] = $uh->nilai;
                    if ($uh->nilai < $kkm) {
                        $needsRemidi = true;
                    }
                }
            }
            $avgUh = !empty($uhScores) ? (array_sum($uhScores) / count($uhScores)) : null;

            // 3. UTS & UAS
            $uts = $komponens->where('jenis', 'uts')->first();
            $valUts = $uts ? $uts->nilai : null;

            $uas = $komponens->where('jenis', 'uas')->first();
            $valUas = $uas ? $uas->nilai : null;

            // 4. Kalkulasi Pembobotan
            $totalBobotTerisi = 0;
            $totalNilaiBobot = 0;

            if ($avgTugas !== null) {
                $b = $bobots['tugas'] ?? 20;
                $totalNilaiBobot += ($avgTugas * $b);
                $totalBobotTerisi += $b;
            }

            if ($avgUh !== null) {
                $b = $bobots['uh'] ?? 30;
                $totalNilaiBobot += ($avgUh * $b);
                $totalBobotTerisi += $b;
            }

            if ($valUts !== null) {
                $b = $bobots['uts'] ?? 20;
                $totalNilaiBobot += ($valUts * $b);
                $totalBobotTerisi += $b;
            }

            if ($valUas !== null) {
                $b = $bobots['uas'] ?? 30;
                $totalNilaiBobot += ($valUas * $b);
                $totalBobotTerisi += $b;
            }

            $nilaiPengetahuan = null;
            if ($totalBobotTerisi > 0) {
                $nilaiPengetahuan = round($totalNilaiBobot / $totalBobotTerisi, 1);
            }

            // 5. Tentukan Status Remidi
            $statusRemidi = 'tidak_perlu';
            if ($needsRemidi || ($nilaiPengetahuan !== null && $nilaiPengetahuan < $kkm)) {
                $statusRemidi = $hasRemidiTaken ? 'sudah_remidi' : 'perlu';
            } elseif ($hasRemidiTaken) {
                $statusRemidi = 'sudah_remidi';
            }

            // Update ke tabel nilais
            $guruId = $komponens->first()->guru_id ?? auth()->id();

            $record = Nilai::firstOrNew([
                'siswa_id' => $sId,
                'kelas_id' => $kelasId,
                'mapel_id' => $mapelId,
                'semester' => $semester,
                'tahun_ajaran' => $tahunAjaran,
            ]);

            if (!$record->is_locked) {
                $record->guru_id = $guruId;
                $record->nilai_pengetahuan = $nilaiPengetahuan;
                $record->status_remidi = $statusRemidi;
                $record->save();
            }
        }
    }
}
