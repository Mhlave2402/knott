<?php
namespace App\Policies;

use App\Models\User;
use App\Models\VendorPortfolio;

class VendorPortfolioPolicy
{
    public function delete(User $user, VendorPortfolio $portfolio): bool
    {
        return $user->id === $portfolio->vendorProfile->user_id;
    }
}