<?php

// 6. COMPETITION ENTRY MODEL
// File: app/Models/CompetitionEntry.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class CompetitionEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'competition_id',
        'couple_id',
        'entry_title',
        'wedding_date',
        'venue_name',
        'venue_location',
        'guest_count',
        'total_budget',
        'wedding_theme',
        'wedding_story',
        'what_made_it_special',
        'vendor_list',
        'photos',
        'videos',
        'featured_photo',
        'photo_credits',
        'consent_social_media',
        'consent_marketing',
        'consent_vendor_promotion',
        'hashtags',
        'status',
        'public_votes',
        'admin_score',
        'final_score',
        'final_rank',
        'admin_notes',
        'judge_feedback',
        'score_breakdown',
        'is_featured',
        'submitted_at',
        'approved_at',
    ];

    protected $casts = [
        'wedding_date' => 'date',
        'total_budget' => 'decimal:2',
        'vendor_list' => 'array',
        'photos' => 'array',
        'videos' => 'array',
        'photo_credits' => 'array',
        'hashtags' => 'array',
        'score_breakdown' => 'array',
        'consent_social_media' => 'boolean',
        'consent_marketing' => 'boolean',
        'consent_vendor_promotion' => 'boolean',
        'is_featured' => 'boolean',
        'admin_score' => 'decimal:2',
        'final_score' => 'decimal:2',
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    // =============================================================================
    // RELATIONSHIPS
    // =============================================================================

    public function competition(): BelongsTo
    {
        return $this->belongsTo(Competition::class);
    }

    public function couple(): BelongsTo
    {
        return $this->belongsTo(User::class, 'couple_id');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(CompetitionVote::class);
    }

    // =============================================================================
    // SCOPES
    // =============================================================================

    public function scopeApproved($query)
    {
        return $query->whereIn('status', ['approved', 'shortlisted', 'winner', 'runner_up']);
    }

    public function scopeWinners($query)
    {
        return $query->whereIn('status', ['winner', 'runner_up'])
            ->orderBy('final_rank');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByTheme($query, $theme)
    {
        return $query->where('wedding_theme', 'LIKE', "%{$theme}%");
    }

    // =============================================================================
    // ACCESSORS
    // =============================================================================

    public function getFeaturedPhotoUrlAttribute(): string
    {
        if ($this->featured_photo) {
            return Storage::url($this->featured_photo);
        }
        
        $photos = $this->photos ?? [];
        if (!empty($photos)) {
            return Storage::url($photos[0]);
        }
        
        return asset('images/default-wedding.jpg');
    }

    public function getPhotoUrlsAttribute(): array
    {
        return collect($this->photos ?? [])
            ->map(fn($photo) => Storage::url($photo))
            ->toArray();
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'submitted' => 'blue',
            'under_review' => 'yellow',
            'approved' => 'green',
            'shortlisted' => 'purple',
            'winner' => 'gold',
            'runner_up' => 'silver',
            'rejected' => 'red',
            default => 'gray'
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'winner' => '🏆 Winner',
            'runner_up' => '🥈 Runner Up',
            'shortlisted' => '⭐ Shortlisted',
            'approved' => '✅ Approved',
            default => ucfirst(str_replace('_', ' ', $this->status))
        };
    }

    public function getCanVoteAttribute(): bool
    {
        return $this->status === 'approved' && 
               $this->competition->voting_is_open;
    }

    public function getVendorNamesAttribute(): array
    {
        return collect($this->vendor_list ?? [])
            ->pluck('name')
            ->toArray();
    }

    // =============================================================================
    // BUSINESS LOGIC METHODS
    // =============================================================================

    public function submit(): bool
    {
        $this->update([
            'status' => 'submitted',
            'submitted_at' => now()
        ]);
        
        $this->competition->incrementEntryCount();
        
        return true;
    }

    public function approve(): bool
    {
        return $this->update([
            'status' => 'approved',
            'approved_at' => now()
        ]);
    }

    public function reject($reason = null): bool
    {
        $data = ['status' => 'rejected'];
        if ($reason) {
            $data['admin_notes'] = $reason;
        }
        return $this->update($data);
    }

    public function shortlist(): bool
    {
        return $this->update(['status' => 'shortlisted']);
    }

    public function markAsWinner($rank = 1): bool
    {
        $status = $rank === 1 ? 'winner' : 'runner_up';
        return $this->update([
            'status' => $status,
            'final_rank' => $rank
        ]);
    }

    public function addVote($userId = null, $guestEmail = null, $ipAddress = null): bool
    {
        if (!$this->can_vote) {
            return false;
        }
        
        // Check for duplicate votes
        $existingVote = $this->votes()
            ->where(function ($query) use ($userId, $guestEmail) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('guest_email', $guestEmail);
                }
            })
            ->exists();
            
        if ($existingVote) {
            return false;
        }
        
        $this->votes()->create([
            'user_id' => $userId,
            'guest_email' => $guestEmail,
            'ip_address' => $ipAddress,
            'user_agent' => request()->userAgent(),
        ]);
        
        $this->increment('public_votes');
        $this->competition->incrementVoteCount();
        
        return true;
    }

    public function getTotalScore(): float
    {
        if ($this->final_score) {
            return $this->final_score;
        }
        
        $competition = $this->competition;
        $publicScore = 0;
        $adminScore = $this->admin_score ?? 0;
        
        if ($competition->public_voting_enabled && $competition->total_votes > 0) {
            $publicScore = ($this->public_votes / $competition->total_votes) * 100;
        }
        
        return (
            ($publicScore * $competition->public_voting_weight / 100) +
            ($adminScore * $competition->admin_judging_weight / 100)
        );
    }
}