<?php

// 2. QUOTE RESPONSE MODEL
// File: app/Models/QuoteResponse.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class QuoteResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'quote_request_id',
        'vendor_id',
        'service_id',
        'quoted_price',
        'deposit_amount',
        'inclusions',
        'exclusions',
        'package_details',
        'additional_services',
        'preparation_days',
        'service_duration_hours',
        'terms_conditions',
        'vendor_notes',
        'availability_dates',
        'discount_percentage',
        'status',
        'sent_at',
        'viewed_at',
        'expires_at',
    ];

    protected $casts = [
        'quoted_price' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
        'package_details' => 'array',
        'additional_services' => 'array',
        'availability_dates' => 'array',
        'discount_percentage' => 'decimal:2',
        'sent_at' => 'datetime',
        'viewed_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    // =============================================================================
    // RELATIONSHIPS
    // =============================================================================

    public function quoteRequest(): BelongsTo
    {
        return $this->belongsTo(QuoteRequest::class);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    // =============================================================================
    // SCOPES
    // =============================================================================

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<', now())->where('status', '!=', 'expired');
    }

    // =============================================================================
    // ACCESSORS
    // =============================================================================

    public function getIsExpiredAttribute(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'R ' . number_format($this->quoted_price, 2);
    }

    public function getFormattedDepositAttribute(): string
    {
        return 'R ' . number_format($this->deposit_amount ?? 0, 2);
    }

    public function getTotalWithAddonsAttribute(): float
    {
        $total = $this->quoted_price;
        if ($this->additional_services) {
            foreach ($this->additional_services as $addon) {
                $total += $addon['price'] ?? 0;
            }
        }
        return $total;
    }

    public function getDiscountAmountAttribute(): float
    {
        return $this->quoted_price * ($this->discount_percentage / 100);
    }

    public function getFinalPriceAttribute(): float
    {
        return $this->quoted_price - $this->discount_amount;
    }

    // =============================================================================
    // BUSINESS LOGIC METHODS
    // =============================================================================

    public function send(): bool
    {
        $this->update([
            'status' => 'sent',
            'sent_at' => now(),
            'expires_at' => now()->addDays(7), // 1 week for couple to respond
        ]);

        // Increment quote count on request
        $this->quoteRequest->increment('total_quotes_received');
        
        // Update request status if first quote
        if ($this->quoteRequest->total_quotes_received === 1) {
            $this->quoteRequest->update(['status' => 'quotes_received']);
        }

        return true;
    }

    public function markViewed(): bool
    {
        if (!$this->viewed_at) {
            return $this->update([
                'status' => 'viewed',
                'viewed_at' => now()
            ]);
        }
        return true;
    }

    public function accept(): bool
    {
        return $this->update(['status' => 'accepted']);
    }

    public function decline(): bool
    {
        return $this->update(['status' => 'declined']);
    }
}