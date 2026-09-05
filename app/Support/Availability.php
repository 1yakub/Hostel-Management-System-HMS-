<?php

namespace App\Support;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Support\Collection;

/**
 * Availability rules in one place so the site, the booking form, the staff tools
 * and the assistant all answer the same way.
 */
class Availability
{
    /** Statuses that hold a room. Cancelled and checked out bookings free it. */
    public const HOLDING_STATUSES = ['active', 'confirmed', 'checked_in'];

    /** Rooms with capacity for the party and no overlapping booking in the window. */
    public static function roomsFreeBetween(string $checkIn, string $checkOut, int $guests = 1): Collection
    {
        return Room::query()
            ->where('status', 'available')
            ->where('capacity', '>=', $guests)
            ->whereDoesntHave('bookings', function ($q) use ($checkIn, $checkOut) {
                $q->whereIn('status', self::HOLDING_STATUSES)
                    ->whereDate('check_in_date', '<', $checkOut)
                    ->whereDate('check_out_date', '>', $checkIn);
            })
            ->orderBy('price_per_night')
            ->get();
    }

    public static function isRoomFree(Room $room, string $checkIn, string $checkOut): bool
    {
        if ($room->status !== 'available') {
            return false;
        }

        return ! Booking::query()
            ->where('room_id', $room->id)
            ->whereIn('status', self::HOLDING_STATUSES)
            ->whereDate('check_in_date', '<', $checkOut)
            ->whereDate('check_out_date', '>', $checkIn)
            ->exists();
    }

    public static function freeRoomCountForNight(string $date): int
    {
        $next = \Carbon\Carbon::parse($date)->addDay()->toDateString();

        return self::roomsFreeBetween($date, $next)->count();
    }
}
