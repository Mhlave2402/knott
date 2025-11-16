<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BudgetCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'couple_profile_id', 'name', 'allocated_amount', 'spent_amount',
        'notes', 'is_required', 'sort_order'
    ];

    protected $casts = [
        'allocated_amount' => 'decimal:2',
        'spent_amount' => 'decimal:2',
        'is_required' => 'boolean'
    ];

    public function coupleProfile(): BelongsTo
    {
        return $this->belongsTo(CoupleProfile::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(BudgetExpense::class);
    }

    public function getRemainingAmountAttribute(): float
    {
        return $this->allocated_amount - $this->spent_amount;
    }

    public function getUtilizationPercentageAttribute(): float
    {
        if ($this->allocated_amount == 0) {
            return 0;
        }
        
        return ($this->spent_amount / $this->allocated_amount) * 100;
    }

    public function getIsOverBudgetAttribute(): bool
    {
        return $this->spent_amount > $this->allocated_amount;
    }

    public function updateSpentAmount(): void
    {
        $this->spent_amount = $this->expenses()->sum('amount');
        $this->save();
    }
}