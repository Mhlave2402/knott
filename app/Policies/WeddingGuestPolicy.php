<?php
namespace App\Policies;

use App\Models\User;
use App\Models\WeddingGuest;

class WeddingGuestPolicy
{
    public function update(User $user, WeddingGuest $guest): bool
    {
        return $user->id === $guest->coupleProfile->user_id;
    }

    public function delete(User $user, WeddingGuest $guest): bool
    {
        return $user->id === $guest->coupleProfile->user_id;
    }
}