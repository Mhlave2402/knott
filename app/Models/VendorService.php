<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorService extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_profile_id', 'name', 'description', 'category',
        'price', 'price_type', 'inclusions', 'exclusions', 'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'inclusions' => 'array',
        'exclusions' => 'array',
        'is_active' => 'boolean'
    ];

    public function vendorProfile(): BelongsTo
    {
        return $this->belongsTo(VendorProfile::class);
    }

    public function getFormattedPriceAttribute(): string
    {
        $price = 'R' . number_format($this->price, 2);
        
        return match($this->price_type) {
            'hourly' => $price . '/hour',
            'per_person' => $price . '/person',
            default => $price
        };
    }
}