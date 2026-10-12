<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DemoResetCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset database demo SIAS Multi-Unit ke kondisi awal presentasi';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Memulai reset database dan demo seeder MA Attaraqqie...');
        
        $this->call('migrate:fresh', [
            '--seed' => true,
            '--force' => true,
        ]);

        $this->newLine();
        $this->info('====================================================');
        $this->info('   DEMO SIAS MULTI-UNIT BERHASIL DIRESET!');
        $this->info('====================================================');
        $this->table(
            ['Peran', 'Email', 'Password', 'Keterangan'],
            [
                ['Admin Global Yayasan', 'admin.global@demo', 'password', 'Akses Semua Unit / Switcher Lintas Jenjang'],
                ['Admin MA Putra', 'admin.putra@demo', 'password', 'Khusus Santri & Asrama Putra'],
                ['Admin MA Putri', 'admin.putri@demo', 'password', 'Khusus Santriwati & Asrama Putri'],
                ['Guru MA Putra', 'guru.putra@demo', 'password', 'Ustadz Ahmad Zaki (Guru Putra)'],
                ['Guru MA Putri', 'guru.putri@demo', 'password', 'Ustadzah Siti Fatimah (Guru Putri)'],
                ['Guru Mengajar Keduanya', 'guru.keduanya@demo', 'password', 'Ustadz Dr. Hasbi (Lintas Putra/Putri)'],
                ['Orang Tua Santri', 'ortu@demo', 'password', 'Terhubung 2 Anak (1 Putra & 1 Putri)'],
            ]
        );

        return Command::SUCCESS;
    }
}
