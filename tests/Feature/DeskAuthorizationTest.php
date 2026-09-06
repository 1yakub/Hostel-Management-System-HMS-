<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Guest;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeskAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    private function room(): Room
    {
        return Room::create([
            'room_number' => 'A1', 'room_type' => 'Private double', 'capacity' => 2,
            'price_per_night' => 50, 'status' => 'available', 'gallery_images' => [], 'amenities' => [],
        ]);
    }

    public function test_the_desk_is_forbidden_for_guests_on_every_verb(): void
    {
        $guest = User::factory()->create(['is_staff' => false]);
        $room = $this->room();

        $this->actingAs($guest)->get('/desk')->assertForbidden();
        $this->actingAs($guest)->get('/desk/rooms')->assertForbidden();
        $this->actingAs($guest)->get('/desk/rooms/create')->assertForbidden();
        $this->actingAs($guest)->post('/desk/rooms', ['room_number' => 'Z9'])->assertForbidden();
        $this->actingAs($guest)->put("/desk/rooms/{$room->id}", ['room_number' => 'Z9'])->assertForbidden();
        $this->actingAs($guest)->delete("/desk/rooms/{$room->id}")->assertForbidden();
        $this->actingAs($guest)->get('/desk/guests')->assertForbidden();
        $this->actingAs($guest)->get('/desk/bookings')->assertForbidden();
        $this->actingAs($guest)->post('/desk/bookings', [])->assertForbidden();

        $this->assertDatabaseHas('rooms', ['id' => $room->id, 'room_number' => 'A1']);
    }

    public function test_signed_out_visitors_are_sent_to_sign_in(): void
    {
        $this->get('/desk')->assertRedirect('/login');
        $this->get('/my')->assertRedirect('/login');
        $this->get('/my/bookings')->assertRedirect('/login');
    }

    public function test_staff_reach_the_desk_and_guests_reach_their_space(): void
    {
        $staff = User::factory()->create(['is_staff' => true]);
        $guest = User::factory()->create(['is_staff' => false]);

        $this->actingAs($staff)->get('/desk')->assertOk();
        $this->actingAs($staff)->get('/desk/rooms/create')->assertOk();
        $this->actingAs($staff)->get('/my')->assertRedirect('/desk');

        $this->actingAs($guest)->get('/my')->assertOk();
        $this->actingAs($guest)->get('/my/bookings')->assertOk();
    }

    public function test_a_guest_cannot_check_out_a_booking(): void
    {
        $guest = User::factory()->create(['is_staff' => false]);
        $room = $this->room();
        $record = Guest::create(['name' => 'Someone', 'phone' => '0100', 'id_number' => 'ID-1']);
        $booking = Booking::create([
            'guest_id' => $record->id, 'room_id' => $room->id, 'status' => 'active',
            'check_in_date' => today(), 'check_out_date' => today()->addDay(), 'total_amount' => 50,
        ]);

        $this->actingAs($guest)->patch("/desk/bookings/{$booking->id}/checkout")->assertForbidden();
        $this->assertDatabaseHas('bookings', ['id' => $booking->id, 'status' => 'active']);
    }

    public function test_every_page_carries_a_content_security_policy(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $csp = $response->headers->get('Content-Security-Policy');
        $this->assertNotNull($csp);
        $this->assertStringContainsString("default-src 'self'", $csp);
        $this->assertStringContainsString("frame-ancestors 'none'", $csp);
        $this->assertStringContainsString('nonce-', $csp);

        // the Vite script tags carry the same nonce the header announces
        preg_match("/'nonce-([^']+)'/", $csp, $m);
        $this->assertStringContainsString('nonce="'.$m[1].'"', $response->getContent());
    }
}
