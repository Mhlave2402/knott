---

## 📅 Week 15-16: Gift Well System

### **Backend Implementation**

#### **File: `app/Models/GiftWell.php`**
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class GiftWell extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'couple_id',
        'title',
        'description',
        'target_amount',
        'total_amount',
        'withdrawal_fee',
        'status',
        'wedding_date',
        'is_public',
        'thank_you_message'
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'withdrawal_fee' => 'decimal:2',
        'wedding_date' => 'date',
        'is_public' => 'boolean'
    ];

    public function couple(): BelongsTo
    {
        return $this->belongsTo(Couple::class);
    }

    public function contributions(): HasMany
    {
        return $this->hasMany(Contribution::class);
    }

    public function getProgressPercentageAttribute(): int
    {
        if (!$this->target_amount || $this->target_amount == 0) {
            return 0;
        }
        
        return min(100, round(($this->total_amount / $this->target_amount) * 100));
    }

    public function getWithdrawableAmountAttribute(): float
    {
        $fee = $this->total_amount * config('payment.fees.gift_well_withdrawal_fee');
        return $this->total_amount - $fee;
    }
}