<?php

namespace Tests\Feature;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminSiswaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\UserRoleSeeder::class);
    }

    public function test_guest_cannot_access_siswa_management(): void
    {
        $response = $this->get(route('admin.siswa.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_non_admin_cannot_access_siswa_management(): void
    {
        $guru = User::where('role', 'guru')->first();
        $response = $this->actingAs($guru)->get(route('admin.siswa.index'));
        $response->assertStatus(403);

        $siswa = User::where('role', 'siswa')->first();
        $responseSiswa = $this->actingAs($siswa)->get(route('admin.siswa.index'));
        $responseSiswa->assertStatus(403);
    }

    public function test_admin_can_view_siswa_index(): void
    {
        $admin = User::where('role', 'admin')->first();
        $response = $this->actingAs($admin)->get(route('admin.siswa.index'));
        $response->assertStatus(200);
        $response->assertSee('Manajemen Data Siswa');
    }

    public function test_admin_can_create_siswa_manually(): void
    {
        $admin = User::where('role', 'admin')->first();
        $kelas = Kelas::first();

        $postData = [
            'name' => 'Ahmad Dahlan',
            'email' => 'dahlan@sekolah.test',
            'nis' => '9901',
            'nisn' => '0098765432',
            'kelas_id' => $kelas->id,
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Yogyakarta',
            'tanggal_lahir' => '2008-08-01',
            'alamat' => 'Jl. Kauman No. 1',
            'nama_orang_tua' => 'Kyai Dahlan',
            'no_hp_orang_tua' => '081234567890',
            'status' => 'aktif',
        ];

        $response = $this->actingAs($admin)->post(route('admin.siswa.store'), $postData);
        $response->assertRedirect(route('admin.siswa.index'));

        $this->assertDatabaseHas('users', [
            'name' => 'Ahmad Dahlan',
            'email' => 'dahlan@sekolah.test',
            'role' => 'siswa',
            'kelas_id' => $kelas->id,
        ]);

        $this->assertDatabaseHas('siswas', [
            'nis' => '9901',
            'nisn' => '0098765432',
            'kelas_id' => $kelas->id,
            'jenis_kelamin' => 'L',
            'status' => 'aktif',
        ]);
    }

    public function test_admin_can_update_siswa(): void
    {
        $admin = User::where('role', 'admin')->first();
        $siswa = Siswa::with('user')->first();

        $updateData = [
            'name' => 'Nama Siswa Terupdate',
            'email' => $siswa->user->email,
            'nis' => $siswa->nis,
            'nisn' => '0011223344',
            'kelas_id' => $siswa->kelas_id,
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '2008-01-01',
            'alamat' => 'Alamat Baru',
            'nama_orang_tua' => 'Orang Tua Baru',
            'no_hp_orang_tua' => '081999888777',
            'status' => 'aktif',
        ];

        $response = $this->actingAs($admin)->put(route('admin.siswa.update', $siswa), $updateData);
        $response->assertRedirect(route('admin.siswa.index'));

        $this->assertDatabaseHas('users', [
            'id' => $siswa->user_id,
            'name' => 'Nama Siswa Terupdate',
        ]);

        $this->assertDatabaseHas('siswas', [
            'id' => $siswa->id,
            'nisn' => '0011223344',
            'tempat_lahir' => 'Surabaya',
        ]);
    }

    public function test_admin_can_soft_delete_siswa(): void
    {
        $admin = User::where('role', 'admin')->first();
        $siswa = Siswa::first();

        $response = $this->actingAs($admin)->delete(route('admin.siswa.destroy', $siswa));
        $response->assertRedirect(route('admin.siswa.index'));

        $this->assertSoftDeleted('siswas', [
            'id' => $siswa->id,
        ]);
    }

    public function test_admin_can_reset_siswa_password(): void
    {
        $admin = User::where('role', 'admin')->first();
        $siswa = Siswa::with('user')->first();

        $response = $this->actingAs($admin)
            ->from(route('admin.siswa.index'))
            ->post(route('admin.siswa.reset-password', $siswa));

        $response->assertRedirect(route('admin.siswa.index'));

        $user = $siswa->user->fresh();
        $this->assertTrue(Hash::check($siswa->nis, $user->password));
    }

    public function test_admin_can_download_import_template(): void
    {
        \Maatwebsite\Excel\Facades\Excel::fake();

        $admin = User::where('role', 'admin')->first();
        $response = $this->actingAs($admin)->get(route('admin.siswa.template'));
        $response->assertStatus(200);

        \Maatwebsite\Excel\Facades\Excel::assertDownloaded('template_import_siswa.xlsx');
    }

    public function test_admin_can_export_siswa_excel(): void
    {
        \Maatwebsite\Excel\Facades\Excel::fake();

        $admin = User::where('role', 'admin')->first();
        $response = $this->actingAs($admin)->get(route('admin.siswa.export'));
        $response->assertStatus(200);

        \Maatwebsite\Excel\Facades\Excel::assertDownloaded('data_siswa_' . date('Y-m-d') . '.xlsx');
    }
}
