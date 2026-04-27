<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@altar.com'],
            [
                'name' => 'Admin Altar',
                'password' => Hash::make('password123'),
                'role' => 1,
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@altar.com'],
            [
                'name' => 'Customer User',
                'password' => Hash::make('password123'),
                'role' => 0,
            ]
        );

        User::updateOrCreate(
            ['email' => 'kasir@altar.com'],
            [
                'name' => 'Kasir Altar',
                'password' => Hash::make('password123'),
                'role' => 2,
            ]
        );

        User::updateOrCreate(
            ['email' => 'john@altar.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password1123'),
                'role' => 0,
            ]
        );
    }
}
