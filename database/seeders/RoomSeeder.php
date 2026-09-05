<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Demo inventory for the fictional hostel. Idempotent: rooms are matched on room_number,
     * so the nightly demo reset and repeated seeding never duplicate rows.
     */
    public function run(): void
    {
        $dormAmenities = ['Lockable drawer', 'Reading light', 'Privacy curtain', 'Shared bathroom', 'Breakfast included', 'Wi-Fi'];
        $privateAmenities = ['Double bed', 'Desk', 'Window', 'Shared bathroom', 'Breakfast included', 'Wi-Fi'];
        $familyAmenities = ['Double bed plus bunk', 'Private bathroom', 'Rug and table', 'Breakfast included', 'Wi-Fi'];

        $rooms = [
            // Six bed dorm: one row per bed, so a dorm bed books like a room.
            ...collect(range(1, 6))->map(fn ($n) => [
                'room_number' => 'D1-'.$n,
                'room_type' => 'Dorm bed',
                'description' => 'A bed in our six bed dorm. Solid oak bunks, a curtain, a light and a drawer that locks. Quiet hours from 11 PM.',
                'capacity' => 1,
                'price_per_night' => 18.00,
                'status' => 'available',
                'featured_image' => '/images/room-dorm.webp',
                'gallery_images' => ['/images/room-dorm.webp', '/images/hero-common-room.webp'],
                'amenities' => $dormAmenities,
            ])->all(),
            [
                'room_number' => 'P1',
                'room_type' => 'Private double',
                'description' => 'A small private room with a low wooden bed, a desk by the window and a door that is yours. Shared bathroom down the hall.',
                'capacity' => 2,
                'price_per_night' => 48.00,
                'status' => 'available',
                'featured_image' => '/images/room-private.webp',
                'gallery_images' => ['/images/room-private.webp'],
                'amenities' => $privateAmenities,
            ],
            [
                'room_number' => 'P2',
                'room_type' => 'Private double',
                'description' => 'Same as P1, on the courtyard side. Morning light, birds, the smell of coffee from the cafe below.',
                'capacity' => 2,
                'price_per_night' => 48.00,
                'status' => 'available',
                'featured_image' => '/images/room-private.webp',
                'gallery_images' => ['/images/room-private.webp'],
                'amenities' => $privateAmenities,
            ],
            [
                'room_number' => 'F1',
                'room_type' => 'Family room',
                'description' => 'One double bed and a sturdy bunk, a rug for the floor games, and the only private bathroom in the house.',
                'capacity' => 4,
                'price_per_night' => 79.00,
                'status' => 'available',
                'featured_image' => '/images/room-family.webp',
                'gallery_images' => ['/images/room-family.webp'],
                'amenities' => $familyAmenities,
            ],
        ];

        foreach ($rooms as $room) {
            Room::updateOrCreate(['room_number' => $room['room_number']], $room);
        }
    }
}
