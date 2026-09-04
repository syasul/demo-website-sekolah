<?php

namespace Tests\Feature;

use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\NilaiKomponen;
use App\Models\PengaturanBobot;
use App\Models\User;
use App\Services\HitungNilaiAkhirService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuruKomponenNilaiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\UserRoleSeeder::class);
    }

    public function test_guru_can_create_tugas_session_and_record_scores(): void
    {
        $guru = User::where('role', 'guru')->first();
        $kelas = Kelas::where('tingkat', 10)->where('nama_rombel', 'A')->first();
        $mapel = MataPelajaran::where('kode_mapel', 'MTK-10')->first();
        $student = $kelas->siswas->first();

        $response = $this->actingAs($guru)->post(route('guru.nilai.tugas-uh.store'), [
            'kelas_id' => $kelas->id,
            'mapel_id' => $mapel->id,
            'semester' => 'ganjil',
            'tahun_ajaran' => '2025/2026',
            'jenis' => 'tugas',
            'judul' => 'Tugas 1 Aljabar',
            'tanggal' => '2026-09-01',
            'nilai' => [
                $student->id => 85,
            ],
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('nilai_komponens', [
            'siswa_id' => $student->id,
            'kelas_id' => $kelas->id,
            'mapel_id' => $mapel->id,
            'jenis' => 'tugas',
            'judul' => 'Tugas 1 Aljabar',
            'nilai' => 85,
        ]);
    }

    public function test_system_detects_student_below_kkm_for_remedial(): void
    {
        $guru = User::where('role', 'guru')->first();
        $kelas = Kelas::where('tingkat', 10)->where('nama_rombel', 'A')->first();
        $mapel = MataPelajaran::where('kode_mapel', 'MTK-10')->first(); // KKM = 75
        $student = $kelas->siswas->first();

        // Input UH with score 60 (below KKM 75)
        $this->actingAs($guru)->post(route('guru.nilai.tugas-uh.store'), [
            'kelas_id' => $kelas->id,
            'mapel_id' => $mapel->id,
            'semester' => 'ganjil',
            'tahun_ajaran' => '2025/2026',
            'jenis' => 'uh',
            'judul' => 'UH 1 Eksponen',
            'tanggal' => '2026-09-02',
            'nilai' => [
                $student->id => 60,
            ],
        ]);

        // Access Remedial page
        $resRemidi = $this->actingAs($guru)->get(route('guru.nilai.remidi', [
            'kelas_id' => $kelas->id,
            'mapel_id' => $mapel->id,
        ]));

        $resRemidi->assertStatus(200);
        $resRemidi->assertSee('UH 1 Eksponen');
        $resRemidi->assertSee('Perlu Remidi');

        // Verify status_remidi in Nilai record is 'perlu'
        $nilai = Nilai::where('siswa_id', $student->id)
            ->where('mapel_id', $mapel->id)
            ->where('tahun_ajaran', '2025/2026')
            ->first();
        $this->assertEquals('perlu', $nilai->status_remidi);
    }

    public function test_remedial_score_is_capped_at_kkm_and_recalculates(): void
    {
        $guru = User::where('role', 'guru')->first();
        $kelas = Kelas::where('tingkat', 10)->where('nama_rombel', 'A')->first();
        $mapel = MataPelajaran::where('kode_mapel', 'MTK-10')->first(); // KKM = 75
        $student = $kelas->siswas->first();

        // Create initial UH with score 50
        $uh = NilaiKomponen::create([
            'siswa_id' => $student->id,
            'kelas_id' => $kelas->id,
            'mapel_id' => $mapel->id,
            'guru_id' => $guru->id,
            'semester' => 'ganjil',
            'tahun_ajaran' => '2025/2026',
            'jenis' => 'uh',
            'judul' => 'UH 1 Matriks',
            'nilai' => 50,
            'tanggal' => '2026-09-03',
        ]);

        // Input remedial score 90 (higher than KKM 75)
        $resStore = $this->actingAs($guru)->post(route('guru.nilai.remidi.store'), [
            'uh_id' => $uh->id,
            'nilai_remidi' => 90,
        ]);

        $resStore->assertSessionHasNoErrors();
        $this->assertDatabaseHas('nilai_komponens', [
            'komponen_asal_id' => $uh->id,
            'jenis' => 'remidi',
            'nilai' => 90,
        ]);

        // After calculation, the effective UH score should be capped at KKM (75)
        $nilai = Nilai::where('siswa_id', $student->id)
            ->where('mapel_id', $mapel->id)
            ->where('tahun_ajaran', '2025/2026')
            ->first();
        $this->assertEquals(75, $nilai->nilai_pengetahuan);
        $this->assertEquals('sudah_remidi', $nilai->status_remidi);
    }

    public function test_weighted_final_grade_calculation_is_accurate(): void
    {
        $guru = User::where('role', 'guru')->first();
        $kelas = Kelas::where('tingkat', 10)->where('nama_rombel', 'A')->first();
        $mapel = MataPelajaran::where('kode_mapel', 'MTK-10')->first();
        $student = $kelas->siswas->first();

        // Tugas: 80 (Bobot 20% -> 16)
        NilaiKomponen::create([
            'siswa_id' => $student->id,
            'kelas_id' => $kelas->id,
            'mapel_id' => $mapel->id,
            'guru_id' => $guru->id,
            'semester' => 'ganjil',
            'tahun_ajaran' => '2025/2026',
            'jenis' => 'tugas',
            'judul' => 'Tugas 1',
            'nilai' => 80,
        ]);

        // UH: 90 (Bobot 30% -> 27)
        NilaiKomponen::create([
            'siswa_id' => $student->id,
            'kelas_id' => $kelas->id,
            'mapel_id' => $mapel->id,
            'guru_id' => $guru->id,
            'semester' => 'ganjil',
            'tahun_ajaran' => '2025/2026',
            'jenis' => 'uh',
            'judul' => 'UH 1',
            'nilai' => 90,
        ]);

        // UTS: 80 (Bobot 20% -> 16)
        NilaiKomponen::create([
            'siswa_id' => $student->id,
            'kelas_id' => $kelas->id,
            'mapel_id' => $mapel->id,
            'guru_id' => $guru->id,
            'semester' => 'ganjil',
            'tahun_ajaran' => '2025/2026',
            'jenis' => 'uts',
            'judul' => 'UTS',
            'nilai' => 80,
        ]);

        // UAS: 80 (Bobot 30% -> 24)
        NilaiKomponen::create([
            'siswa_id' => $student->id,
            'kelas_id' => $kelas->id,
            'mapel_id' => $mapel->id,
            'guru_id' => $guru->id,
            'semester' => 'ganjil',
            'tahun_ajaran' => '2025/2026',
            'jenis' => 'uas',
            'judul' => 'UAS',
            'nilai' => 80,
        ]);

        // Expected final = 16 + 27 + 16 + 24 = 83.0
        HitungNilaiAkhirService::hitung($kelas->id, $mapel->id, 'ganjil', '2025/2026', $student->id);

        $nilai = Nilai::where('siswa_id', $student->id)
            ->where('mapel_id', $mapel->id)
            ->where('tahun_ajaran', '2025/2026')
            ->first();
        $this->assertEquals(83.0, $nilai->nilai_pengetahuan);
        $this->assertEquals('tidak_perlu', $nilai->status_remidi);
    }
}
