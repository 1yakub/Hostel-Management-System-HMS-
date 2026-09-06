<?php

namespace App\Policies;

use App\Models\Room;
use App\Models\User;

/** Rooms are desk records: staff manage them, nobody else touches them. */
class RoomPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        return $user->is_staff ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Room $room): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Room $room): bool
    {
        return false;
    }

    public function delete(User $user, Room $room): bool
    {
        return false;
    }
}
