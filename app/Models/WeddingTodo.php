<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeddingTodo extends Model
{
    use HasFactory;

    protected $fillable = [
        'couple_profile_id', 'title', 'description', 'priority',
        'due_date', 'is_completed', 'completed_at', 'sort_order'
    ];

    protected $casts = [
        'due_date' => 'date',
        'is_completed' => 'boolean',
        'completed_at' => 'datetime'
    ];

    public function coupleProfile(): BelongsTo
    {
        return $this->belongsTo(CoupleProfile::class);
    }

    public function getPriorityColorAttribute(): string
    {
        return match($this->priority) {
            'high' => 'red',
            'medium' => 'yellow',
            'low' => 'green'
        };
    }

    public function getPriorityLabelAttribute(): string
    {
        return match($this->priority) {
            'high' => 'High Priority',
            'medium' => 'Medium Priority',
            'low' => 'Low Priority'
        };
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->due_date && $this->due_date->isPast() && !$this->is_completed;
    }

    public function scopeCompleted($query)
    {
        return $query->where('is_completed', true);
    }

    public function scopePending($query)
    {
        return $query->where('is_completed', false);
    }

    public function scopeOverdue($query)
    {
        return $query->where('is_completed', false)
                    ->whereDate('due_date', '<', now());
    }
}