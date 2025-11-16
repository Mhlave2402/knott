<?php

/**
 * ==============================================
 * AUTHORIZATION POLICIES
 * ==============================================
 * Location: app/Policies/QuoteRequestPolicy.php
 */

namespace App\Policies;

use App\Models\QuoteRequest;
use App\Models\User;

class QuoteRequestPolicy
{
    public function view(User $user, QuoteRequest $quoteRequest): bool
    {
        return $user->couple && $user->couple->id === $quoteRequest->couple_id;
    }

    public function update(User $user, QuoteRequest $quoteRequest): bool
    {
        return $user->couple && $user->couple->id === $quoteRequest->couple_id;
    }
}