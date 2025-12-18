<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User Mama
        User::create([
            'name' => 'User Mama',
            'email' => 'mama@gmail.com',
            'password' => Hash::make('mama'),
            'role' => 'mama',
        ]);

        // User Dokter
        User::create([
            'name' => 'User Dokter',
            'email' => 'dokter@gmail.com',
            'password' => Hash::make('dokter'),
            'role' => 'dokter',
        ]);

        // User Admin
        User::create([
            'name' => 'User Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'role' => 'admin',
        ]);
    }
}