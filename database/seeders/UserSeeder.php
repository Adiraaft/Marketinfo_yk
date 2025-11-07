<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Superadmin
        User::create([
            'name' => 'adirangga',
            'email' => 'adirangga@example.com',
            'password' => Hash::make('root123'), // wajib di-hash
            'role' => 'superadmin',
            'status' => 'active'
        ]);

        // Admin
        User::create([
            'name' => 'adira',
            'email' => 'adira@example.com',
            'password' => Hash::make('admin123'), // wajib di-hash
            'role' => 'admin',
            'status' => 'active'
        ]);
    }
}
