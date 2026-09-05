<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AvailabilityTest extends TestCase
{
    use RefreshDatabase;

    private function room(array $attrs = []): Room
    {
        return Room::create(array_merge([
            'room_number' => 'T'.fake()->unique()->numberBetween(1, 999),
            'room_type' => 'Private double',
            'description' => 'Test room',
            'capacity' => 2,
            'price_per_night' => 40,
            'status' => 'available',
            'featured_image' => '/images/room-private.webp',
            'gallery_images' => [],
            'amenities' => ['Wi-Fi'],
        ], $attrs));
    }

    public function test_home_page_renders_rooms_from_the_database(): void
    {
        $this->room(['room_type' => 'Family room', 'capacity' => 4, 'price_per_night' => 79]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Family room')
            ->assertSee('79');
    }

    public function test_search_hides_rooms_with_an_overlapping_booking(): void
    {
        $free = $this->room(['room_number' => 'FREE']);
        $taken = $this->room(['room_number' => 'TAKEN']);
        $user = User::factory()->create();
        Booking::create([
            'room_id' => $taken->id,
            'guest_id' => $user->id,
            'check_in_date' => now()->addDays(2)->toDateString(),
            'check_out_date' => now()->addDays(5)->toDateString(),
            'status' => 'active',
            'total_amount' => 120,
        ]);

        $response = $this->get(route('availability', [
            'check_in' => now()->addDays(3)->toDateString(),
            'check_out' => now()->addDays(4)->toDateString(),
            'guests' => 2,
        ]));

        $response->assertOk()->assertSee('1 option');
        $this->assertTrue($response->viewData('rooms')->contains('id', $free->id));
        $this->assertFalse($response->viewData('rooms')->contains('id', $taken->id));
    }

    public function test_search_respects_capacity_and_touching_dates(): void
    {
        $this->room(['room_number' => 'SMALL', 'capacity' => 1]);
        $big = $this->room(['room_number' => 'BIG', 'capacity' => 4]);
        $user = User::factory()->create();
        // A booking that ends on our check in day does not block the room.
        Booking::create([
            'room_id' => $big->id,
            'guest_id' => $user->id,
            'check_in_date' => now()->addDays(1)->toDateString(),
            'check_out_date' => now()->addDays(3)->toDateString(),
            'status' => 'active',
            'total_amount' => 80,
        ]);

        $response = $this->get(route('availability', [
            'check_in' => now()->addDays(3)->toDateString(),
            'check_out' => now()->addDays(4)->toDateString(),
            'guests' => 3,
        ]));

        $response->assertOk();
        $this->assertEquals([$big->id], $response->viewData('rooms')->pluck('id')->all());
    }

    public function test_search_validates_input(): void
    {
        $this->get(route('availability', ['check_in' => 'nope', 'check_out' => '', 'guests' => 99]))
            ->assertSessionHasErrors(['check_in', 'check_out', 'guests']);
    }
}
