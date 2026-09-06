<?php

namespace App\Policies;

use App\Models\Guest;
use App\Models\User;

/** Guest records belong to the desk; a signed in guest sees their own through /my. */
class GuestPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        return $user->is_staff ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Guest $guest): bool
    {
        return $guest->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Guest $guest): bool
    {
        return false;
    }

    public function delete(User $user, Guest $guest): bool
    {
        return false;
    }
}
