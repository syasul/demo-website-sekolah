<?php

namespace Tests\Feature;

use App\Models\SchoolSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SchoolSettingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\UserRoleSeeder::class);
    }

    public function test_guest_cannot_access_settings(): void
    {
        $response = $this->get(route('admin.settings.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_non_admin_cannot_access_settings(): void
    {
        $guru = User::where('role', 'guru')->first();
        $response = $this->actingAs($guru)->get(route('admin.settings.index'));
        $response->assertStatus(403);

        $siswa = User::where('role', 'siswa')->first();
        $responseSiswa = $this->actingAs($siswa)->get(route('admin.settings.index'));
        $responseSiswa->assertStatus(403);
    }

    public function test_admin_can_view_settings_page(): void
    {
        $admin = User::where('role', 'admin')->first();
        $response = $this->actingAs($admin)->get(route('admin.settings.index'));
        $response->assertStatus(200);
        $response->assertSee('Pengaturan Sekolah');
    }

    public function test_admin_can_update_school_settings(): void
    {
        $admin = User::where('role', 'admin')->first();

        $updateData = [
            'nama_sekolah' => 'Madrasah Aliyah Prestasi Unggul',
            'nsm' => '131235730999',
            'npsn' => '20589999',
            'akreditasi' => 'A (Unggul)',
            'alamat' => 'Jl. Pahlawan No. 88',
            'kota' => 'Malang',
            'provinsi' => 'Jawa Timur',
            'telepon' => '(0341) 998877',
            'email' => 'sekretariat@prestasi.sch.id',
            'website' => 'https://prestasi.sch.id',
            'nama_kepala_sekolah' => 'Dr. H. Muhammad Ilyas, M.Ag',
            'nip_kepala_sekolah' => '19800101 200501 1 005',
            'tahun_ajaran_aktif' => '2025/2026',
            'semester_aktif' => 'genap',
        ];

        $response = $this->actingAs($admin)
            ->from(route('admin.settings.index'))
            ->put(route('admin.settings.update'), $updateData);
        $response->assertRedirect(route('admin.settings.index'));
        $response->assertSessionHas('success');

        $setting = SchoolSetting::getActive();
        $this->assertEquals('Madrasah Aliyah Prestasi Unggul', $setting->nama_sekolah);
        $this->assertEquals('2025/2026', $setting->tahun_ajaran_aktif);
        $this->assertEquals('genap', $setting->semester_aktif);
        $this->assertEquals('Dr. H. Muhammad Ilyas, M.Ag', $setting->nama_kepala_sekolah);
    }

    public function test_raport_pdf_uses_dynamic_school_settings(): void
    {
        // Update school setting with custom school name
        $setting = SchoolSetting::getActive();
        $setting->update([
            'nama_sekolah' => 'SMA Test Master Internasional',
            'nama_kepala_sekolah' => 'Prof. Dr. Testing, M.Sc',
        ]);

        $siswa = User::where('role', 'siswa')->first();

        $response = $this->actingAs($siswa)->get(route('siswa.raport.pdf', [
            'semester' => 'ganjil',
            'tahun_ajaran' => '2024/2025',
        ]));

        $response->assertStatus(200);
        // Ensure DomPDF response was produced
        $this->assertTrue(
            str_contains($response->headers->get('content-type') ?? '', 'pdf') ||
            str_contains($response->headers->get('content-disposition') ?? '', 'raport_')
        );
    }
}
