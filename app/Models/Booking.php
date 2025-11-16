<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'couple_id',
        'vendor_id',
        'quote_id',
        'service_date',
        'total_amount',
        'deposit_percentage',
        'deposit_amount',
        'platform_fee',
        'status',
        'stripe_payment_intent',
        'deposit_paid_at',
        'notes'
    ];

    protected $casts = [
        'service_date' => 'date',
        'total_amount' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
        'platform_fee' => 'decimal:2',
        'deposit_paid_at' => 'datetime'
    ];

    public function couple(): BelongsTo
    {
        return $this->belongsTo(Couple::class);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function quote(): BelongsTo
    {
        return $this->belongsTo(Quote::class);
    }
}