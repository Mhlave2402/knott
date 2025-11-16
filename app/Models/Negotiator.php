<?php

// 3. NEGOTIATOR MODEL
// File: app/Models/Negotiator.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Negotiator extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'title',
        'bio',
        'profile_photo',
        'languages_spoken',
        'cultural_expertise',
        'regions_served',
        'years_experience',
        'consultation_fee',
        'hourly_rate',
        'full_service_rate',
        'availability_hours',
        'availability_days',
        'primary_location',
        'travel_available',
        'max_travel_distance',
        'travel_fee',
        'rating',
        'total_negotiations',
        'successful_negotiations',
        'is_verified',
        'is_featured',
        'verified_at',
        'cultural_notes',
        'approach_philosophy',
        'testimonials',
        'accepts_video_calls',
        'accepts_phone_calls',
        'weekend_availability',
        'status',
    ];

    protected $casts = [
        'languages_spoken' => 'array',
        'cultural_expertise' => 'array',
        'regions_served' => 'array',
        'availability_hours' => 'array',
        'availability_days' => 'array',
        'testimonials' => 'array',
        'consultation_fee' => 'decimal:2',
        'hourly_rate' => 'decimal:2',
        'full_service_rate' => 'decimal:2',
        'travel_fee' => 'decimal:2',
        'rating' => 'decimal:2',
        'travel_available' => 'boolean',
        'is_verified' => 'boolean',
        'is_featured' => 'boolean',
        'accepts_video_calls' => 'boolean',
        'accepts_phone_calls' => 'boolean',
        'weekend_availability' => 'boolean',
        'verified_at' => 'date',
    ];

    // =============================================================================
    // RELATIONSHIPS
    // =============================================================================

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(NegotiationBooking::class);
    }

    public function upcomingBookings(): HasMany
    {
        return $this->hasMany(NegotiationBooking::class)
            ->where('scheduled_date', '>', now())
            ->orderBy('scheduled_date');
    }

    public function completedBookings(): HasMany
    {
        return $this->hasMany(NegotiationBooking::class)
            ->where('status', 'completed');
    }

    // =============================================================================
    // SCOPES
    // =============================================================================

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeForCulture($query, $culture)
    {
        return $query->whereJsonContains('cultural_expertise', $culture);
    }

    public function scopeForLanguage($query, $language)
    {
        return $query->whereJsonContains('languages_spoken', $language);
    }

    public function scopeForRegion($query, $region)
    {
        return $query->whereJsonContains('regions_served', $region)
            ->orWhere('travel_available', true);
    }

    public function scopeWithinBudget($query, $maxBudget)
    {
        return $query->where('consultation_fee', '<=', $maxBudget);
    }

    public function scopeHighRated($query, $minRating = 4.0)
    {
        return $query->where('rating', '>=', $minRating);
    }

    // =============================================================================
    // ACCESSORS
    // =============================================================================

    public function getProfilePhotoUrlAttribute(): string
    {
        if ($this->profile_photo) {
            return Storage::url($this->profile_photo);
        }
        return asset('images/default-negotiator.png');
    }

    public function getSuccessRateAttribute(): float
    {
        if ($this->total_negotiations === 0) return 0;
        return ($this->successful_negotiations / $this->total_negotiations) * 100;
    }

    public function getFormattedConsultationFeeAttribute(): string
    {
        return 'R ' . number_format($this->consultation_fee, 2);
    }

    public function getFormattedHourlyRateAttribute(): string
    {
        return 'R ' . number_format($this->hourly_rate, 2);
    }

    public function getYearsExperienceTextAttribute(): string
    {
        return $this->years_experience . ($this->years_experience == 1 ? ' year' : ' years') . ' experience';
    }

    public function getIsAvailableWeekendAttribute(): bool
    {
        return $this->weekend_availability;
    }

    public function getMainCulturalExpertiseAttribute(): string
    {
        return $this->cultural_expertise[0] ?? 'Traditional';
    }

    public function getPrimaryLanguageAttribute(): string
    {
        return $this->languages_spoken[0] ?? 'English';
    }

    // =============================================================================
    // BUSINESS LOGIC METHODS
    // =============================================================================

    public function isAvailableOn($date, $time = null): bool
    {
        $dayOfWeek = strtolower($date->format('l'));
        
        // Check if available on this day
        if (!in_array($dayOfWeek, $this->availability_days ?? [])) {
            return false;
        }

        // If time is provided, check if available at that time
        if ($time && isset($this->availability_hours[$dayOfWeek])) {
            $hours = $this->availability_hours[$dayOfWeek];
            if (is_string($hours) && strpos($hours, '-') !== false) {
                [$start, $end] = explode('-', $hours);
                return $time >= $start && $time <= $end;
            }
        }

        return true;
    }

    public function canTravelTo($location): bool
    {
        if (!$this->travel_available) {
            return in_array($location, $this->regions_served ?? []);
        }
        return true; // Can travel anywhere if travel is available
    }

    public function calculateTotalCost($hours, $includeTravel = false): float
    {
        $total = $this->consultation_fee + ($this->hourly_rate * ($hours - 1)); // First hour is consultation
        
        if ($includeTravel && $this->travel_fee) {
            $total += $this->travel_fee;
        }
        
        return $total;
    }

    public function verify(): bool
    {
        return $this->update([
            'is_verified' => true,
            'verified_at' => now(),
            'status' => 'active'
        ]);
    }

    public function suspend(): bool
    {
        return $this->update(['status' => 'suspended']);
    }

    public function updateRating(): void
    {
        $avgRating = $this->completedBookings()->avg('rating') ?? 5.0;
        $this->update(['rating' => round($avgRating, 2)]);
    }

    public function incrementNegotiations($successful = false): void
    {
        $this->increment('total_negotiations');
        if ($successful) {
            $this->increment('successful_negotiations');
        }
        $this->updateRating();
    }
}