<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Admin Sekolah',
            'email' => 'admin@smataskmaster.sch.id',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'admin',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Kepala Sekolah',
            'email' => 'kepsek@smataskmaster.sch.id',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'kepala_sekolah',
        ]);
    }

}
