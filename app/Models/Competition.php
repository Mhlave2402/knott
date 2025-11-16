<?php

// 5. COMPETITION MODEL
// File: app/Models/Competition.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Competition extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'terms_and_conditions',
        'start_date',
        'end_date',
        'voting_end_date',
        'winner_announcement_date',
        'rules',
        'eligibility_criteria',
        'prizes',
        'categories',
        'min_vendors_required',
        'max_photos',
        'max_videos',
        'public_voting_enabled',
        'public_voting_weight',
        'admin_judging_weight',
        'judging_criteria',
        'is_active',
        'is_featured',
        'total_entries',
        'total_votes',
        'banner_image',
        'winner_badge_image',
        'sponsor_details',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'voting_end_date' => 'date',
        'winner_announcement_date' => 'date',
        'rules' => 'array',
        'eligibility_criteria' => 'array',
        'prizes' => 'array',
        'categories' => 'array',
        'judging_criteria' => 'array',
        'sponsor_details' => 'array',
        'public_voting_enabled' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    // =============================================================================
    // RELATIONSHIPS
    // =============================================================================

    public function entries(): HasMany
    {
        return $this->hasMany(CompetitionEntry::class);
    }

    public function approvedEntries(): HasMany
    {
        return $this->hasMany(CompetitionEntry::class)
            ->whereIn('status', ['approved', 'shortlisted', 'winner', 'runner_up']);
    }

    public function winningEntries(): HasMany
    {
        return $this->hasMany(CompetitionEntry::class)
            ->whereIn('status', ['winner', 'runner_up'])
            ->orderBy('final_rank');
    }

    public function votes(): HasMany
    {
        return $this->hasManyThrough(
            CompetitionVote::class,
            CompetitionEntry::class,
            'competition_id',
            'competition_entry_id'
        );
    }

    // =============================================================================
    // SCOPES
    // =============================================================================

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOpen($query)
    {
        return $query->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->where('is_active', true);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', now());
    }

    public function scopeClosed($query)
    {
        return $query->where('end_date', '<', now());
    }

    public function scopeVotingOpen($query)
    {
        return $query->where('voting_end_date', '>=', now())
            ->where('end_date', '<', now())
            ->where('public_voting_enabled', true);
    }

    // =============================================================================
    // ACCESSORS
    // =============================================================================

    public function getIsOpenAttribute(): bool
    {
        return $this->start_date->isPast() && 
               $this->end_date->isFuture() && 
               $this->is_active;
    }

    public function getIsClosedAttribute(): bool
    {
        return $this->end_date->isPast();
    }

    public function getVotingIsOpenAttribute(): bool
    {
        return $this->public_voting_enabled &&
               $this->end_date->isPast() &&
               ($this->voting_end_date ? $this->voting_end_date->isFuture() : false);
    }

    public function getStatusAttribute(): string
    {
        if (!$this->is_active) return 'inactive';
        if ($this->start_date->isFuture()) return 'upcoming';
        if ($this->is_open) return 'open';
        if ($this->voting_is_open) return 'voting';
        if ($this->winner_announcement_date->isFuture()) return 'judging';
        return 'completed';
    }

    public function getDaysRemainingAttribute(): int
    {
        if ($this->is_open) {
            return now()->diffInDays($this->end_date);
        }
        if ($this->voting_is_open) {
            return now()->diffInDays($this->voting_end_date);
        }
        return 0;
    }

    public function getFormattedPrizesAttribute(): string
    {
        $prizes = $this->prizes ?? [];
        $formatted = [];
        
        foreach ($prizes as $position => $prize) {
            $formatted[] = ucfirst($position) . ': ' . $prize;
        }
        
        return implode(', ', $formatted);
    }

    // =============================================================================
    // MUTATORS
    // =============================================================================

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    // =============================================================================
    // BUSINESS LOGIC METHODS
    // =============================================================================

    public function canAcceptEntries(): bool
    {
        return $this->is_open;
    }

    public function canReceiveVotes(): bool
    {
        return $this->voting_is_open;
    }

    public function incrementEntryCount(): void
    {
        $this->increment('total_entries');
    }

    public function incrementVoteCount(): void
    {
        $this->increment('total_votes');
    }

    public function getTopEntries($limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return $this->approvedEntries()
            ->orderByDesc('final_score')
            ->orderByDesc('public_votes')
            ->limit($limit)
            ->get();
    }

    public function calculateFinalScores(): void
    {
        $this->approvedEntries()->each(function ($entry) {
            $publicScore = 0;
            $adminScore = $entry->admin_score ?? 0;
            
            if ($this->public_voting_enabled && $this->total_votes > 0) {
                $publicScore = ($entry->public_votes / $this->total_votes) * 100;
            }
            
            $finalScore = (
                ($publicScore * $this->public_voting_weight / 100) +
                ($adminScore * $this->admin_judging_weight / 100)
            );
            
            $entry->update(['final_score' => round($finalScore, 2)]);
        });
        
        // Assign rankings
        $this->assignRankings();
    }

    private function assignRankings(): void
    {
        $entries = $this->approvedEntries()
            ->orderByDesc('final_score')
            ->get();
            
        $entries->each(function ($entry, $index) {
            $rank = $index + 1;
            $status = match($rank) {
                1 => 'winner',
                2, 3 => 'runner_up',
                default => $entry->status === 'shortlisted' ? 'shortlisted' : 'approved'
            };
            
            $entry->update([
                'final_rank' => $rank,
                'status' => $status
            ]);
        });
    }
}