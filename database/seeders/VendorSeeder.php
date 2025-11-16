<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\VendorProfile;
use App\Models\VendorService;

class VendorSeeder extends Seeder
{
    public function run()
    {
        // Create sample vendors
        $vendors = [
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah@dreamweddings.co.za',
                'business_name' => 'Dream Wedding Photography',
                'description' => 'Capturing your perfect moments with artistic flair and professional excellence.',
                'location' => 'Cape Town, Western Cape',
                'category' => 'photography',
                'starting_price' => 5000.00,
            ],
            [
                'name' => 'Michael Chen',
                'email' => 'mike@elegantevents.co.za',
                'business_name' => 'Elegant Events Catering',
                'description' => 'Exquisite catering services for unforgettable wedding celebrations.',
                'location' => 'Johannesburg, Gauteng',
                'category' => 'catering',
                'starting_price' => 15000.00,
            ],
            [
                'name' => 'Lisa van der Merwe',
                'email' => 'lisa@bloomingbeauty.co.za',
                'business_name' => 'Blooming Beauty Florals',
                'description' => 'Creating stunning floral arrangements for your special day.',
                'location' => 'Durban, KwaZulu-Natal',
                'category' => 'flowers',
                'starting_price' => 2500.00,
            ],
        ];

        foreach ($vendors as $vendorData) {
            $user = User::create([
                'name' => $vendorData['name'],
                'email' => $vendorData['email'],
                'password' => bcrypt('password'),
                'role' => 'vendor',
                'email_verified_at' => now(),
            ]);

            $profile = VendorProfile::create([
                'user_id' => $user->id,
                'business_name' => $vendorData['business_name'],
                'description' => $vendorData['description'],
                'location' => $vendorData['location'],
                'phone' => fake()->phoneNumber(),
                'starting_price' => $vendorData['starting_price'],
                'is_approved' => true,
                'approved_at' => now(),
            ]);

            // Add a sample service
            VendorService::create([
                'vendor_profile_id' => $profile->id,
                'name' => ucfirst($vendorData['category']) . ' Package',
                'description' => 'Complete ' . $vendorData['category'] . ' service for your wedding day.',
                'category' => $vendorData['category'],
                'price' => $vendorData['starting_price'],
                'price_type' => 'fixed',
                'inclusions' => ['Professional service', 'High quality results', 'Friendly staff'],
                'is_active' => true,
            ]);
        }
    }
}