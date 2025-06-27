<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DebugAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_debug_authentication(): void
    {
        // Create user manually to ensure it's correct
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'is_staff' => false,
        ]);

        // Verify user exists
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com'
        ]);

        // Check if password verification works
        $this->assertTrue(Hash::check('password', $user->password));

        // Try to log in
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        // Debug the response
        if ($response->status() !== 302) {
            dd('Response status: ' . $response->status(), $response->content());
        }

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
    }
}