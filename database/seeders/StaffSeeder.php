<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Staff Admin',
            'email' => 'staff@example.com',
            'password' => Hash::make('password'),
            'is_staff' => true,
        ]);
    }
}
