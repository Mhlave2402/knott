<?php

// 7. COMPETITION VOTE MODEL
// File: app/Models/CompetitionVote.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompetitionVote extends Model
{
    use HasFactory;

    protected $fillable = [
        'competition_entry_id',
        'user_id',
        'guest_email',
        'ip_address',
        'user_agent',
        'vote_value',
        'comment',
        'is_verified',
        'voted_at',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'voted_at' => 'datetime',
    ];

    // =============================================================================
    // RELATIONSHIPS
    // =============================================================================

    public function entry(): BelongsTo
    {
        return $this->belongsTo(CompetitionEntry::class, 'competition_entry_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // =============================================================================
    // SCOPES
    // =============================================================================

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeFromRegisteredUsers($query)
    {
        return $query->whereNotNull('user_id');
    }

    public function scopeFromGuests($query)
    {
        return $query->whereNull('user_id')->whereNotNull('guest_email');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('voted_at', today());
    }

    // =============================================================================
    // ACCESSORS
    // =============================================================================

    public function getVoterNameAttribute(): string
    {
        if ($this->user) {
            return $this->user->name;
        }
        return $this->guest_email ? 'Guest Voter' : 'Anonymous';
    }

    public function getIsFromRegisteredUserAttribute(): bool
    {
        return !is_null($this->user_id);
    }

    // =============================================================================
    // BUSINESS LOGIC METHODS
    // =============================================================================

    public function verify(): bool
    {
        return $this->update(['is_verified' => true]);
    }

    public function markAsSpam(): bool
    {
        return $this->update(['is_verified' => false]);
    }

    protected static function booted()
    {
        static::creating(function ($vote) {
            $vote->voted_at = $vote->voted_at ?? now();
        });
    }
}
