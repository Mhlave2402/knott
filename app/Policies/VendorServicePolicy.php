<?php
namespace App\Policies;

use App\Models\User;
use App\Models\VendorService;

class VendorServicePolicy
{
    public function update(User $user, VendorService $service): bool
    {
        return $user->id === $service->vendorProfile->user_id;
    }

    public function delete(User $user, VendorService $service): bool
    {
        return $user->id === $service->vendorProfile->user_id;
    }
}