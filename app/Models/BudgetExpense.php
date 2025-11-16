<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class BudgetExpense extends Model
{
    use HasFactory;

    protected $fillable = [
        'budget_category_id', 'description', 'amount', 'expense_date',
        'vendor_name', 'notes', 'receipt_path'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'expense_date' => 'date'
    ];

    public function budgetCategory(): BelongsTo
    {
        return $this->belongsTo(BudgetCategory::class);
    }

    public function getReceiptUrlAttribute(): ?string
    {
        return $this->receipt_path ? Storage::url($this->receipt_path) : null;
    }

    public function getHasReceiptAttribute(): bool
    {
        return !is_null($this->receipt_path);
    }

    protected static function booted()
    {
        static::created(function ($expense) {
            $expense->budgetCategory->updateSpentAmount();
        });

        static::updated(function ($expense) {
            $expense->budgetCategory->updateSpentAmount();
        });

        static::deleted(function ($expense) {
            $expense->budgetCategory->updateSpentAmount();
        });
    }
}