<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Guest;
use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

/**
 * Demo guests and bookings around today, so the desk screens show a living hostel.
 * Idempotent on guest id_number and on (room, check in) for bookings.
 */
class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $guests = collect([
            ['name' => 'Amara Okafor', 'phone' => '+234 802 000 0101', 'id_number' => 'A08341122'],
            ['name' => 'Tomás Herrera', 'phone' => '+34 612 000 202', 'id_number' => 'PAB123456'],
            ['name' => 'Mei Lin', 'phone' => '+886 912 000 303', 'id_number' => '312000404'],
            ['name' => 'Jonas Weber', 'phone' => '+49 151 0000 0404', 'id_number' => 'C01X00T47'],
            ['name' => 'Priya Nair', 'phone' => '+91 98200 00505', 'id_number' => 'M4523891'],
            ['name' => 'Sofia Rossi', 'phone' => '+39 333 000 0606', 'id_number' => 'YA1234567'],
        ])->map(fn ($g) => Guest::updateOrCreate(['id_number' => $g['id_number']], $g));

        $rooms = Room::all()->keyBy('room_number');
        $today = Carbon::today();

        $plan = [
            // [guest index, room number, check in offset days, nights, status]
            [0, 'D1-1', -2, 4, 'active'],
            [1, 'D1-2', -1, 3, 'active'],
            [2, 'P1', 0, 2, 'active'],
            [3, 'F1', 2, 3, 'active'],
            [4, 'D1-3', 4, 2, 'active'],
            [5, 'P2', -9, 3, 'completed'],
            [1, 'D1-5', -20, 2, 'completed'],
            [2, 'D1-4', 1, 1, 'cancelled'],
        ];

        foreach ($plan as [$gi, $number, $offset, $nights, $status]) {
            $room = $rooms[$number] ?? null;
            if (! $room) {
                continue;
            }
            $checkIn = $today->copy()->addDays($offset);
            $checkOut = $checkIn->copy()->addDays($nights);
            Booking::updateOrCreate(
                ['room_id' => $room->id, 'check_in_date' => $checkIn->toDateString()],
                [
                    'guest_id' => $guests[$gi]->id,
                    'check_out_date' => $checkOut->toDateString(),
                    'status' => $status,
                    'total_amount' => $room->price_per_night * $nights,
                ],
            );
            if ($status === 'active' && $checkIn->lte($today) && $checkOut->gt($today)) {
                $room->update(['status' => 'occupied']);
            }
        }
    }
}
