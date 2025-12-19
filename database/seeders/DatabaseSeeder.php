<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Doctor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. User Mama (Akun buat Bunda Login)
        User::create([
            'name' => 'Bunda Azmi',
            'email' => 'mama@gmail.com',
            'password' => Hash::make('mama'),
            'role' => 'mama',
        ]);

        // 2. User Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'role' => 'admin',
        ]);

        // --- MULAI BAGIAN DOKTER ---

        // 3. User Dokter 1: Dr. Boyke (Senior & Humoris)
        $dokter1 = User::create([
            'name' => 'Dr. Boyke Dian',
            'email' => 'dokter@gmail.com',
            'password' => Hash::make('dokter'),
            'role' => 'dokter',
        ]);

        Doctor::create([
            'user_id' => $dokter1->id,
            'name' => 'Dr. Boyke Dian, Sp.OG',
            'specialist' => 'Spesialis Kandungan',
            'experience' => 15,
            // Ganti background hitam jadi Pink Tua (#C21B75) biar seragam
            'image' => 'https://ui-avatars.com/api/?name=Boyke+Dian&background=C21B75&color=fff&size=128', 
            'description' => 'Dokter senior yang sangat humoris dan detail dalam menjelaskan. Cocok untuk Bunda yang mudah panik dan butuh suasana santai.'
        ]);

        // 4. User Dokter 2: Dr. Aisah (Keibuan & Lembut)
        $dokter2 = User::create([
            'name' => 'Dr. Aisah Putri',
            'email' => 'aisah@mamacare.com',
            'password' => Hash::make('password'),
            'role' => 'dokter',
        ]);

        Doctor::create([
            'user_id' => $dokter2->id,
            'name' => 'Dr. Aisah Putri, Sp.OG',
            'specialist' => 'Dokter Kandungan',
            'experience' => 8,
            'image' => 'https://ui-avatars.com/api/?name=Aisah+Putri&background=FF3EA5&color=fff&size=128',
            'description' => 'Sangat keibuan, sabar mendengarkan keluhan, dan pro-persalinan normal. Sahabat terbaik untuk kehamilan pertama Bunda.'
        ]);

        // 5. User Dokter 3: Bidan Siti (Telaten & Praktis)
        $dokter3 = User::create([
            'name' => 'Bidan Siti',
            'email' => 'siti@mamacare.com',
            'password' => Hash::make('password'),
            'role' => 'dokter',
        ]);

        Doctor::create([
            'user_id' => $dokter3->id,
            'name' => 'Bidan Siti Aminah, S.Tr.Keb',
            'specialist' => 'Bidan Sahabat Ibu',
            'experience' => 5,
            'image' => 'https://ui-avatars.com/api/?name=Siti+Aminah&background=FF90C8&color=fff&size=128',
            'description' => 'Bidan muda yang cekatan, telaten mengurus baby, dan fokus pada relaksasi ibu hamil (Hypnobirthing).'
        ]);
    }
}