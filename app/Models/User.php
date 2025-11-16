<?php
// FILE: app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'bio',
        'avatar',
        'is_active',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * The available user roles.
     */
    const ROLES = [
        'admin' => 'Admin',
        'vendor' => 'Vendor',
        'couple' => 'Couple',
        'guest' => 'Guest',
    ];

    /**
     * Check if user has a specific role.
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Check if user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }


    /**
     * Check if user is a guest.
     */
    public function isGuest(): bool
    {
        return $this->hasRole('guest');
    }

    /**
     * Relationships
     */
    public function vendorProfile(): HasOne
    {
        return $this->hasOne(VendorProfile::class);
    }

    public function coupleProfile(): HasOne
    {
        return $this->hasOne(CoupleProfile::class);
    }

    // For couples
    public function quoteRequests(): HasMany
    {
        return $this->hasMany(QuoteRequest::class, 'couple_id');
    }

    public function negotiationBookings(): HasMany
    {
        return $this->hasMany(NegotiationBooking::class, 'couple_id');
    }

    public function competitionEntries(): HasMany
    {
        return $this->hasMany(CompetitionEntry::class, 'couple_id');
    }

    public function competitionVotes(): HasMany
    {
        return $this->hasMany(CompetitionVote::class);
    }

    // For vendors
    public function quoteResponses(): HasMany
    {
        return $this->hasMany(QuoteResponse::class, 'vendor_id');
    }

    // For negotiators
    public function negotiatorProfile(): HasOne
    {
        return $this->hasOne(Negotiator::class);
    }

    // Helper methods
    public function isCouple(): bool
    {
        return $this->role === 'couple';
    }

    public function isVendor(): bool
    {
        return $this->role === 'vendor';
    }

    public function isNegotiator(): bool
    {
        return $this->role === 'negotiator' || $this->negotiatorProfile()->exists();
    }

    public function canAccessQuoteRequest(QuoteRequest $request): bool
    {
        return $this->id === $request->couple_id || 
           ($this->isVendor() && $request->matched_vendors && 
            collect($request->matched_vendors)->pluck('vendor_id')->contains($this->id));
    }

    /**
     * Get the user's role display name.
     */
    public function getRoleDisplayNameAttribute(): string
    {
        return self::ROLES[$this->role] ?? 'Unknown';
    }

    /**
     * Get the user's initials for avatar display.
     */
    public function getInitialsAttribute(): string
    {
        $names = explode(' ', $this->name);
        $initials = '';
        
        foreach ($names as $name) {
            $initials .= strtoupper(substr($name, 0, 1));
        }
        
        return substr($initials, 0, 2);
    }

    /**
     * Get the user's avatar URL or generate a default one.
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        
        // Generate a default avatar based on initials
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=8b5cf6&background=f3f4f6&bold=true';
    }

    /**
     * Scope to filter by role.
     */
    public function scopeRole($query, string $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Scope to filter active users.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Update last login timestamp.
     */
    public function updateLastLogin(): void
    {
        $this->update(['last_login_at' => now()]);
    }

    /**
     * Get dashboard route based on user role.
     */
    public function getDashboardRouteAttribute(): string
    {
        return match ($this->role) {
            'admin'  => route('admin.dashboard'),
            'vendor' => route('vendor.dashboard'),
            'couple' => route('couple.dashboard'),
            'guest'  => route('guest.dashboard'),
            default  => route('home')
        };
    }

    public function getActiveQuoteRequestsAttribute()
    {
        return $this->quoteRequests()->active()->count();
    }

    public function getPendingQuoteResponsesAttribute()
    {
        return $this->quoteResponses()->where('status', 'pending')->count();
    }

    public function canSubmitQuoteRequest(): bool
    {
        // Check if user has reached quote request limit
        $activeRequests = $this->quoteRequests()->active()->count();
        return $activeRequests < 5; // Max 5 active requests
    }

    public function canRespondToQuote(QuoteRequest $request): bool
    {
        if (!$this->isVendor()) {
            return false;
        }
        
        // Check if already responded
        $existing = $this->quoteResponses()
            ->where('quote_request_id', $request->id)
            ->exists();
            
        return !$existing && $request->status === 'submitted';
    }

    public function hasActiveSubscription(): bool
    {
        // This would check vendor subscription status
        return $this->subscription_expires_at && 
               $this->subscription_expires_at->isFuture();
    }
}
