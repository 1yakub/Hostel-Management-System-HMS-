<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /** Demo accounts. Passwords come from the environment so a real deployment never ships "password". */
    public function run(): void
    {
        $password = config('hms.demo_password');

        User::updateOrCreate(['email' => 'staff@example.com'], [
            'name' => 'Desk Staff',
            'password' => Hash::make($password),
            'is_staff' => true,
            'email_verified_at' => now(),
        ]);

        User::updateOrCreate(['email' => 'guest@example.com'], [
            'name' => 'Demo Guest',
            'password' => Hash::make($password),
            'is_staff' => false,
            'email_verified_at' => now(),
        ]);
    }
}
