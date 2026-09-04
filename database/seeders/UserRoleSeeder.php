<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@sekolah.test'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        $guru = User::updateOrCreate(
            ['email' => 'guru@sekolah.test'],
            [
                'name' => 'Guru Demo, S.Pd',
                'password' => Hash::make('password'),
                'role' => 'guru',
            ]
        );

        $kelas = \App\Models\Kelas::firstOrCreate(
            ['tingkat' => 10, 'nama_rombel' => 'A'],
            ['wali_kelas_id' => $guru->id]
        );
        $kelas->update(['wali_kelas_id' => $guru->id]);

        $mapelMtk = \App\Models\MataPelajaran::firstOrCreate(
            ['kode_mapel' => 'MTK-10'],
            ['nama_mapel' => 'Matematika Wajib', 'tingkat' => '10', 'kkm' => 75]
        );

        $mapelIndo = \App\Models\MataPelajaran::firstOrCreate(
            ['kode_mapel' => 'BIN-10'],
            ['nama_mapel' => 'Bahasa Indonesia', 'tingkat' => '10', 'kkm' => 75]
        );

        $mapelIng = \App\Models\MataPelajaran::firstOrCreate(
            ['kode_mapel' => 'BIG-10'],
            ['nama_mapel' => 'Bahasa Inggris', 'tingkat' => '10', 'kkm' => 75]
        );

        $mapelPai = \App\Models\MataPelajaran::firstOrCreate(
            ['kode_mapel' => 'PAI-10'],
            ['nama_mapel' => 'Pendidikan Agama Islam', 'tingkat' => '10', 'kkm' => 80]
        );

        \App\Models\GuruMapel::firstOrCreate([
            'guru_id' => $guru->id,
            'kelas_id' => $kelas->id,
            'mapel_id' => $mapelMtk->id,
        ]);

        \App\Models\GuruMapel::firstOrCreate([
            'guru_id' => $guru->id,
            'kelas_id' => $kelas->id,
            'mapel_id' => $mapelIndo->id,
        ]);

        $students = [
            ['email' => 'siswa@sekolah.test', 'name' => 'Siswa Demo', 'nis' => '1001', 'nisn' => '0071234501', 'jk' => 'L'],
            ['email' => 'rizky@sekolah.test', 'name' => 'Muhammad Rizky Pratama', 'nis' => '1002', 'nisn' => '0071234502', 'jk' => 'L'],
            ['email' => 'aisyah@sekolah.test', 'name' => 'Aisyah Nur Salsabila', 'nis' => '1003', 'nisn' => '0071234503', 'jk' => 'P'],
            ['email' => 'fajar@sekolah.test', 'name' => 'Fajar Ramadhan', 'nis' => '1004', 'nisn' => '0071234504', 'jk' => 'L'],
            ['email' => 'nabila@sekolah.test', 'name' => 'Nabila Zahra Kirana', 'nis' => '1005', 'nisn' => '0071234505', 'jk' => 'P'],
        ];

        $studentModels = [];
        foreach ($students as $stu) {
            $user = User::updateOrCreate(
                ['email' => $stu['email']],
                [
                    'name' => $stu['name'],
                    'password' => Hash::make('password'),
                    'role' => 'siswa',
                    'kelas_id' => $kelas->id,
                ]
            );
            $studentModels[] = $user;

            \App\Models\Siswa::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nis' => $stu['nis'],
                    'nisn' => $stu['nisn'],
                    'kelas_id' => $kelas->id,
                    'jenis_kelamin' => $stu['jk'],
                    'tempat_lahir' => 'Jakarta',
                    'tanggal_lahir' => '2008-05-15',
                    'alamat' => 'Jl. Merdeka No. 12, Jakarta',
                    'nama_orang_tua' => 'Wali Murid ' . $stu['name'],
                    'no_hp_orang_tua' => '081298765432',
                    'status' => 'aktif',
                ]
            );
        }

        // Seed Pengaturan Sekolah
        \App\Models\SchoolSetting::updateOrCreate(
            ['id' => 1],
            [
                'nama_sekolah' => 'SMA Garuda Nusantara',
                'npsn' => '20108921',
                'alamat' => 'Jl. Pendidikan No. 45, Kebayoran Baru, Jakarta Selatan',
                'email' => 'info@smagaruda.sch.id',
                'telepon' => '(021) 7890123',
                'website' => 'www.smagaruda.sch.id',
                'nama_kepala_sekolah' => 'Dr. H. Bambang Sudarmanto, M.Pd',
                'nip_kepala_sekolah' => '19750812 200003 1 002',
                'tahun_ajaran_aktif' => '2024/2025',
                'semester_aktif' => 'ganjil',
            ]
        );

        // Seed Sample PPDB Pendaftar
        \App\Models\Pendaftar::updateOrCreate(
            ['nomor_pendaftaran' => 'PPDB-2025-0001'],
            [
                'nama_lengkap' => 'Budi Santoso',
                'nisn' => '0089876541',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2009-03-21',
                'asal_sekolah' => 'SMP Negeri 1 Jakarta',
                'alamat' => 'Jl. Tebet Barat No. 8, Jakarta Selatan',
                'nama_orang_tua' => 'Santoso Joko',
                'no_hp' => '081311223344',
                'status' => 'pending',
            ]
        );

        \App\Models\Pendaftar::updateOrCreate(
            ['nomor_pendaftaran' => 'PPDB-2025-0002'],
            [
                'nama_lengkap' => 'Citra Dewi Lestari',
                'nisn' => '0089876542',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2009-07-11',
                'asal_sekolah' => 'SMP Negeri 5 Jakarta',
                'alamat' => 'Jl. Radio Dalam No. 15, Jakarta Selatan',
                'nama_orang_tua' => 'Lestari Handayani',
                'no_hp' => '081355667788',
                'status' => 'diterima',
                'catatan_admin' => 'Memenuhi persyaratan nilai rapor dan berkas lengkap.',
            ]
        );

        \App\Models\Pendaftar::updateOrCreate(
            ['nomor_pendaftaran' => 'PPDB-2025-0003'],
            [
                'nama_lengkap' => 'Doni Kusuma',
                'nisn' => '0089876543',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Bogor',
                'tanggal_lahir' => '2009-01-05',
                'asal_sekolah' => 'SMP Swasta Teladan',
                'alamat' => 'Jl. Fatmawati No. 20, Jakarta Selatan',
                'nama_orang_tua' => 'Kusuma Wardhana',
                'no_hp' => '081399887766',
                'status' => 'ditolak',
                'catatan_admin' => 'Dokumen KK dan SKL tidak terverifikasi.',
            ]
        );

        // Seed Sample Articles
        $adminUser = User::where('email', 'admin@sekolah.test')->first();
        if ($adminUser && \App\Models\Article::count() == 0) {
            \App\Models\Article::create([
                'title' => 'Penerimaan Peserta Didik Baru (PPDB) Tahun Ajaran 2025/2026 Resmi Dibuka',
                'slug' => 'penerimaan-peserta-didik-baru-ppdb-tahun-ajaran-2025-2026-resmi-dibuka',
                'content' => 'SMA Garuda Nusantara secara resmi membuka pendaftaran peserta didik baru untuk tahun ajaran 2025/2026. Calon siswa dapat mendaftar secara online melalui menu PPDB di website ini.',
                'category' => 'Pengumuman',
                'author_id' => $adminUser->id,
            ]);
            \App\Models\Article::create([
                'title' => 'Siswa SMA Garuda Nusantara Meraih Medali Emas Olimpiade Sains Nasional',
                'slug' => 'siswa-sma-garuda-nusantara-meraih-medali-emas-olimpiade-sains-nasional',
                'content' => 'Prestasi membanggakan kembali ditorehkan oleh perwakilan siswa SMA Garuda Nusantara pada ajang Olimpiade Sains Nasional (OSN) bidang Matematika dan Fisika.',
                'category' => 'Prestasi',
                'author_id' => $adminUser->id,
            ]);
        }

        // Seed Pengaturan Bobot Penilaian
        \App\Models\PengaturanBobot::firstOrCreate(['jenis' => 'tugas'], ['bobot_persen' => 20]);
        \App\Models\PengaturanBobot::firstOrCreate(['jenis' => 'uh'], ['bobot_persen' => 30]);
        \App\Models\PengaturanBobot::firstOrCreate(['jenis' => 'uts'], ['bobot_persen' => 20]);
        \App\Models\PengaturanBobot::firstOrCreate(['jenis' => 'uas'], ['bobot_persen' => 30]);

        // Seed sample grades for Siswa Demo
        $siswaDemo = $studentModels[0];
        $sampleGrades = [
            [
                'mapel_id' => $mapelMtk->id,
                'p' => 86.5,
                'k' => 88.0,
                's' => 'A',
                'catatan' => 'Sangat aktif dalam pemecahan soal logika aljabar.',
            ],
            [
                'mapel_id' => $mapelIndo->id,
                'p' => 84.0,
                'k' => 85.0,
                's' => 'A',
                'catatan' => 'Kemampuan literasi dan penulisan karya ilmiah sangat baik.',
            ],
            [
                'mapel_id' => $mapelIng->id,
                'p' => 80.0,
                'k' => 82.0,
                's' => 'B',
                'catatan' => 'Percakapan bahasa Inggris lancar dan komunikatif.',
            ],
            [
                'mapel_id' => $mapelPai->id,
                'p' => 92.0,
                'k' => 90.0,
                's' => 'A',
                'catatan' => 'Pemahaman akidah akhlak dan hafalan Al-Qur\'an istiqomah.',
            ],
        ];

        foreach ($sampleGrades as $sg) {
            \App\Models\Nilai::updateOrCreate(
                [
                    'siswa_id' => $siswaDemo->id,
                    'kelas_id' => $kelas->id,
                    'mapel_id' => $sg['mapel_id'],
                    'semester' => 'ganjil',
                    'tahun_ajaran' => '2024/2025',
                ],
                [
                    'guru_id' => $guru->id,
                    'nilai_pengetahuan' => $sg['p'],
                    'nilai_keterampilan' => $sg['k'],
                    'nilai_sikap' => $sg['s'],
                    'status_remidi' => 'tidak_perlu',
                    'catatan' => $sg['catatan'],
                    'is_locked' => false,
                ]
            );

            \App\Models\NilaiKomponen::updateOrCreate(
                [
                    'siswa_id' => $siswaDemo->id,
                    'kelas_id' => $kelas->id,
                    'mapel_id' => $sg['mapel_id'],
                    'semester' => 'ganjil',
                    'tahun_ajaran' => '2024/2025',
                    'jenis' => 'tugas',
                    'judul' => 'Tugas Mandiri 1',
                ],
                [
                    'guru_id' => $guru->id,
                    'nilai' => $sg['p'] + 2,
                    'tanggal' => now()->subDays(10),
                ]
            );

            \App\Models\NilaiKomponen::updateOrCreate(
                [
                    'siswa_id' => $siswaDemo->id,
                    'kelas_id' => $kelas->id,
                    'mapel_id' => $sg['mapel_id'],
                    'semester' => 'ganjil',
                    'tahun_ajaran' => '2024/2025',
                    'jenis' => 'uh',
                    'judul' => 'Ulangan Harian 1',
                ],
                [
                    'guru_id' => $guru->id,
                    'nilai' => $sg['p'] - 1,
                    'tanggal' => now()->subDays(5),
                ]
            );
        }
    }
}
