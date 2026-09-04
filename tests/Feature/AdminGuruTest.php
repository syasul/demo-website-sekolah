<?php

namespace Tests\Feature;

use App\Models\GuruMapel;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminGuruTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\UserRoleSeeder::class);
    }

    public function test_guest_cannot_access_guru_management(): void
    {
        $response = $this->get(route('admin.guru.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_non_admin_cannot_access_guru_management(): void
    {
        $guru = User::where('role', 'guru')->first();
        $response = $this->actingAs($guru)->get(route('admin.guru.index'));
        $response->assertStatus(403);
    }

    public function test_admin_can_view_guru_index(): void
    {
        $admin = User::where('role', 'admin')->first();
        $response = $this->actingAs($admin)->get(route('admin.guru.index'));
        $response->assertStatus(200);
        $response->assertSee('Daftar Akun Guru');
    }

    public function test_admin_can_create_new_teacher(): void
    {
        $admin = User::where('role', 'admin')->first();
        $email = 'testguru_' . uniqid() . '@sekolah.test';

        $response = $this->actingAs($admin)->post(route('admin.guru.store'), [
            'name' => 'Ustadz Ahmad Farhan, S.Pd',
            'email' => $email,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('admin.guru.index'));
        $this->assertDatabaseHas('users', [
            'name' => 'Ustadz Ahmad Farhan, S.Pd',
            'email' => $email,
            'role' => 'guru',
        ]);
    }

    public function test_admin_can_assign_mapel_and_wali_kelas(): void
    {
        $admin = User::where('role', 'admin')->first();
        $guru = User::where('role', 'guru')->first();
        $kelas = Kelas::create(['tingkat' => 10, 'nama_rombel' => 'X']);
        $mapel = MataPelajaran::create(['nama_mapel' => 'Fisika', 'kode_mapel' => 'FSK']);

        // Assign Wali Kelas
        $resWali = $this->actingAs($admin)->post(route('admin.guru.assign.wali', $guru), [
            'kelas_id' => $kelas->id,
        ]);
        $resWali->assertSessionHasNoErrors();
        $this->assertEquals($guru->id, $kelas->fresh()->wali_kelas_id);

        // Assign Mapel & Kelas
        $resAssign = $this->actingAs($admin)->post(route('admin.guru.assign.store', $guru), [
            'kelas_id' => $kelas->id,
            'mapel_id' => $mapel->id,
        ]);
        $resAssign->assertSessionHasNoErrors();
        $this->assertDatabaseHas('guru_kelas_mapel', [
            'guru_id' => $guru->id,
            'kelas_id' => $kelas->id,
            'mapel_id' => $mapel->id,
        ]);
    }
}
