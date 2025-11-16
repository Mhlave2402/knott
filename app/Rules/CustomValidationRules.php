<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\User;

class ValidVendorForQuote implements Rule
{
    private $budget;
    private $location;
    
    public function __construct($budget, $location)
    {
        $this->budget = $budget;
        $this->location = $location;
    }
    
    public function passes($attribute, $value)
    {
        $vendor = User::where('role', 'vendor')
            ->where('id', $value)
            ->with('services')
            ->first();
            
        if (!$vendor) {
            return false;
        }
        
        // Check if vendor has services within budget and location
        return $vendor->services()
            ->where('price_min', '<=', $this->budget)
            ->where('location', 'LIKE', '%' . $this->location . '%')
            ->exists();
    }
    
    public function message()
    {
        return 'The selected vendor is not available for your location and budget.';
    }
}

class ValidCompetitionEntry implements Rule
{
    public function passes($attribute, $value)
    {
        // Validate that the entry has minimum required vendors
        $vendorList = json_decode($value, true);
        return is_array($vendorList) && count($vendorList) >= config('knott.competitions.min_vendors_required', 4);
    }
    
    public function message()
    {
        $minVendors = config('knott.competitions.min_vendors_required', 4);
        return "Your wedding must feature at least {$minVendors} vendors to be eligible.";
    }
}