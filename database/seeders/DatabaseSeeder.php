<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Owner User
        User::create([
            'name'     => 'Owner Parkir',
            'email'    => 'owner@parkir.test',
            'password' => Hash::make('password'),
            'role'     => 'owner',
        ]);

        // Create Petugas User
        User::create([
            'name'     => 'Petugas Parkir',
            'email'    => 'petugas@parkir.test',
            'password' => Hash::make('password'),
            'role'     => 'petugas',
        ]);

        // Optional: Create additional petugas users for testing
        User::create([
            'name'     => 'Petugas 2',
            'email'    => 'petugas2@parkir.test',
            'password' => Hash::make('password'),
            'role'     => 'petugas',
        ]);
    }
}