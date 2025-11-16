<?php
// 1. QUOTE REQUEST MODEL
// File: app/Models/QuoteRequest.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class QuoteRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'couple_id',
        'event_type',
        'event_date',
        'venue_location',
        'guest_count',
        'total_budget',
        'category_budgets',
        'style_preference',
        'color_scheme',
        'special_requirements',
        'inspiration_notes',
        'urgency',
        'status',
        'matched_vendors',
        'ai_analysis',
        'submitted_at',
        'expires_at',
    ];

    protected $casts = [
        'event_date' => 'date',
        'category_budgets' => 'array',
        'color_scheme' => 'array',
        'matched_vendors' => 'array',
        'ai_analysis' => 'array',
        'total_budget' => 'decimal:2',
        'submitted_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    // =============================================================================
    // RELATIONSHIPS
    // =============================================================================

    public function couple(): BelongsTo
    {
        return $this->belongsTo(User::class, 'couple_id');
    }

    public function quotes(): HasMany
    {
        return $this->hasMany(QuoteResponse::class);
    }

    public function pendingQuotes(): HasMany
    {
        return $this->hasMany(QuoteResponse::class)->where('status', 'pending');
    }

    public function sentQuotes(): HasMany
    {
        return $this->hasMany(QuoteResponse::class)->where('status', 'sent');
    }

    public function acceptedQuotes(): HasMany
    {
        return $this->hasMany(QuoteResponse::class)->where('status', 'accepted');
    }

    public function aiLogs(): HasMany
    {
        return $this->hasMany(AIMatchingLog::class);
    }

    // =============================================================================
    // SCOPES
    // =============================================================================

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['submitted', 'quotes_received']);
    }

    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<', now())->where('status', '!=', 'expired');
    }

    public function scopeForLocation($query, $location)
    {
        return $query->where('venue_location', 'LIKE', "%{$location}%");
    }

    public function scopeWithinBudget($query, $minBudget, $maxBudget)
    {
        return $query->whereBetween('total_budget', [$minBudget, $maxBudget]);
    }

    // =============================================================================
    // ACCESSORS & MUTATORS
    // =============================================================================

    public function getIsExpiredAttribute(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function getDaysUntilEventAttribute(): int
    {
        return $this->event_date ? now()->diffInDays($this->event_date) : 0;
    }

    public function getTotalQuotesReceivedAttribute(): int
    {
        return $this->quotes()->count();
    }

    public function getAveragequotePriceAttribute()
    {
        return $this->quotes()->avg('quoted_price');
    }

    public function getFormattedBudgetAttribute(): string
    {
        return 'R ' . number_format($this->total_budget, 2);
    }

    // =============================================================================
    // BUSINESS LOGIC METHODS
    // =============================================================================

    public function submit(): bool
    {
        $this->update([
            'status' => 'submitted',
            'submitted_at' => now(),
            'expires_at' => now()->addDays(14), // 2 weeks to receive quotes
        ]);

        return true;
    }

    public function markExpired(): bool
    {
        return $this->update(['status' => 'expired']);
    }

    public function extendDeadline(int $days = 7): bool
    {
        return $this->update([
            'expires_at' => $this->expires_at->addDays($days)
        ]);
    }

    public function getBudgetForCategory(string $category): float
    {
        $budgets = $this->category_budgets ?? [];
        return $budgets[$category] ?? 0;
    }

    public function getMatchingScore(User $vendor): float
    {
        $matched = $this->matched_vendors ?? [];
        foreach ($matched as $match) {
            if ($match['vendor_id'] == $vendor->id) {
                return $match['confidence_score'] ?? 0;
            }
        }
        return 0;
    }

    protected static function booted()
    {
        // Auto-increment total_quotes_received when new quote is added
        static::created(function ($quoteRequest) {
            $quoteRequest->update(['total_quotes_received' => 0]);
        });
    }
}