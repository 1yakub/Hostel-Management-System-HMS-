<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

/** Staff run bookings at the desk; a guest may look at their own. */
class BookingPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        return $user->is_staff ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Booking $booking): bool
    {
        return $booking->guest?->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Booking $booking): bool
    {
        return false;
    }

    public function delete(User $user, Booking $booking): bool
    {
        return false;
    }
}
