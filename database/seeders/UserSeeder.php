<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create staff user
        User::create([
            'name' => 'Hotel Staff',
            'email' => 'staff@example.com',
            'password' => Hash::make('password'),
            'is_staff' => true,
        ]);

        // Create regular user
        User::create([
            'name' => 'John Doe',
            'email' => 'guest@example.com',
            'password' => Hash::make('password'),
            'is_staff' => false,
        ]);
    }
}
