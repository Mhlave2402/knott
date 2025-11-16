<?php

namespace App\Collections;

use Illuminate\Database\Eloquent\Collection;

class QuoteRequestCollection extends Collection
{
    /**
     * Get requests that are about to expire
     */
    public function expiringSoon($days = 3): self
    {
        return $this->filter(function ($request) use ($days) {
            return $request->expires_at && 
                   $request->expires_at->diffInDays(now()) <= $days &&
                   $request->expires_at->isFuture();
        });
    }
    
    /**
     * Get average budget across requests
     */
    public function averageBudget(): float
    {
        return $this->avg('total_budget') ?? 0;
    }
    
    /**
     * Group by location
     */
    public function groupByLocation(): array
    {
        return $this->groupBy('venue_location')->map->count()->toArray();
    }
    
    /**
     * Get requests by style preference
     */
    public function byStyle(string $style): self
    {
        return $this->filter(function ($request) use ($style) {
            return $request->style_preference === $style;
        });
    }
}