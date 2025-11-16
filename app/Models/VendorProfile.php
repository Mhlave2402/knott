<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class VendorProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'business_name', 'description', 'location', 'phone',
        'website', 'service_areas', 'starting_price', 'social_media',
        'is_approved', 'is_featured', 'approved_at'
    ];

    protected $casts = [
        'service_areas' => 'array',
        'social_media' => 'array',
        'starting_price' => 'decimal:2',
        'is_approved' => 'boolean',
        'is_featured' => 'boolean',
        'approved_at' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(VendorService::class);
    }

    public function portfolio(): HasMany
    {
        return $this->hasMany(VendorPortfolio::class)->orderBy('sort_order');
    }

    public function subscription(): HasOne
    {
        return $this->hasOne(VendorSubscription::class)->where('is_active', true);
    }

    public function featuredPortfolio(): HasMany
    {
        return $this->hasMany(VendorPortfolio::class)->where('is_featured', true);
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}