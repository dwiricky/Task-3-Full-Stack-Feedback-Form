<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'nama' => 'guest',
                'email' => 'guest@g.com',
                'alamat' => 'Jl. Imam Bonjol No. 01',
                'nomor_hp' => '081234567890',
                'password' => Hash::make('12341234'),
                'role' => 'guest',
                'diarsipkan' => 'false'
            ],
            [
                'nama' => 'guest2',
                'email' => 'guest2@g.com',
                'alamat' => 'Jl. Imam Bonjol No. 01',
                'nomor_hp' => '081234567890',
                'password' => Hash::make('12341234'),
                'role' => 'guest',
                'diarsipkan' => 'false'
            ],
            [
                'nama' => 'admin',
                'email' => 'admin@g.com',
                'alamat' => 'Jl. Imam Bonjol No. 01',
                'nomor_hp' => '081234567890',
                'password' => Hash::make('12341234'),
                'role' => 'admin',
                'diarsipkan' => 'false'
            ],
            [
                'nama' => 'super-admin',
                'email' => 'super@g.com',
                'alamat' => 'Jl. Imam Bonjol No. 01',
                'nomor_hp' => '081234567890',
                'password' => Hash::make('12341234'),
                'role' => 'super-admin',
                'diarsipkan' => 'false'
            ],
        ]);
    }
}
