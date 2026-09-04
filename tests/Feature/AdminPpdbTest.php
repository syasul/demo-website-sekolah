<?php

namespace Tests\Feature;

use App\Models\Kelas;
use App\Models\Pendaftar;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPpdbTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\UserRoleSeeder::class);
    }

    public function test_public_user_can_view_ppdb_page(): void
    {
        $response = $this->get(route('ppdb'));
        $response->assertStatus(200);
        $response->assertSee('Formulir PPDB');
    }

    public function test_public_user_can_submit_ppdb_registration(): void
    {
        $postData = [
            'nama_lengkap' => 'Salma Aulia Ramadhani',
            'nisn' => '0091122334',
            'jenis_kelamin' => 'P',
            'tempat_lahir' => 'Malang',
            'tanggal_lahir' => '2009-04-14',
            'asal_sekolah' => 'SMP Negeri 1 Malang',
            'nama_orang_tua' => 'Ahmad Suprayogi',
            'no_hp' => '081234998877',
            'alamat' => 'Jl. Kawi No. 10 Malang',
        ];

        $response = $this->post(route('ppdb.store'), $postData);
        $response->assertSessionHas('ppdb_success');

        $this->assertDatabaseHas('pendaftars', [
            'nama_lengkap' => 'Salma Aulia Ramadhani',
            'nisn' => '0091122334',
            'status' => 'pending',
            'is_converted' => false,
        ]);
    }

    public function test_applicant_can_check_ppdb_status(): void
    {
        $pendaftar = Pendaftar::first();

        // Search by registration number using 'keyword' parameter
        $response = $this->get(route('ppdb.status', ['keyword' => $pendaftar->nomor_pendaftaran]));
        $response->assertStatus(200);
        $response->assertSee($pendaftar->nama_lengkap);
    }

    public function test_admin_can_view_ppdb_index(): void
    {
        $admin = User::where('role', 'admin')->first();
        $response = $this->actingAs($admin)->get(route('admin.ppdb.index'));
        $response->assertStatus(200);
        $response->assertSee('Data Pendaftar PPDB');
    }

    public function test_admin_can_update_ppdb_status(): void
    {
        $admin = User::where('role', 'admin')->first();
        $pendaftar = Pendaftar::where('status', 'pending')->first();

        $response = $this->actingAs($admin)
            ->patch(route('admin.ppdb.update-status', $pendaftar), [
                'status' => 'diterima',
                'catatan_admin' => 'Berkas pendaftaran telah diverifikasi dan dinyatakan lulus seleksi.',
            ]);

        $response->assertSessionHasNoErrors();
        $this->assertEquals('diterima', $pendaftar->fresh()->status);
        $this->assertStringContainsString('dinyatakan lulus', $pendaftar->fresh()->catatan_admin);
    }

    public function test_admin_can_convert_accepted_applicant_to_student(): void
    {
        $admin = User::where('role', 'admin')->first();
        $kelas = Kelas::first();

        // Ensure we have an accepted applicant
        $pendaftar = Pendaftar::where('status', 'diterima')->where('is_converted', false)->first();

        $convertData = [
            'kelas_id' => $kelas->id,
            'nis' => '8881',
        ];

        $response = $this->actingAs($admin)
            ->post(route('admin.ppdb.konversi', $pendaftar), $convertData);

        $response->assertRedirect(route('admin.siswa.index'));
        $response->assertSessionHas('success');

        // Check user created with auto-generated email
        $this->assertDatabaseHas('users', [
            'email' => 'siswa.8881@attaraqqie.sch.id',
            'role' => 'siswa',
            'kelas_id' => $kelas->id,
        ]);

        // Check siswa created
        $this->assertDatabaseHas('siswas', [
            'nis' => '8881',
            'kelas_id' => $kelas->id,
        ]);

        // Check pendaftar marked converted
        $pendaftarFresh = $pendaftar->fresh();
        $this->assertTrue((bool)$pendaftarFresh->is_converted);
        $this->assertNotNull($pendaftarFresh->user_id);
    }
}
