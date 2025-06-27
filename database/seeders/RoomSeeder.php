<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = [
            [
                'room_number' => '101',
                'capacity' => 2,
                'price_per_night' => 100.00,
                'status' => 'available',
                'featured_image' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
                    'https://images.unsplash.com/photo-1590490360182-c33d57733427?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'
                ],
                'description' => 'Luxurious deluxe room with city view',
                'room_type' => 'Deluxe Room',
                'amenities' => ['WiFi', 'Mini Bar', 'Room Service', 'TV']
            ],
            [
                'room_number' => '102',
                'capacity' => 2,
                'price_per_night' => 100.00,
                'status' => 'available',
                'featured_image' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
                    'https://images.unsplash.com/photo-1590490360182-c33d57733427?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'
                ],
                'description' => 'Elegant deluxe room with garden view',
                'room_type' => 'Deluxe Room',
                'amenities' => ['WiFi', 'Mini Bar', 'Room Service', 'TV']
            ],
            [
                'room_number' => '201',
                'capacity' => 3,
                'price_per_night' => 150.00,
                'status' => 'available'
            ],
            [
                'room_number' => '202',
                'capacity' => 3,
                'price_per_night' => 150.00,
                'status' => 'available'
            ],
            [
                'room_number' => '301',
                'capacity' => 4,
                'price_per_night' => 200.00,
                'status' => 'available'
            ],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}
