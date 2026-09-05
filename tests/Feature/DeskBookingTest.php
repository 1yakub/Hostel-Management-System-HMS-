<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Guest;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeskBookingTest extends TestCase
{
    use RefreshDatabase;

    private function staff(): User
    {
        return User::factory()->create(['is_staff' => true]);
    }

    private function room(array $attrs = []): Room
    {
        return Room::create(array_merge([
            'room_number' => 'R'.fake()->unique()->numberBetween(1, 999),
            'room_type' => 'Private double',
            'capacity' => 2,
            'price_per_night' => 50,
            'status' => 'available',
            'gallery_images' => [],
            'amenities' => [],
        ], $attrs));
    }

    public function test_guests_cannot_open_the_desk(): void
    {
        $guest = User::factory()->create(['is_staff' => false]);

        $this->actingAs($guest)->get('/bookings')->assertRedirect();
        $this->actingAs($guest)->get('/rooms/create')->assertRedirect();
    }

    public function test_desk_booking_rejects_an_overlapping_stay(): void
    {
        $room = $this->room();
        $a = Guest::create(['name' => 'A']);
        $b = Guest::create(['name' => 'B']);
        Booking::create(['room_id' => $room->id, 'guest_id' => $a->id, 'check_in_date' => now()->addDays(2)->toDateString(), 'check_out_date' => now()->addDays(5)->toDateString(), 'status' => 'active', 'total_amount' => 150]);

        $this->actingAs($this->staff())
            ->post('/bookings', ['guest_ids' => [$b->id], 'room_id' => $room->id, 'check_in_date' => now()->addDays(4)->toDateString(), 'check_out_date' => now()->addDays(6)->toDateString()])
            ->assertSessionHasErrors('room_id');

        $this->assertEquals(1, Booking::count());
    }

    public function test_desk_booking_rejects_more_guests_than_the_room_sleeps(): void
    {
        $room = $this->room(['capacity' => 1]);
        $a = Guest::create(['name' => 'A']);
        $b = Guest::create(['name' => 'B']);

        $this->actingAs($this->staff())
            ->post('/bookings', ['guest_ids' => [$a->id, $b->id], 'room_id' => $room->id, 'check_in_date' => now()->addDay()->toDateString(), 'check_out_date' => now()->addDays(2)->toDateString()])
            ->assertSessionHasErrors('guest_ids');
    }

    public function test_desk_booking_bills_the_first_guest_and_keeps_future_rooms_available(): void
    {
        $room = $this->room(['price_per_night' => 40]);
        $a = Guest::create(['name' => 'A']);
        $b = Guest::create(['name' => 'B']);

        $this->actingAs($this->staff())
            ->post('/bookings', ['guest_ids' => [$a->id, $b->id], 'room_id' => $room->id, 'check_in_date' => now()->addDays(3)->toDateString(), 'check_out_date' => now()->addDays(5)->toDateString()])
            ->assertRedirect();

        $this->assertEquals(80, Booking::where('guest_id', $a->id)->value('total_amount'));
        $this->assertEquals(0, Booking::where('guest_id', $b->id)->value('total_amount'));
        $this->assertEquals('available', $room->fresh()->status);
    }

    public function test_checkout_completes_the_whole_party_and_frees_the_room(): void
    {
        $room = $this->room(['status' => 'occupied']);
        $a = Guest::create(['name' => 'A']);
        $b = Guest::create(['name' => 'B']);
        $in = now()->subDay()->toDateString();
        $out = now()->addDay()->toDateString();
        $primary = Booking::create(['room_id' => $room->id, 'guest_id' => $a->id, 'check_in_date' => $in, 'check_out_date' => $out, 'status' => 'active', 'total_amount' => 100]);
        Booking::create(['room_id' => $room->id, 'guest_id' => $b->id, 'check_in_date' => $in, 'check_out_date' => $out, 'status' => 'active', 'total_amount' => 0]);

        $this->actingAs($this->staff())->patch("/bookings/{$primary->id}/checkout")->assertRedirect();

        $this->assertEquals(2, Booking::where('status', 'completed')->count());
        $this->assertEquals('available', $room->fresh()->status);
    }

    public function test_web_request_creates_a_guest_record_for_the_user(): void
    {
        $room = $this->room();
        $user = User::factory()->create(['is_staff' => false]);

        $this->actingAs($user)
            ->post('/book-now', ['room_id' => $room->id, 'check_in_date' => now()->addDays(2)->toDateString(), 'check_out_date' => now()->addDays(4)->toDateString()])
            ->assertRedirect(route('guest.bookings'));

        $this->assertEquals(1, Guest::where('user_id', $user->id)->count());
        $this->assertEquals(100, $user->bookings()->first()->total_amount);
    }
}
