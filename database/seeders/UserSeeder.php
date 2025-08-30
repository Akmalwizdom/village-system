<?php

namespace Database\Seeders;

use App\Models\Resident;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'id' => 1,
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => 'password', // password
            'status' => 'approved',
            'role_id' => '1', // Assuming role_id 1 is for Admin
        ]);

        User::create([
            'id' => 2,
            'name' => 'penduduk 1',
            'email' => 'penduduk1@gmail.com',
            'password' => 'password', // password
            'status' => 'approved',
            'role_id' => '2', // Assuming role_id 2 is for Resident
        ]);

        Resident::create([
            'user_id' => 2,
            'nik' => '1234567890123456',
            'name' => 'Doe John',
            'gender' => 'male',
            'birth_date' => '1990-01-01',
            'birth_place' => 'Bandung',
            'address' => 'Jl. Merdeka No. 10',
            'marital_status' => 'single',
        ]);
    }
}
