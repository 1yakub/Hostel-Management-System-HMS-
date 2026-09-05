<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Guest;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

/**
 * Demo guests and bookings around today, so the desk screens show a hostel in use.
 * Idempotent on guest id_number and on (room, check in) for bookings.
 */
class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $guests = collect([
            ['name' => 'Rafi Ahmed', 'phone' => '+880 1711 000101', 'id_number' => 'BD5521 9931'],
            ['name' => 'Hannah Meyer', 'phone' => '+49 176 4400 202', 'id_number' => 'C7K2L44X1'],
            ['name' => 'Daniel Park', 'phone' => '+82 10 5500 0303', 'id_number' => 'M2288 1907'],
            ['name' => 'Lucy Bennett', 'phone' => '+44 7700 900404', 'id_number' => '533148592'],
            ['name' => 'Arjun Mehta', 'phone' => '+91 98200 50505', 'id_number' => 'Z4093812'],
            ['name' => 'Tom Fischer', 'phone' => '+43 660 8800 606', 'id_number' => 'U0931 7724'],
        ])->map(fn ($g) => Guest::updateOrCreate(['id_number' => $g['id_number']], $g));

        // The demo guest account gets its own guest record and one past stay.
        $webGuest = User::where('email', 'guest@example.com')->first();
        $webGuestRecord = $webGuest ? Guest::forUser($webGuest) : null;

        $rooms = Room::all()->keyBy('room_number');
        $today = Carbon::today();

        $plan = [
            // [guest, room number, check in offset in days, nights, status]
            [$guests[0], 'D1-1', -2, 4, 'active'],
            [$guests[1], 'D1-2', -1, 3, 'active'],
            [$guests[2], 'P1', 0, 2, 'active'],
            [$guests[3], 'F1', 2, 3, 'active'],
            [$guests[4], 'D1-3', 4, 2, 'active'],
            [$guests[5], 'P2', -9, 3, 'completed'],
            [$guests[1], 'D1-5', -20, 2, 'completed'],
            [$guests[2], 'D1-4', 1, 1, 'cancelled'],
            [$webGuestRecord, 'D1-6', -30, 2, 'completed'],
        ];

        foreach ($plan as [$guest, $number, $offset, $nights, $status]) {
            $room = $rooms[$number] ?? null;
            if (! $room || ! $guest) {
                continue;
            }
            $checkIn = $today->copy()->addDays($offset);
            $checkOut = $checkIn->copy()->addDays($nights);
            Booking::updateOrCreate(
                ['room_id' => $room->id, 'check_in_date' => $checkIn->toDateString()],
                [
                    'guest_id' => $guest->id,
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
