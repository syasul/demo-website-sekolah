<?php

namespace Tests\Feature;

use App\Models\GuruMapel;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuruRaportTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\UserRoleSeeder::class);
    }

    public function test_guest_cannot_access_guru_portal(): void
    {
        $response = $this->get(route('guru.dashboard'));
        $response->assertRedirect(route('login'));
    }

    public function test_siswa_cannot_access_guru_portal(): void
    {
        $siswa = User::where('role', 'siswa')->first();
        $response = $this->actingAs($siswa)->get(route('guru.dashboard'));
        $response->assertStatus(403);
    }

    public function test_guru_can_access_dashboard(): void
    {
        $guru = User::where('role', 'guru')->first();
        $response = $this->actingAs($guru)->get(route('guru.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Portal Guru');
        $response->assertSee('Progress Pengisian Nilai Raport');
    }

    public function test_guru_can_view_assigned_classes(): void
    {
        $guru = User::where('role', 'guru')->first();
        $response = $this->actingAs($guru)->get(route('guru.kelas.index'));
        $response->assertStatus(200);
        $response->assertSee('Daftar Rombongan Belajar');
        $response->assertSee('Kelas 10 A');
    }

    public function test_guru_can_input_bulk_grades(): void
    {
        $guru = User::where('role', 'guru')->first();
        $kelas = Kelas::where('tingkat', 10)->where('nama_rombel', 'A')->first();
        $mapel = MataPelajaran::where('kode_mapel', 'MTK-10')->first();
        $students = $kelas->siswas;

        $postData = [
            'kelas_id' => $kelas->id,
            'mapel_id' => $mapel->id,
            'semester' => 'ganjil',
            'tahun_ajaran' => '2025/2026',
            'nilai' => [],
        ];

        foreach ($students as $stu) {
            $postData['nilai'][$stu->id] = [
                'pengetahuan' => 88,
                'keterampilan' => 90,
                'sikap' => 'A',
                'catatan' => 'Sangat memahami materi aljabar dan fungsi.',
            ];
        }

        $response = $this->actingAs($guru)->post(route('guru.raport.store'), $postData);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('nilais', [
            'kelas_id' => $kelas->id,
            'mapel_id' => $mapel->id,
            'nilai_pengetahuan' => 88,
            'nilai_keterampilan' => 90,
            'nilai_sikap' => 'A',
        ]);
    }

    public function test_guru_cannot_grade_unassigned_class(): void
    {
        $guru = User::where('role', 'guru')->first();
        $unassignedKelas = Kelas::create(['tingkat' => 12, 'nama_rombel' => 'IPA 1']);
        $mapel = MataPelajaran::where('kode_mapel', 'MTK-10')->first();

        $response = $this->actingAs($guru)->get(route('guru.raport.create', [
            'kelas_id' => $unassignedKelas->id,
            'mapel_id' => $mapel->id,
        ]));

        $response->assertStatus(403);
    }

    public function test_locked_grades_cannot_be_edited(): void
    {
        $guru = User::where('role', 'guru')->first();
        $kelas = Kelas::where('tingkat', 10)->where('nama_rombel', 'A')->first();
        $mapel = MataPelajaran::where('kode_mapel', 'MTK-10')->first();
        $student = $kelas->siswas->first();

        // Lock grades
        $this->actingAs($guru)->post(route('guru.raport.lock'), [
            'kelas_id' => $kelas->id,
            'mapel_id' => $mapel->id,
            'semester' => 'ganjil',
            'tahun_ajaran' => '2025/2026',
        ]);

        // Attempt edit
        $response = $this->actingAs($guru)->post(route('guru.raport.store'), [
            'kelas_id' => $kelas->id,
            'mapel_id' => $mapel->id,
            'semester' => 'ganjil',
            'tahun_ajaran' => '2025/2026',
            'nilai' => [
                $student->id => [
                    'pengetahuan' => 50,
                    'keterampilan' => 50,
                    'sikap' => 'C',
                    'catatan' => 'Ubah nilai',
                ],
            ],
        ]);

        $response->assertSessionHasErrors('lock');
    }
}
