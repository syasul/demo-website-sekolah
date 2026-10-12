<?php

namespace Database\Seeders;

use App\Models\AbsensiGuru;
use App\Models\AbsensiSiswa;
use App\Models\EvaluasiGuru;
use App\Models\GuruMapel;
use App\Models\InstrumenPenilaian;
use App\Models\Jadwal;
use App\Models\Jenjang;
use App\Models\Jurnal;
use App\Models\KategoriPoin;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\NilaiKomponen;
use App\Models\Notifikasi;
use App\Models\Pendaftar;
use App\Models\PoinGuru;
use App\Models\PoinSiswa;
use App\Models\RdmSyncLog;
use App\Models\RumahJurnal;
use App\Models\SchoolSetting;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use App\Models\Unit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MultiUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultPassword = Hash::make('password');

        // 1. Update School Setting for MA Attaraqqie
        SchoolSetting::updateOrCreate(
            ['id' => 1],
            [
                'nama_sekolah' => 'Madrasah Aliyah Attaraqqie Putra & Putri',
                'npsn' => '20580129',
                'alamat' => 'Jl. K.H. Wachid Hasyim No. 12, Kauman, Kota Malang, Jawa Timur',
                'email' => 'info@attaraqqie.sch.id',
                'telepon' => '(0341) 362819',
                'website' => 'www.attaraqqie.sch.id',
                'nama_kepala_sekolah' => 'Drs. H. M. Shodiq, M.Ag',
                'nip_kepala_sekolah' => '19680512 199403 1 003',
                'tahun_ajaran_aktif' => '2024/2025',
                'semester_aktif' => 'ganjil',
            ]
        );

        // 2. Jenjang & Units
        $jenjangsData = [
            ['kode' => 'TK', 'nama' => 'Raudhatul Athfal (TK/RA)'],
            ['kode' => 'MI', 'nama' => 'Madrasah Ibtidaiyah (MI)'],
            ['kode' => 'MTS', 'nama' => 'Madrasah Tsanawiyah (MTs)'],
            ['kode' => 'MA', 'nama' => 'Madrasah Aliyah (MA)'],
        ];

        $jenjangModels = [];
        foreach ($jenjangsData as $jd) {
            $jenjangModels[$jd['kode']] = Jenjang::updateOrCreate(
                ['kode' => $jd['kode']],
                ['nama' => $jd['nama'], 'aktif' => true]
            );
        }

        $units = [];
        foreach (['TK', 'MI', 'MTS', 'MA'] as $kode) {
            $j = $jenjangModels[$kode];
            $units[$kode . '_PUTRA'] = Unit::updateOrCreate(
                ['jenjang_id' => $j->id, 'gender' => 'putra'],
                ['nama' => $kode . ' Attaraqqie (Putra)', 'deskripsi' => "Kampus Pesantren Putra jenjang {$j->nama}"]
            );

            $units[$kode . '_PUTRI'] = Unit::updateOrCreate(
                ['jenjang_id' => $j->id, 'gender' => 'putri'],
                ['nama' => $kode . ' Attaraqqie (Putri)', 'deskripsi' => "Kampus Pesantren Putri jenjang {$j->nama}"]
            );
        }

        $maPutra = $units['MA_PUTRA'];
        $maPutri = $units['MA_PUTRI'];

        // 3. User Accounts for Demo
        // Admin Global
        $adminGlobal = User::updateOrCreate(
            ['email' => 'admin.global@demo'],
            [
                'name' => 'H. Achmad Fauzi, S.E. (Admin Global)',
                'password' => $defaultPassword,
                'role' => 'admin',
                'admin_level' => 'global',
            ]
        );

        // Admin MA Putra
        $adminPutra = User::updateOrCreate(
            ['email' => 'admin.putra@demo'],
            [
                'name' => 'Ustadz Farid Ridwan, S.Kom (Admin Putra)',
                'password' => $defaultPassword,
                'role' => 'admin',
                'admin_level' => 'putra',
            ]
        );

        // Admin MA Putri
        $adminPutri = User::updateOrCreate(
            ['email' => 'admin.putri@demo'],
            [
                'name' => 'Ustadzah Nurul Hidayati, S.Pd (Admin Putri)',
                'password' => $defaultPassword,
                'role' => 'admin',
                'admin_level' => 'putri',
            ]
        );

        // Guru Demo Accounts
        $guruPutra = User::updateOrCreate(
            ['email' => 'guru.putra@demo'],
            [
                'name' => 'Ustadz Ahmad Zaki, S.Pd.I',
                'password' => $defaultPassword,
                'role' => 'guru',
            ]
        );
        $guruPutra->units()->syncWithoutDetaching([$maPutra->id]);

        $guruPutri = User::updateOrCreate(
            ['email' => 'guru.putri@demo'],
            [
                'name' => 'Ustadzah Siti Fatimah, M.Pd',
                'password' => $defaultPassword,
                'role' => 'guru',
            ]
        );
        $guruPutri->units()->syncWithoutDetaching([$maPutri->id]);

        $guruKeduanya = User::updateOrCreate(
            ['email' => 'guru.keduanya@demo'],
            [
                'name' => 'Ustadz Dr. H. M. Hasbi, M.Pd.I',
                'password' => $defaultPassword,
                'role' => 'guru',
            ]
        );
        $guruKeduanya->units()->syncWithoutDetaching([$maPutra->id, $maPutri->id]);

        // Orang Tua Demo Account
        $ortuDemo = User::updateOrCreate(
            ['email' => 'ortu@demo'],
            [
                'name' => 'H. Supriyadi Pratama, M.Si',
                'password' => $defaultPassword,
                'role' => 'orang_tua',
            ]
        );

        // Additional Teachers (Total ~15 teachers)
        $teachersData = [
            ['name' => 'K.H. Syamsul Arifin, Lc', 'email' => 'syamsul@demo', 'units' => [$maPutra->id]],
            ['name' => 'Dra. Hj. Ummu Kulsum', 'email' => 'ummu@demo', 'units' => [$maPutri->id]],
            ['name' => 'Ustadz Lukman Hakim, S.Si', 'email' => 'lukman@demo', 'units' => [$maPutra->id, $maPutri->id]],
            ['name' => 'Ustadzah Dewi Sartika, M.Pd', 'email' => 'dewi@demo', 'units' => [$maPutri->id]],
            ['name' => 'Ustadz Ali Ridho, M.A', 'email' => 'ali@demo', 'units' => [$maPutra->id]],
            ['name' => 'Ustadzah Zahra Al-Attas, S.Hum', 'email' => 'zahra@demo', 'units' => [$maPutri->id]],
            ['name' => 'Ustadz Muhammad Ilham, M.Kom', 'email' => 'ilham@demo', 'units' => [$maPutra->id, $maPutri->id]],
            ['name' => 'Ustadzah Khadijah, S.Ag', 'email' => 'khadijah@demo', 'units' => [$maPutri->id]],
            ['name' => 'Ustadz Wildan Firdaus, S.Pd', 'email' => 'wildan@demo', 'units' => [$maPutra->id]],
            ['name' => 'Ustadz Agus Salim, M.Pd', 'email' => 'agus@demo', 'units' => [$maPutra->id, $maPutri->id]],
        ];

        $teacherList = [$guruPutra, $guruPutri, $guruKeduanya];
        foreach ($teachersData as $td) {
            $t = User::updateOrCreate(
                ['email' => $td['email']],
                ['name' => $td['name'], 'password' => $defaultPassword, 'role' => 'guru']
            );
            $t->units()->syncWithoutDetaching($td['units']);
            $teacherList[] = $t;
        }

        // 4. Mata Pelajaran Khas Madrasah & Umum
        $mapelsData = [
            ['kode' => 'QUR-10', 'nama' => 'Al-Qur\'an Hadits', 'tingkat' => '10', 'kkm' => 75],
            ['kode' => 'AQI-10', 'nama' => 'Akidah Akhlak', 'tingkat' => '10', 'kkm' => 80],
            ['kode' => 'FIQ-10', 'nama' => 'Fikih & Ushul Fikih', 'tingkat' => '10', 'kkm' => 78],
            ['kode' => 'SKI-10', 'nama' => 'Sejarah Kebudayaan Islam', 'tingkat' => '10', 'kkm' => 75],
            ['kode' => 'ARB-10', 'nama' => 'Bahasa Arab', 'tingkat' => '10', 'kkm' => 75],
            ['kode' => 'MTK-10', 'nama' => 'Matematika Peminatan', 'tingkat' => '10', 'kkm' => 75],
            ['kode' => 'FIS-10', 'nama' => 'Fisika', 'tingkat' => '10', 'kkm' => 75],
            ['kode' => 'KIM-10', 'nama' => 'Kimia', 'tingkat' => '10', 'kkm' => 75],
            ['kode' => 'BIO-10', 'nama' => 'Biologi', 'tingkat' => '10', 'kkm' => 75],
            ['kode' => 'EKO-10', 'nama' => 'Ekonomi & Akuntansi', 'tingkat' => '10', 'kkm' => 75],
            ['kode' => 'BIG-10', 'nama' => 'Bahasa Inggris', 'tingkat' => '10', 'kkm' => 75],
            ['kode' => 'BIN-10', 'nama' => 'Bahasa Indonesia', 'tingkat' => '10', 'kkm' => 75],
        ];

        $mapelModels = [];
        foreach ($mapelsData as $md) {
            $mapelModels[] = MataPelajaran::updateOrCreate(
                ['kode_mapel' => $md['kode']],
                ['nama_mapel' => $md['nama'], 'tingkat' => $md['tingkat'], 'kkm' => $md['kkm']]
            );
        }

        // 5. Classes (Rombel) for MA Attaraqqie Putra & Putri + Other Stages
        // MA Putra Rombels
        $maPutraClasses = [
            ['tingkat' => 10, 'nama_rombel' => 'X-IPA Putra', 'wali' => $guruPutra->id],
            ['tingkat' => 10, 'nama_rombel' => 'X-IPS Putra', 'wali' => $teacherList[3]->id ?? $guruPutra->id],
            ['tingkat' => 11, 'nama_rombel' => 'XI-IPA Putra', 'wali' => $guruKeduanya->id],
            ['tingkat' => 11, 'nama_rombel' => 'XI-IPS Putra', 'wali' => $teacherList[7]->id ?? $guruPutra->id],
            ['tingkat' => 12, 'nama_rombel' => 'XII-IPA Putra', 'wali' => $teacherList[8]->id ?? $guruPutra->id],
            ['tingkat' => 12, 'nama_rombel' => 'XII-IPS Putra', 'wali' => $teacherList[9]->id ?? $guruPutra->id],
        ];

        $kelasPutraModels = [];
        foreach ($maPutraClasses as $c) {
            $kelasPutraModels[] = Kelas::updateOrCreate(
                ['tingkat' => $c['tingkat'], 'nama_rombel' => $c['nama_rombel']],
                ['wali_kelas_id' => $c['wali'], 'unit_id' => $maPutra->id]
            );
        }

        // MA Putri Rombels
        $maPutriClasses = [
            ['tingkat' => 10, 'nama_rombel' => 'X-IPA Putri', 'wali' => $guruPutri->id],
            ['tingkat' => 10, 'nama_rombel' => 'X-IPS Putri', 'wali' => $teacherList[4]->id ?? $guruPutri->id],
            ['tingkat' => 11, 'nama_rombel' => 'XI-IPA Putri', 'wali' => $teacherList[5]->id ?? $guruPutri->id],
            ['tingkat' => 11, 'nama_rombel' => 'XI-IPS Putri', 'wali' => $teacherList[6]->id ?? $guruPutri->id],
            ['tingkat' => 12, 'nama_rombel' => 'XII-IPA Putri', 'wali' => $guruPutri->id],
            ['tingkat' => 12, 'nama_rombel' => 'XII-IPS Putri', 'wali' => $teacherList[4]->id ?? $guruPutri->id],
        ];

        $kelasPutriModels = [];
        foreach ($maPutriClasses as $c) {
            $kelasPutriModels[] = Kelas::updateOrCreate(
                ['tingkat' => $c['tingkat'], 'nama_rombel' => $c['nama_rombel']],
                ['wali_kelas_id' => $c['wali'], 'unit_id' => $maPutri->id]
            );
        }

        // Lightweight rombels for MTs, MI, TK
        $mtsPutraKelas = Kelas::updateOrCreate(['tingkat' => 7, 'nama_rombel' => 'VII-A Putra'], ['unit_id' => $units['MTS_PUTRA']->id]);
        $mtsPutriKelas = Kelas::updateOrCreate(['tingkat' => 7, 'nama_rombel' => 'VII-A Putri'], ['unit_id' => $units['MTS_PUTRI']->id]);
        $miPutraKelas = Kelas::updateOrCreate(['tingkat' => 1, 'nama_rombel' => 'I-A Putra'], ['unit_id' => $units['MI_PUTRA']->id]);
        $miPutriKelas = Kelas::updateOrCreate(['tingkat' => 1, 'nama_rombel' => 'I-A Putri'], ['unit_id' => $units['MI_PUTRI']->id]);
        $tkPutraKelas = Kelas::updateOrCreate(['tingkat' => 0, 'nama_rombel' => 'TK-A Putra'], ['unit_id' => $units['TK_PUTRA']->id]);
        $tkPutriKelas = Kelas::updateOrCreate(['tingkat' => 0, 'nama_rombel' => 'TK-A Putri'], ['unit_id' => $units['TK_PUTRI']->id]);

        // Connect Guru to Mapel and Kelas
        foreach ($kelasPutraModels as $kp) {
            GuruMapel::firstOrCreate(['guru_id' => $guruPutra->id, 'kelas_id' => $kp->id, 'mapel_id' => $mapelModels[0]->id]);
            GuruMapel::firstOrCreate(['guru_id' => $guruKeduanya->id, 'kelas_id' => $kp->id, 'mapel_id' => $mapelModels[5]->id]);
        }
        foreach ($kelasPutriModels as $kp) {
            GuruMapel::firstOrCreate(['guru_id' => $guruPutri->id, 'kelas_id' => $kp->id, 'mapel_id' => $mapelModels[1]->id]);
            GuruMapel::firstOrCreate(['guru_id' => $guruKeduanya->id, 'kelas_id' => $kp->id, 'mapel_id' => $mapelModels[5]->id]);
        }

        // 6. Generate Realistic Santri / Siswa (100+ students)
        $namaPutra = [
            'Muhammad Rayhan Al-Fatih', 'Ahmad Daniyal Malik', 'Bilal Haidar Syahputra', 'Faris Ihsan Kamil',
            'Zaidan Rafif Pratama', 'Hafidz Abdurrahman', 'Hilman Sholahuddin', 'M. Fatih Robbani',
            'Izzan Naufal Ramadhan', 'Thoriq Aziz Mahendra', 'Wildan Khoirul Anam', 'Rifqi Hamizan',
            'Sulaiman Al-Ghifari', 'Usamah bin Ziyad', 'Dzakwan Syarif', 'Fathan Mubarak',
            'Irfan Hakim Wardhana', 'Rasyid Ridho Pratama', 'Yusuf Habiburrahman', 'Zulfa Muwaffaq',
            'Abidzar Al-Ghifari', 'Baqir Ali Mustofa', 'Danial Hakim', 'Fawwaz Al-Bariq',
            'Habibullah Robbani', 'Ilyas Quraish', 'Jibril Maulana', 'Kaisar Zaidan',
            'Luqman Hakim An-Nawawi', 'Musyaffa Al-Farisi', 'Najib Mahfudz', 'Raihan Dzaky',
            'Shadiqul Amin', 'Taufiqurrahman', 'Wafiuddin Al-Khattab', 'Yahya Ayyash',
            'Zubair bin Awwam', 'Affan Syarif', 'Bisyir Al-Hafi', 'Dhiyaul Haq',
            'Emir Rabbani', 'Faishal Rahmat', 'Ghazali Al-Faruq', 'Hamzah Asadullah',
            'Imron Rosyadi', 'Jalaluddin Rumi', 'Kholid Basalamah', 'Labib Fathurrahman',
            'Miftahul Ulum', 'Nizhamul Muluk', 'Qomaruddin Syah', 'Robiul Awwal',
            'Syauqi Ibrahim', 'Thalhah bin Ubaidillah', 'Utsman Hadi', 'Wahid Hasyim',
        ];

        $namaPutri = [
            'Aisyah Syakira Zahra', 'Fatimah Az-Zahra Wardhani', 'Khadijah Nurul Izzah', 'Maryam Salma Azizah',
            'Zalfa Nailah Putri', 'Shafiyyah Nur Fitriana', 'Hilya Aulia Rahma', 'Naila Fauziyyah',
            'Salwa Nabila Kirana', 'Yasmin Kamila Zahirah', 'Afifah Zahidah', 'Bilqis Maharani',
            'Dina Marwah Al-Habsyi', 'Farah Diba Al-Attas', 'Ghaida Shofi Amalia', 'Hafshah Binti Umar',
            'Inas Tsabita', 'Jauharah Nafisah', 'Kayla Azzahra', 'Lathifah Karimah',
            'Muthia Az-Zuhro', 'Nabilah Zahratun Nisa', 'Qonita Dian Salsabila', 'Rania Shidqiyyah',
            'Syifa Fauziyah', 'Tasnim Rahadatul Aisy', 'Ufairah Syarifah', 'Wardah Hayatun Nufus',
            'Yumna Nabila', 'Zakiyyah Drajat', 'Adawiyah Rabiatul', 'Balqis Humaira',
            'Camila Syahrani', 'Dhiya Najwa', 'Elmira Nurul Huda', 'Fairuz Shalihatun',
            'Ghania Salimah', 'Humaira Nur Azizah', 'Ibtisam Mawaddah', 'Jihan Talitha',
            'Kamila Rahmatina', 'Lubna Farida', 'Maisarah Khairunnisa', 'Nisrina Firdaus',
            'Qurrata A\'yun', 'Raihanah Thahirah', 'Siti Masyitoh', 'Tsaniatul Husna',
            'Ummu Aiman', 'Vina Nur Halizah', 'Widad Sholihat', 'Yusra Karimah',
        ];

        // Specific 2 Children for Ortu Demo
        // Child 1: Putra (Muhammad Rayhan Al-Fatih) in X-IPA Putra
        // Child 2: Putri (Aisyah Syakira Zahra) in X-IPA Putri
        $anakPutraUser = User::updateOrCreate(
            ['email' => 'anak.putra@demo'],
            [
                'name' => 'Muhammad Rayhan Al-Fatih',
                'password' => $defaultPassword,
                'role' => 'siswa',
                'kelas_id' => $kelasPutraModels[0]->id,
            ]
        );
        $anakPutraProfile = Siswa::updateOrCreate(
            ['user_id' => $anakPutraUser->id],
            [
                'kelas_id' => $kelasPutraModels[0]->id,
                'unit_id' => $maPutra->id,
                'nis' => '20241001',
                'nisn' => '0081234501',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Malang',
                'tanggal_lahir' => '2008-03-12',
                'alamat' => 'Jl. Ijen No. 44, Malang',
                'nama_orang_tua' => 'H. Supriyadi Pratama, M.Si',
                'no_hp_orang_tua' => '081234567890',
                'status' => 'aktif',
            ]
        );

        $anakPutriUser = User::updateOrCreate(
            ['email' => 'anak.putri@demo'],
            [
                'name' => 'Aisyah Syakira Zahra',
                'password' => $defaultPassword,
                'role' => 'siswa',
                'kelas_id' => $kelasPutriModels[0]->id,
            ]
        );
        $anakPutriProfile = Siswa::updateOrCreate(
            ['user_id' => $anakPutriUser->id],
            [
                'kelas_id' => $kelasPutriModels[0]->id,
                'unit_id' => $maPutri->id,
                'nis' => '20242001',
                'nisn' => '0081234502',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Malang',
                'tanggal_lahir' => '2008-08-20',
                'alamat' => 'Jl. Ijen No. 44, Malang',
                'nama_orang_tua' => 'H. Supriyadi Pratama, M.Si',
                'no_hp_orang_tua' => '081234567890',
                'status' => 'aktif',
            ]
        );

        // Link Ortu to both children
        $ortuDemo->anaks()->syncWithoutDetaching([$anakPutraUser->id, $anakPutriUser->id]);

        // Seed bulk Putra students into MA Putra classes
        $allPutraUsers = [$anakPutraUser];
        $allPutriUsers = [$anakPutriUser];

        $nisCounter = 20241002;
        foreach ($namaPutra as $idx => $np) {
            if ($idx === 0) continue; // skip first (already created for demo)
            $kelas = $kelasPutraModels[$idx % count($kelasPutraModels)];
            $email = 'santri.' . $nisCounter . '@attaraqqie.test';
            $u = User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $np,
                    'password' => $defaultPassword,
                    'role' => 'siswa',
                    'kelas_id' => $kelas->id,
                ]
            );
            Siswa::updateOrCreate(
                ['user_id' => $u->id],
                [
                    'kelas_id' => $kelas->id,
                    'unit_id' => $maPutra->id,
                    'nis' => (string) $nisCounter,
                    'nisn' => '008' . rand(1000000, 9999999),
                    'jenis_kelamin' => 'L',
                    'tempat_lahir' => 'Malang',
                    'tanggal_lahir' => '2008-05-15',
                    'alamat' => 'Pondok Pesantren Attaraqqie Putra',
                    'nama_orang_tua' => 'Wali Santri ' . $np,
                    'no_hp_orang_tua' => '081' . rand(100000000, 999999999),
                    'status' => 'aktif',
                ]
            );
            $allPutraUsers[] = $u;
            $nisCounter++;
        }

        $nisCounterPutri = 20242002;
        foreach ($namaPutri as $idx => $np) {
            if ($idx === 0) continue;
            $kelas = $kelasPutriModels[$idx % count($kelasPutriModels)];
            $email = 'santri.' . $nisCounterPutri . '@attaraqqie.test';
            $u = User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $np,
                    'password' => $defaultPassword,
                    'role' => 'siswa',
                    'kelas_id' => $kelas->id,
                ]
            );
            Siswa::updateOrCreate(
                ['user_id' => $u->id],
                [
                    'kelas_id' => $kelas->id,
                    'unit_id' => $maPutri->id,
                    'nis' => (string) $nisCounterPutri,
                    'nisn' => '008' . rand(1000000, 9999999),
                    'jenis_kelamin' => 'P',
                    'tempat_lahir' => 'Surabaya',
                    'tanggal_lahir' => '2008-06-18',
                    'alamat' => 'Pondok Pesantren Attaraqqie Putri',
                    'nama_orang_tua' => 'Wali Santri ' . $np,
                    'no_hp_orang_tua' => '081' . rand(100000000, 999999999),
                    'status' => 'aktif',
                ]
            );
            $allPutriUsers[] = $u;
            $nisCounterPutri++;
        }

        // Lightweight students for MTs, MI, TK
        $otherStudents = [
            ['nama' => 'Faris MTs Putra', 'email' => 'mts.putra@test', 'kelas' => $mtsPutraKelas, 'unit' => $units['MTS_PUTRA'], 'jk' => 'L', 'nis' => '20243001'],
            ['nama' => 'Amina MTs Putri', 'email' => 'mts.putri@test', 'kelas' => $mtsPutriKelas, 'unit' => $units['MTS_PUTRI'], 'jk' => 'P', 'nis' => '20243002'],
            ['nama' => 'Hasan MI Putra', 'email' => 'mi.putra@test', 'kelas' => $miPutraKelas, 'unit' => $units['MI_PUTRA'], 'jk' => 'L', 'nis' => '20244001'],
            ['nama' => 'Zahra MI Putri', 'email' => 'mi.putri@test', 'kelas' => $miPutriKelas, 'unit' => $units['MI_PUTRI'], 'jk' => 'P', 'nis' => '20244002'],
            ['nama' => 'Ibrahim TK Putra', 'email' => 'tk.putra@test', 'kelas' => $tkPutraKelas, 'unit' => $units['TK_PUTRA'], 'jk' => 'L', 'nis' => '20245001'],
            ['nama' => 'Khadijah TK Putri', 'email' => 'tk.putri@test', 'kelas' => $tkPutriKelas, 'unit' => $units['TK_PUTRI'], 'jk' => 'P', 'nis' => '20245002'],
        ];
        foreach ($otherStudents as $os) {
            $u = User::updateOrCreate(
                ['email' => $os['email']],
                ['name' => $os['nama'], 'password' => $defaultPassword, 'role' => 'siswa', 'kelas_id' => $os['kelas']->id]
            );
            Siswa::updateOrCreate(
                ['user_id' => $u->id],
                [
                    'kelas_id' => $os['kelas']->id,
                    'unit_id' => $os['unit']->id,
                    'nis' => $os['nis'],
                    'nisn' => '009' . rand(1000000, 9999999),
                    'jenis_kelamin' => $os['jk'],
                    'tempat_lahir' => 'Malang',
                    'tanggal_lahir' => '2012-01-01',
                    'alamat' => 'Malang',
                    'nama_orang_tua' => 'Wali ' . $os['nama'],
                    'no_hp_orang_tua' => '081234567890',
                    'status' => 'aktif',
                ]
            );
        }

        // 7. Jadwal Pelajaran (Schedule)
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $jamList = [
            ['07:30', '09:00'],
            ['09:15', '10:45'],
            ['11:00', '12:30'],
            ['13:30', '15:00'],
        ];

        // Seed some schedules for MA Putra & Putri
        foreach ($kelasPutraModels as $kp) {
            foreach (array_slice($hariList, 0, 3) as $hIdx => $h) {
                Jadwal::updateOrCreate(
                    ['kelas_id' => $kp->id, 'hari' => $h, 'jam_mulai' => $jamList[$hIdx % 4][0]],
                    [
                        'guru_id' => ($hIdx % 2 == 0) ? $guruPutra->id : $guruKeduanya->id,
                        'mapel_id' => $mapelModels[$hIdx % count($mapelModels)]->id,
                        'unit_id' => $maPutra->id,
                        'jam_selesai' => $jamList[$hIdx % 4][1],
                    ]
                );
            }
        }
        foreach ($kelasPutriModels as $kp) {
            foreach (array_slice($hariList, 0, 3) as $hIdx => $h) {
                Jadwal::updateOrCreate(
                    ['kelas_id' => $kp->id, 'hari' => $h, 'jam_mulai' => $jamList[$hIdx % 4][0]],
                    [
                        'guru_id' => ($hIdx % 2 == 0) ? $guruPutri->id : $guruKeduanya->id,
                        'mapel_id' => $mapelModels[($hIdx + 1) % count($mapelModels)]->id,
                        'unit_id' => $maPutri->id,
                        'jam_selesai' => $jamList[$hIdx % 4][1],
                    ]
                );
            }
        }

        // 8. Absensi Guru & Siswa Hari Ini & 10 Hari Terakhir
        $today = Carbon::today();
        
        // Check-in teacher attendance for guruPutra and guruKeduanya today
        AbsensiGuru::updateOrCreate(
            ['guru_id' => $guruPutra->id, 'tanggal' => $today->toDateString()],
            [
                'unit_id' => $maPutra->id,
                'jam_masuk' => '07:15:00',
                'status' => 'hadir',
                'catatan' => 'Hadir tepat waktu sebelum apel pagi santri.',
            ]
        );
        AbsensiGuru::updateOrCreate(
            ['guru_id' => $guruKeduanya->id, 'tanggal' => $today->toDateString()],
            [
                'unit_id' => $maPutra->id,
                'jam_masuk' => '07:20:00',
                'status' => 'hadir',
                'catatan' => 'Mengajar sesi tahfidz dan matematika.',
            ]
        );
        // Note: guruPutri is deliberately NOT checked in today to demonstrate the gate lock for journal!

        // Seed historical attendance for students over past 5 days
        for ($i = 0; $i < 5; $i++) {
            $tgl = $today->copy()->subDays($i);
            if ($tgl->isSunday()) continue;

            // Anak demo Putra
            AbsensiSiswa::updateOrCreate(
                ['siswa_id' => $anakPutraUser->id, 'tanggal' => $tgl->toDateString()],
                [
                    'kelas_id' => $kelasPutraModels[0]->id,
                    'unit_id' => $maPutra->id,
                    'guru_id' => $guruPutra->id,
                    'status' => 'hadir',
                    'keterangan' => 'Hadir tepat waktu',
                ]
            );

            // Anak demo Putri (1 sakit day to show parents notice)
            $statusPutri = ($i === 2) ? 'sakit' : 'hadir';
            AbsensiSiswa::updateOrCreate(
                ['siswa_id' => $anakPutriUser->id, 'tanggal' => $tgl->toDateString()],
                [
                    'kelas_id' => $kelasPutriModels[0]->id,
                    'unit_id' => $maPutri->id,
                    'guru_id' => $guruPutri->id,
                    'status' => $statusPutri,
                    'keterangan' => ($i === 2) ? 'Surat dokter: demam istirahat di UKS' : 'Hadir aktif',
                ]
            );

            // Sample other students in class
            foreach (array_slice($allPutraUsers, 0, 10) as $pu) {
                AbsensiSiswa::firstOrCreate(
                    ['siswa_id' => $pu->id, 'tanggal' => $tgl->toDateString()],
                    [
                        'kelas_id' => $kelasPutraModels[0]->id,
                        'unit_id' => $maPutra->id,
                        'guru_id' => $guruPutra->id,
                        'status' => 'hadir',
                    ]
                );
            }
        }

        // 9. Jurnal Mengajar
        Jurnal::updateOrCreate(
            [
                'guru_id' => $guruPutra->id,
                'kelas_id' => $kelasPutraModels[0]->id,
                'tanggal' => $today->toDateString(),
            ],
            [
                'mapel_id' => $mapelModels[0]->id,
                'unit_id' => $maPutra->id,
                'jam_ke' => '1 - 2',
                'materi' => 'Kajian Surah Al-Hujurat ayat 10-13 tentang Ukhuwah Islamiyah',
                'catatan' => 'Santri antusias berdiskusi. Semua tugas resume dikumpulkan.',
            ]
        );

        Jurnal::updateOrCreate(
            [
                'guru_id' => $guruKeduanya->id,
                'kelas_id' => $kelasPutraModels[0]->id,
                'tanggal' => $today->subDays(1)->toDateString(),
            ],
            [
                'mapel_id' => $mapelModels[5]->id,
                'unit_id' => $maPutra->id,
                'jam_ke' => '3 - 4',
                'materi' => 'Matriks & Transformasi Geometri Tingkat Lanjut',
                'catatan' => 'Latihan soal mandiri berjalan tertib.',
            ]
        );

        // 10. Rumah Jurnal
        RumahJurnal::updateOrCreate(
            ['judul' => 'Integrasi Nilai-Nilai Turats dalam Pembelajaran Sains Modern di Madrasah Aliyah'],
            [
                'penulis' => 'Ustadz Dr. H. M. Hasbi, M.Pd.I',
                'guru_id' => $guruKeduanya->id,
                'unit_id' => $maPutra->id,
                'kategori' => 'Inovasi Pembelajaran',
                'abstrak' => 'Penelitian ini mengeksplorasi metodologi integrasi kitab kuning (turats) klasik karangan ulama Nusantara ke dalam silabus Fisika dan Biologi modern guna membentuk saintis berkarakter qurani.',
                'tahun' => 2026,
                'status' => 'approved',
            ]
        );

        RumahJurnal::updateOrCreate(
            ['judul' => 'Efektivitas Metode Halaqah Berdiferensiasi dalam Peningkatan Maharah Qira\'ah Santriwati'],
            [
                'penulis' => 'Ustadzah Siti Fatimah, M.Pd',
                'guru_id' => $guruPutri->id,
                'unit_id' => $maPutri->id,
                'kategori' => 'Pendidikan Bahasa',
                'abstrak' => 'Kajian tindakan kelas di MA Putri Attaraqqie yang menguji perbandingan akselerasi kefasihan literatur Arab gundul melalui sistem talaqqi berkelompok kecil.',
                'tahun' => 2025,
                'status' => 'approved',
            ]
        );

        // 11. Kategori Poin Kedisiplinan & Karakter
        $kategoriList = [
            ['nama' => 'Juara 1 Lomba Kaligrafi / MTQ Tingkat Provinsi', 'tipe' => 'prestasi', 'bobot' => 30],
            ['nama' => 'Hafalan Al-Qur\'an Mutqin 5 Juz', 'tipe' => 'prestasi', 'bobot' => 25],
            ['nama' => 'Menjadi Imam Sholat Berjamaah & Muadzin Teladan', 'tipe' => 'prestasi', 'bobot' => 15],
            ['nama' => 'Juara Olimpiade Sains / Robotika Madrasah', 'tipe' => 'prestasi', 'bobot' => 35],
            ['nama' => 'Aktif Menjaga Kebersihan Asrama & Kelas', 'tipe' => 'prestasi', 'bobot' => 10],

            ['nama' => 'Terlambat Masuk Jam Pelajaran / Sholat Berjamaah', 'tipe' => 'pelanggaran', 'bobot' => 5],
            ['nama' => 'Atribut Seragam Santri Tidak Lengkap', 'tipe' => 'pelanggaran', 'bobot' => 5],
            ['nama' => 'Membawa / Menggunakan Gadget Tanpa Izin Mudir', 'tipe' => 'pelanggaran', 'bobot' => 20],
            ['nama' => 'Keluar Area Pesantren Tanpa Kartu Izin Resmi', 'tipe' => 'pelanggaran', 'bobot' => 30],
            ['nama' => 'Tidak Mengikuti Program Muwajjahah / Taklim Malam', 'tipe' => 'pelanggaran', 'bobot' => 10],
        ];

        $katModels = [];
        foreach ($kategoriList as $kl) {
            $katModels[] = KategoriPoin::updateOrCreate(
                ['nama' => $kl['nama']],
                ['tipe' => $kl['tipe'], 'bobot' => $kl['bobot']]
            );
        }

        // Poin Siswa demo (Anak Putra: prestasi tebus minus, net score positif tinggi)
        PoinSiswa::updateOrCreate(
            ['siswa_id' => $anakPutraUser->id, 'kategori_id' => $katModels[0]->id],
            [
                'unit_id' => $maPutra->id,
                'poin' => 30,
                'tanggal' => now()->subDays(15),
                'catatan' => 'Juara 1 Kaligrafi Naskhi PORSENI MA Jawa Timur 2026',
                'pencatat_id' => $guruPutra->id,
            ]
        );
        PoinSiswa::updateOrCreate(
            ['siswa_id' => $anakPutraUser->id, 'kategori_id' => $katModels[1]->id],
            [
                'unit_id' => $maPutra->id,
                'poin' => 25,
                'tanggal' => now()->subDays(5),
                'catatan' => 'Ujian Tasmi\' 5 Juz Sekali Duduk Predikat Jayyid Jiddan',
                'pencatat_id' => $guruPutra->id,
            ]
        );

        // Anak Putri: prestasi hafalan & teladan
        PoinSiswa::updateOrCreate(
            ['siswa_id' => $anakPutriUser->id, 'kategori_id' => $katModels[1]->id],
            [
                'unit_id' => $maPutri->id,
                'poin' => 25,
                'tanggal' => now()->subDays(10),
                'catatan' => 'Lulus Munaqosyah Juz 28-30 Tartil',
                'pencatat_id' => $guruPutri->id,
            ]
        );

        // Poin Karakter Guru
        PoinGuru::updateOrCreate(
            ['guru_id' => $guruKeduanya->id, 'judul' => 'Publikasi Jurnal Terakreditasi SINTA 2'],
            [
                'jenis' => 'prestasi',
                'poin' => 50,
                'tanggal' => now()->subMonths(1),
                'catatan' => 'Karya ilmiah bertema pendidikan madrasah',
                'unit_id' => $maPutra->id,
            ]
        );

        // 12. Evaluasi Kinerja Guru (4 Kompetensi)
        $instrumens = [
            ['kompetensi' => 'Pedagogik', 'indikator' => 'Kemampuan merancang modul ajar dan diferensiasi pembelajaran berbasis kurikulum merdeka madrasah'],
            ['kompetensi' => 'Profesional', 'indikator' => 'Penguasaan materi bidang studi keilmuan secara mendalam dan integrasi turats'],
            ['kompetensi' => 'Kepribadian', 'indikator' => 'Keteladanan akhlakul karimah, integritas, dan kedisiplinan kehadiran di madrasah'],
            ['kompetensi' => 'Sosial', 'indikator' => 'Komunikasi empatik dengan santri, sesama dewan asatidz, dan wali murid'],
        ];
        foreach ($instrumens as $ins) {
            InstrumenPenilaian::firstOrCreate(['indikator' => $ins['indikator']], ['kompetensi' => $ins['kompetensi'], 'bobot' => 25]);
        }

        EvaluasiGuru::updateOrCreate(
            ['guru_id' => $guruPutra->id, 'periode_tahun' => '2024/2025', 'semester' => 'ganjil'],
            [
                'penilai_id' => $adminGlobal->id,
                'unit_id' => $maPutra->id,
                'skor_pedagogik' => 88.5,
                'skor_profesional' => 87.0,
                'skor_kepribadian' => 92.0,
                'skor_sosial' => 90.5,
                'skor_total' => 89.5,
                'catatan' => 'Sangat berdedikasi dalam pembinaan tahfidz dan disiplin santri di asrama.',
            ]
        );

        EvaluasiGuru::updateOrCreate(
            ['guru_id' => $guruPutri->id, 'periode_tahun' => '2024/2025', 'semester' => 'ganjil'],
            [
                'penilai_id' => $adminGlobal->id,
                'unit_id' => $maPutri->id,
                'skor_pedagogik' => 91.0,
                'skor_profesional' => 89.5,
                'skor_kepribadian' => 94.0,
                'skor_sosial' => 93.0,
                'skor_total' => 91.9,
                'catatan' => 'Inovatif dalam metodologi halaqah bahasa dan pembinaan riset santriwati.',
            ]
        );

        // 13. Keuangan & Tagihan SPP
        // Tagihan Anak 1 (Putra): Oktober Lunas, November Belum
        $tagihanPutraOkt = Tagihan::updateOrCreate(
            ['siswa_id' => $anakPutraUser->id, 'periode' => 'Oktober 2026'],
            [
                'unit_id' => $maPutra->id,
                'nominal' => 450000,
                'jatuh_tempo' => '2026-10-10',
                'status' => 'lunas',
            ]
        );
        Pembayaran::firstOrCreate(
            ['tagihan_id' => $tagihanPutraOkt->id],
            [
                'tanggal' => '2026-10-05',
                'nominal' => 450000,
                'metode' => 'Transfer Bank Syariah Indonesia (BSI)',
                'catatan' => 'Lunas tepat waktu via BSI Virtual Account',
                'penerima_id' => $adminPutra->id,
            ]
        );

        Tagihan::updateOrCreate(
            ['siswa_id' => $anakPutraUser->id, 'periode' => 'November 2026'],
            [
                'unit_id' => $maPutra->id,
                'nominal' => 450000,
                'jatuh_tempo' => '2026-11-10',
                'status' => 'belum',
            ]
        );

        // Tagihan Anak 2 (Putri): Oktober Belum (Menunggu pembayaran)
        Tagihan::updateOrCreate(
            ['siswa_id' => $anakPutriUser->id, 'periode' => 'Oktober 2026'],
            [
                'unit_id' => $maPutri->id,
                'nominal' => 450000,
                'jatuh_tempo' => '2026-10-10',
                'status' => 'belum',
            ]
        );

        // Seed some SPP bills for other students
        foreach (array_slice($allPutraUsers, 1, 15) as $idx => $pu) {
            $isPaid = ($idx % 3 !== 0);
            $t = Tagihan::firstOrCreate(
                ['siswa_id' => $pu->id, 'periode' => 'Oktober 2026'],
                [
                    'unit_id' => $maPutra->id,
                    'nominal' => 450000,
                    'jatuh_tempo' => '2026-10-10',
                    'status' => $isPaid ? 'lunas' : 'belum',
                ]
            );
            if ($isPaid) {
                Pembayaran::firstOrCreate(
                    ['tagihan_id' => $t->id],
                    [
                        'tanggal' => '2026-10-08',
                        'nominal' => 450000,
                        'metode' => 'Tunai / Kasir TU',
                        'catatan' => 'Pembayaran lunas',
                        'penerima_id' => $adminPutra->id,
                    ]
                );
            }
        }

        // 14. In-App Notifications for Parent Demo
        Notifikasi::updateOrCreate(
            ['user_id' => $ortuDemo->id, 'judul' => 'Pengingat Tagihan SPP Oktober 2026'],
            [
                'tipe' => 'spp',
                'isi' => 'Tagihan SPP dan Uang Makan Asrama ananda Aisyah Syakira Zahra sebesar Rp 450.000 telah jatuh tempo pada 10 Oktober 2026.',
                'link' => '/orang-tua/tagihan',
                'dibaca_at' => null,
            ]
        );

        Notifikasi::updateOrCreate(
            ['user_id' => $ortuDemo->id, 'judul' => 'Prestasi Baru: Juara 1 Kaligrafi Provinsi'],
            [
                'tipe' => 'poin',
                'isi' => 'Alhamdulillah, ananda Muhammad Rayhan Al-Fatih meraih poin prestasi +30 atas capaian Juara 1 Kaligrafi PORSENI MA.',
                'link' => '/orang-tua/poin',
                'dibaca_at' => now()->subDays(2),
            ]
        );

        Notifikasi::updateOrCreate(
            ['user_id' => $ortuDemo->id, 'judul' => 'Informasi Kehadiran Santriwati'],
            [
                'tipe' => 'absen',
                'isi' => 'Ananda Aisyah Syakira Zahra tercatat izin istirahat di UKS Pesantren karena demam ringan pada 11 Oktober 2026.',
                'link' => '/orang-tua/absensi',
                'dibaca_at' => now()->subDays(1),
            ]
        );

        // 15. RDM Kemenag Sync Logs (Mock Logs)
        RdmSyncLog::updateOrCreate(
            ['pesan' => 'Sinkronisasi raport semester ganjil berhasil dikirim ke server RDM Kemenag (Simulasi).'],
            [
                'waktu' => now()->subDays(3),
                'kelas_id' => $kelasPutraModels[0]->id,
                'unit_id' => $maPutra->id,
                'jumlah_data' => 24,
                'status' => 'sukses',
            ]
        );
        RdmSyncLog::updateOrCreate(
            ['pesan' => 'Sebagian data terkirim: 2 siswa belum memiliki kelengkapan nomor registrasi EMIS Kemenag.'],
            [
                'waktu' => now()->subDays(1),
                'kelas_id' => $kelasPutriModels[0]->id,
                'unit_id' => $maPutri->id,
                'jumlah_data' => 22,
                'status' => 'sebagian',
            ]
        );

        // 16. Update PPDB Sample Applicants with Jenjang and Units
        Pendaftar::whereNull('unit_id')->each(function ($p) use ($maPutra, $maPutri, $jenjangModels) {
            $p->update([
                'jenjang_id' => $jenjangModels['MA']->id,
                'unit_id' => ($p->jenis_kelamin === 'L') ? $maPutra->id : $maPutri->id,
            ]);
        });
    }
}
