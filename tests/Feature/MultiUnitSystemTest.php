<?php

namespace Tests\Feature;

use App\Models\AbsensiGuru;
use App\Models\Jenjang;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Notifikasi;
use App\Models\Siswa;
use App\Models\Unit;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\MultiUnitSeeder;
use Database\Seeders\UserRoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MultiUnitSystemTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(UserRoleSeeder::class);
        $this->seed(MultiUnitSeeder::class);
    }

    /**
     * Uji Admin Global dapat mengganti unit aktif di session.
     */
    public function test_admin_global_can_switch_context(): void
    {
        $adminGlobal = User::where('admin_level', 'global')->first();
        $unitPutra = Unit::where('gender', 'putra')->first();

        $response = $this->actingAs($adminGlobal)->post(route('admin.switch-unit'), [
            'unit_id' => $unitPutra->id,
            'jenjang_id' => $unitPutra->jenjang_id,
        ]);

        $response->assertSessionHas('active_unit_id', $unitPutra->id);
        $response->assertSessionHas('active_jenjang_id', $unitPutra->jenjang_id);
    }

    /**
     * Uji Admin Putra terisolasi dan tidak bisa melihat data unit Putri.
     */
    public function test_admin_putra_is_isolated_from_putri_data(): void
    {
        $adminPutra = User::where('email', 'admin.putra@demo')->first();
        $unitPutri = Unit::where('gender', 'putri')->first();

        $response = $this->actingAs($adminPutra)->get(route('admin.dashboard'));
        $response->assertStatus(200);

        // Siswa di unit putri tidak boleh muncul di daftar admin putra
        $siswaPutri = Siswa::where('unit_id', $unitPutri->id)->first();
        if ($siswaPutri) {
            $siswaResponse = $this->actingAs($adminPutra)->get(route('admin.siswa.index'));
            $siswaResponse->assertDontSee($siswaPutri->user->name);
        }
    }

    /**
     * Uji Gate Jurnal: Guru belum absen masuk -> form jurnal terkunci.
     */
    public function test_guru_cannot_submit_jurnal_before_check_in(): void
    {
        $guru = User::where('role', 'guru')->first();
        $today = Carbon::today()->toDateString();

        // Pastikan belum ada absensi guru hari ini
        AbsensiGuru::where('guru_id', $guru->id)->whereDate('tanggal', $today)->delete();

        $kelas = Kelas::first();
        $mapel = MataPelajaran::first();

        $response = $this->actingAs($guru)->post(route('guru.jurnal.store'), [
            'kelas_id' => $kelas->id,
            'mapel_id' => $mapel->id,
            'tanggal' => $today,
            'materi' => 'Uji Materi Gate Absen',
        ]);

        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('jurnals', [
            'guru_id' => $guru->id,
            'materi' => 'Uji Materi Gate Absen',
        ]);
    }

    /**
     * Uji Gate Jurnal: Setelah guru check-in -> jurnal dapat disimpan.
     */
    public function test_guru_can_submit_jurnal_after_check_in(): void
    {
        $guru = User::where('role', 'guru')->first();
        $today = Carbon::today()->toDateString();

        // Guru melakukan check in
        $checkInResponse = $this->actingAs($guru)->post(route('guru.absen-masuk'));
        $checkInResponse->assertSessionHas('success');

        $this->assertDatabaseHas('absensi_gurus', [
            'guru_id' => $guru->id,
            'status' => 'hadir',
        ]);

        $kelas = Kelas::first();
        $mapel = MataPelajaran::first();

        // Sekarang guru menyimpan jurnal
        $jurnalResponse = $this->actingAs($guru)->post(route('guru.jurnal.store'), [
            'kelas_id' => $kelas->id,
            'mapel_id' => $mapel->id,
            'tanggal' => $today,
            'materi' => 'Materi Setelah Absen Masuk Berhasil',
        ]);

        $jurnalResponse->assertSessionHas('success');
        $this->assertDatabaseHas('jurnals', [
            'guru_id' => $guru->id,
            'materi' => 'Materi Setelah Absen Masuk Berhasil',
        ]);
    }

    /**
     * Uji Portal Orang Tua dapat diakses dan switch ananda berfungsi.
     */
    public function test_orang_tua_portal_and_child_switcher(): void
    {
        $parent = User::where('email', 'ortu@demo')->first();
        $this->assertNotNull($parent);

        $response = $this->actingAs($parent)->get(route('orang-tua.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Portal Wali Santri');

        $anaks = $parent->anaks;
        $this->assertGreaterThanOrEqual(2, $anaks->count());

        $anakKedua = $anaks->get(1);

        $switchResponse = $this->actingAs($parent)->post(route('orang-tua.switch-anak', $anakKedua->id));
        $switchResponse->assertSessionHas('active_anak_id', $anakKedua->id);

        // Cek halaman absensi, raport, poin, tagihan
        $this->actingAs($parent)->get(route('orang-tua.absensi.index'))->assertStatus(200);
        $this->actingAs($parent)->get(route('orang-tua.raport.index'))->assertStatus(200);
        $this->actingAs($parent)->get(route('orang-tua.poin.index'))->assertStatus(200);
        $this->actingAs($parent)->get(route('orang-tua.tagihan.index'))->assertStatus(200);
    }

    /**
     * Uji Presensi Siswa memicu Notifikasi ke Akun Orang Tua.
     */
    public function test_absensi_siswa_creates_notification_for_parent(): void
    {
        $guru = User::where('role', 'guru')->first();
        $parent = User::where('email', 'ortu@demo')->first();
        $anak = $parent->anaks->first();
        $kelas = $anak->siswa->kelas;
        $today = Carbon::today()->toDateString();

        $beforeCount = Notifikasi::where('user_id', $parent->id)->count();

        $this->actingAs($guru)->post(route('guru.absensi.siswa.store'), [
            'kelas_id' => $kelas->id,
            'tanggal' => $today,
            'absensi' => [
                $anak->id => [
                    'status' => 'sakit',
                    'keterangan' => 'Demam flu butuh istirahat',
                ],
            ],
        ]);

        $afterCount = Notifikasi::where('user_id', $parent->id)->count();
        $this->assertGreaterThan($beforeCount, $afterCount);
        $this->assertDatabaseHas('notifikasis', [
            'user_id' => $parent->id,
            'tipe' => 'absen',
        ]);
    }
}
