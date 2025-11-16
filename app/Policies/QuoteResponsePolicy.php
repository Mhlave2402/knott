<?php

/**
 * Location: app/Policies/QuoteResponsePolicy.php
 */

namespace App\Policies;

use App\Models\QuoteResponse;
use App\Models\User;

class QuoteResponsePolicy
{
    public function view(User $user, QuoteResponse $quoteResponse): bool
    {
        return $user->vendor && $user->vendor->id === $quoteResponse->vendor_id;
    }

    public function update(User $user, QuoteResponse $quoteResponse): bool
    {
        return $user->vendor && $user->vendor->id === $quoteResponse->vendor_id;
    }
}