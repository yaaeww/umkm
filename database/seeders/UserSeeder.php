<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('11111111'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Penjual',
            'email' => 'penjual@gmail.com',
            'password' => Hash::make('11111111'),
            'role' => 'penjual',
        ]);

        User::create([
            'name' => 'jo',
            'email' => 'jo@gmail.com',
            'password' => Hash::make('11111111'),
            'role' => 'penjual',
        ]);
    }
}
