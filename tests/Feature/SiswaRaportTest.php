<?php

namespace Tests\Feature;

use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\NilaiKomponen;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiswaRaportTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $guru;
    protected User $siswa;
    protected Kelas $kelas;
    protected MataPelajaran $mapel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin@sekolah.test',
        ]);

        $this->guru = User::factory()->create([
            'role' => 'guru',
            'name' => 'Ustadz Fajar, S.Pd',
            'email' => 'fajar@sekolah.test',
        ]);

        $this->kelas = Kelas::create([
            'tingkat' => 10,
            'nama_rombel' => 'A',
            'wali_kelas_id' => $this->guru->id,
        ]);

        $this->siswa = User::factory()->create([
            'role' => 'siswa',
            'name' => 'Ahmad Santoso',
            'email' => 'ahmad@sekolah.test',
            'kelas_id' => $this->kelas->id,
        ]);

        $this->mapel = MataPelajaran::create([
            'nama_mapel' => 'Matematika Wajib',
            'kode_mapel' => 'MTK10',
            'tingkat' => 10,
            'kkm' => 75,
        ]);

        // Buat data nilai untuk siswa
        Nilai::create([
            'siswa_id' => $this->siswa->id,
            'kelas_id' => $this->kelas->id,
            'mapel_id' => $this->mapel->id,
            'guru_id' => $this->guru->id,
            'semester' => 'ganjil',
            'tahun_ajaran' => '2024/2025',
            'nilai_pengetahuan' => 84.5,
            'nilai_keterampilan' => 88.0,
            'nilai_sikap' => 'A',
            'status_remidi' => 'tidak_perlu',
            'catatan' => 'Sangat memahami materi aljabar dan geometri.',
            'is_locked' => true,
        ]);

        NilaiKomponen::create([
            'siswa_id' => $this->siswa->id,
            'kelas_id' => $this->kelas->id,
            'mapel_id' => $this->mapel->id,
            'guru_id' => $this->guru->id,
            'semester' => 'ganjil',
            'tahun_ajaran' => '2024/2025',
            'jenis' => 'tugas',
            'judul' => 'Tugas 1 Aljabar',
            'nilai' => 85,
            'tanggal' => now(),
        ]);
    }

    public function test_guest_cannot_access_siswa_dashboard(): void
    {
        $response = $this->get(route('siswa.dashboard'));
        $response->assertRedirect(route('login'));
    }

    public function test_admin_and_guru_cannot_access_siswa_dashboard(): void
    {
        $this->actingAs($this->admin)->get(route('siswa.dashboard'))->assertForbidden();
        $this->actingAs($this->guru)->get(route('siswa.dashboard'))->assertForbidden();
    }

    public function test_siswa_can_access_dashboard_and_see_summary(): void
    {
        $response = $this->actingAs($this->siswa)->get(route('siswa.dashboard'));

        $response->assertOk();
        $response->assertSee('Ahmad Santoso');
        $response->assertSee('Kelas 10 A');
        $response->assertSee('Ustadz Fajar, S.Pd');
        $response->assertSee('Matematika Wajib');
        $response->assertSee('84.5');
    }

    public function test_siswa_can_access_raport_page(): void
    {
        $response = $this->actingAs($this->siswa)->get(route('siswa.raport.index', [
            'semester' => 'Ganjil',
            'tahun_ajaran' => '2024/2025',
        ]));

        $response->assertOk();
        $response->assertSee('Buku Raport Digital');
        $response->assertSee('Matematika Wajib');
        $response->assertSee('84.5');
        $response->assertSee('88.0');
        $response->assertSee('Tugas 1 Aljabar');
    }

    public function test_siswa_can_download_raport_pdf(): void
    {
        $response = $this->actingAs($this->siswa)->get(route('siswa.raport.pdf', [
            'semester' => 'Ganjil',
            'tahun_ajaran' => '2024/2025',
        ]));

        $response->assertOk();
        $this->assertStringContainsString('application/pdf', $response->headers->get('Content-Type'));
        $this->assertStringContainsString('attachment;', $response->headers->get('Content-Disposition'));
    }

    public function test_siswa_can_preview_raport_pdf(): void
    {
        $response = $this->actingAs($this->siswa)->get(route('siswa.raport.pdf', [
            'semester' => 'Ganjil',
            'tahun_ajaran' => '2024/2025',
            'mode' => 'preview',
        ]));

        $response->assertOk();
        $this->assertStringContainsString('application/pdf', $response->headers->get('Content-Type'));
    }

    public function test_siswa_cannot_access_admin_or_guru_routes(): void
    {
        $this->actingAs($this->siswa)->get(route('admin.dashboard'))->assertForbidden();
        $this->actingAs($this->siswa)->get(route('admin.kelas.index'))->assertForbidden();
        $this->actingAs($this->siswa)->get(route('guru.dashboard'))->assertForbidden();
        $this->actingAs($this->siswa)->get(route('guru.raport.index'))->assertForbidden();
        $this->actingAs($this->siswa)->get(route('guru.nilai.tugas-uh'))->assertForbidden();
    }
}
