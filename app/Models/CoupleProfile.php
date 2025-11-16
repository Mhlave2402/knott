<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Carbon\Carbon;

class CoupleProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'partner_name', 'partner_email', 'wedding_date',
        'venue_location', 'guest_count', 'total_budget', 'wedding_style', 'preferences'
    ];

    protected $casts = [
        'wedding_date' => 'date',
        'total_budget' => 'decimal:2',
        'preferences' => 'array'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function budgetCategories(): HasMany
    {
        return $this->hasMany(BudgetCategory::class)->orderBy('sort_order');
    }

    public function guests(): HasMany
    {
        return $this->hasMany(WeddingGuest::class);
    }

    public function todos(): HasMany
    {
        return $this->hasMany(WeddingTodo::class)->orderBy('sort_order');
    }

    public function bookmarkedVendors(): BelongsToMany
    {
        return $this->belongsToMany(VendorProfile::class, 'vendor_bookmarks')
                    ->withPivot('notes')
                    ->withTimestamps();
    }

    public function getDaysUntilWeddingAttribute(): ?int
    {
        if (!$this.wedding_date) {
            return null;
        }
        
        return (int) Carbon::now()->diffInDays($this.wedding_date, false);
    }

    public function getTotalSpentAttribute(): float
    {
        return $this->budgetCategories->sum(function ($category) {
            return $category->spent_amount;
        });
    }

    public function getBudgetUtilizationAttribute(): float
    {
        if (!$this->total_budget || $this->total_budget == 0) {
            return 0;
        }
        
        return ($this->total_spent / $this->total_budget) * 100;
    }

    public function getConfirmedGuestsCountAttribute(): int
    {
        return $this->guests()->where('rsvp_status', 'attending')->count();
    }

    public function getPendingRsvpCountAttribute(): int
    {
        return $this->guests()->where('rsvp_status', 'pending')->count();
    }

    public function getCompletedTodosCountAttribute(): int
    {
        return $this->todos()->where('is_completed', true)->count();
    }

    public function initializeDefaultBudgetCategories(): void
    {
        $defaultCategories = [
            ['name' => 'Venue', 'sort_order' => 1, 'is_required' => true],
            ['name' => 'Photography', 'sort_order' => 2, 'is_required' => true],
            ['name' => 'Videography', 'sort_order' => 3, 'is_required' => false],
            ['name' => 'Catering', 'sort_order' => 4, 'is_required' => true],
            ['name' => 'Flowers & Decoration', 'sort_order' => 5, 'is_required' => true],
            ['name' => 'Music & DJ', 'sort_order' => 6, 'is_required' => true],
            ['name' => 'Wedding Dress', 'sort_order' => 7, 'is_required' => true],
            ['name' => 'Groom\'s Attire', 'sort_order' => 8, 'is_required' => true],
            ['name' => 'Wedding Cake', 'sort_order' => 9, 'is_required' => true],
            ['name' => 'Transport', 'sort_order' => 10, 'is_required' => false],
            ['name' => 'Makeup & Hair', 'sort_order' => 11, 'is_required' => true],
            ['name' => 'Rings', 'sort_order' => 12, 'is_required' => true],
            ['name' => 'Miscellaneous', 'sort_order' => 13, 'is_required' => false],
        ];

        foreach ($defaultCategories as $category) {
            $this->budgetCategories()->create($category);
        }
    }
}
