<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contribution extends Model
{
    protected $fillable = [
        'gift_well_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'amount',
        'guest_fee',
        'total_paid',
        'message',
        'is_anonymous',
        'status',
        'stripe_payment_intent',
        'paid_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'guest_fee' => 'decimal:2',
        'total_paid' => 'decimal:2',
        'is_anonymous' => 'boolean',
        'paid_at' => 'datetime'
    ];

    public function giftWell(): BelongsTo
    {
        return $this->belongsTo(GiftWell::class);
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->is_anonymous ? 'Anonymous Guest' : $this->guest_name;
    }
}