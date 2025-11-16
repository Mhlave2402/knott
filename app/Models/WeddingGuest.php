<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeddingGuest extends Model
{
    use HasFactory;

    protected $fillable = [
        'couple_profile_id', 'name', 'email', 'phone', 'category',
        'rsvp_status', 'plus_one', 'dietary_requirements', 'notes', 'rsvp_date'
    ];

    protected $casts = [
        'rsvp_date' => 'datetime'
    ];

    public function coupleProfile(): BelongsTo
    {
        return $this->belongsTo(CoupleProfile::class);
    }

    public function getTotalGuestCountAttribute(): int
    {
        return 1 + $this->plus_one;
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->rsvp_status) {
            'attending' => 'green',
            'declined' => 'red',
            'maybe' => 'yellow',
            default => 'gray'
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->rsvp_status) {
            'attending' => 'Attending',
            'declined' => 'Declined',
            'maybe' => 'Maybe',
            default => 'Pending'
        };
    }

    public function scopeAttending($query)
    {
        return $query->where('rsvp_status', 'attending');
    }

    public function scopePending($query)
    {
        return $query->where('rsvp_status', 'pending');
    }

    public function scopeDeclined($query)
    {
        return $query->where('rsvp_status', 'declined');
    }
}