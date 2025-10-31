<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = \App\Models\User::updateOrCreate(
            ['email' => 'peraltadixon5@gmail.com'],
            [
                'name' => 'Dixon',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

    }
}
