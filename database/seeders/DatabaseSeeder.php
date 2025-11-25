<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin genérico
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // Usuario normal
        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Usuario Prueba',
                'password' => Hash::make('user123'),
                'role' => 'user',
            ]
        );

        // Tu usuario personal (admin)
        User::updateOrCreate(
            ['email' => 'peraltadixon5@gmail.com'],
            [
                'name' => 'Dixon',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );
        
    }
}
