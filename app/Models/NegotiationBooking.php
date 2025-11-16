<?php

// 4. NEGOTIATION BOOKING MODEL
// File: app/Models/NegotiationBooking.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class NegotiationBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'couple_id',
        'negotiator_id',
        'scheduled_date',
        'duration_hours',
        'meeting_type',
        'meeting_location',
        'video_call_link',
        'family_details',
        'cultural_background',
        'negotiation_goals',
        'special_requirements',
        'preferred_languages',
        'consultation_cost',
        'total_cost',
        'payment_status',
        'payment_reference',
        'status',
        'preparation_notes',
        'session_summary',
        'outcomes',
        'follow_up_required',
        'follow_up_date',
        'rating',
        'review',
        'couple_feedback',
        'negotiator_feedback',
        'confirmed_at',
        'completed_at',
    ];

    protected $casts = [
        'scheduled_date' => 'datetime',
        'family_details' => 'array',
        'preferred_languages' => 'array',
        'outcomes' => 'array',
        'consultation_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'follow_up_required' => 'boolean',
        'follow_up_date' => 'date',
        'confirmed_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // =============================================================================
    // RELATIONSHIPS
    // =============================================================================

    public function couple(): BelongsTo
    {
        return $this->belongsTo(User::class, 'couple_id');
    }

    public function negotiator(): BelongsTo
    {
        return $this->belongsTo(Negotiator::class);
    }

    // =============================================================================
    // SCOPES
    // =============================================================================

    public function scopeUpcoming($query)
    {
        return $query->where('scheduled_date', '>', now())
            ->orderBy('scheduled_date');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('scheduled_date', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('scheduled_date', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // =============================================================================
    // ACCESSORS
    // =============================================================================

    public function getFormattedDateAttribute(): string
    {
        return $this->scheduled_date->format('M j, Y \a\t g:i A');
    }

    public function getFormattedCostAttribute(): string
    {
        return 'R ' . number_format($this->total_cost, 2);
    }

    public function getIsUpcomingAttribute(): bool
    {
        return $this->scheduled_date->isFuture();
    }

    public function getIsTodayAttribute(): bool
    {
        return $this->scheduled_date->isToday();
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'yellow',
            'confirmed' => 'blue',
            'completed' => 'green',
            'cancelled' => 'red',
            'no_show' => 'gray',
            default => 'gray'
        };
    }

    public function getMeetingTypeDisplayAttribute(): string
    {
        return match($this->meeting_type) {
            'in_person' => 'In Person',
            'video_call' => 'Video Call',
            'phone_call' => 'Phone Call',
            default => ucfirst($this->meeting_type)
        };
    }

    // =============================================================================
    // BUSINESS LOGIC METHODS
    // =============================================================================

    public function confirm(): bool
    {
        return $this->update([
            'status' => 'confirmed',
            'confirmed_at' => now()
        ]);
    }

    public function cancel(): bool
    {
        return $this->update(['status' => 'cancelled']);
    }

    public function markCompleted($outcomes = null): bool
    {
        $data = [
            'status' => 'completed',
            'completed_at' => now()
        ];
        
        if ($outcomes) {
            $data['outcomes'] = $outcomes;
        }
        
        // Update negotiator's statistics
        $this->negotiator->incrementNegotiations(true);
        
        return $this->update($data);
    }

    public function markNoShow(): bool
    {
        return $this->update(['status' => 'no_show']);
    }

    public function canBeRated(): bool
    {
        return $this->status === 'completed' && !$this->rating;
    }

    public function addRating(int $rating, string $review = null): bool
    {
        $data = ['rating' => $rating];
        if ($review) {
            $data['review'] = $review;
        }
        
        $result = $this->update($data);
        
        // Update negotiator's average rating
        $this->negotiator->updateRating();
        
        return $result;
    }

    public function requiresFollowUp(): bool
    {
        return $this->follow_up_required && 
               $this->follow_up_date && 
               $this->follow_up_date->isFuture();
    }

    public function generateVideoCallLink(): string
    {
        // This would integrate with Zoom, Teams, or similar service
        // For now, return a placeholder
        return 'https://meet.knott.co.za/room/' . $this->id;
    }
}