<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed akun admin tunggal untuk login ke sistem.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@perpus.test'],
            [
                'name' => 'Admin Perpustakaan',
                'password' => Hash::make('password'),
            ]
        );

        $this->call([
            BukuSeeder::class,
            AnggotaSeeder::class,
        ]);
    }
}
