<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\CoupleProfile;
use Carbon\Carbon;

class CoupleSeeder extends Seeder
{
    public function run()
    {
        $user = User::create([
            'name' => 'Emma Thompson',
            'email' => 'emma@example.com',
            'password' => bcrypt('password'),
            'role' => 'couple',
            'email_verified_at' => now(),
        ]);

        $profile = CoupleProfile::create([
            'user_id' => $user->id,
            'partner_name' => 'James Wilson',
            'partner_email' => 'james@example.com',
            'wedding_date' => Carbon::now()->addMonths(8),
            'venue_location' => 'Stellenbosch, Western Cape',
            'guest_count' => 120,
            'total_budget' => 150000.00,
            'wedding_style' => 'Modern Elegant',
            'preferences' => [
                'colors' => ['Rose Gold', 'Blush Pink', 'Ivory'],
                'themes' => ['Garden Party', 'Romantic']
            ],
        ]);

        // Initialize default budget categories
        $profile->initializeDefaultBudgetCategories();

        // Add some sample guests
        $guests = [
            ['name' => 'Mary Thompson', 'category' => 'family', 'rsvp_status' => 'attending'],
            ['name' => 'John Wilson', 'category' => 'family', 'rsvp_status' => 'attending'],
            ['name' => 'Sarah Davis', 'category' => 'friends', 'rsvp_status' => 'pending'],
            ['name' => 'Michael Brown', 'category' => 'friends', 'rsvp_status' => 'maybe'],
            ['name' => 'Jennifer Lee', 'category' => 'colleagues', 'rsvp_status' => 'declined'],
        ];

        foreach ($guests as $guestData) {
            $profile->guests()->create(array_merge($guestData, [
                'email' => strtolower(str_replace(' ', '.', $guestData['name'])) . '@example.com',
                'phone' => fake()->phoneNumber(),
                'plus_one' => rand(0, 2),
            ]));
        }

        // Add some sample todos
        $todos = [
            ['title' => 'Book wedding venue', 'priority' => 'high', 'due_date' => Carbon::now()->addDays(30)],
            ['title' => 'Send save the dates', 'priority' => 'medium', 'due_date' => Carbon::now()->addDays(60)],
            ['title' => 'Choose wedding dress', 'priority' => 'high', 'due_date' => Carbon::now()->addDays(45)],
            ['title' => 'Book photographer', 'priority' => 'high', 'due_date' => Carbon::now()->addDays(20)],
            ['title' => 'Plan honeymoon', 'priority' => 'low', 'due_date' => Carbon::now()->addDays(90)],
        ];

        foreach ($todos as $index => $todoData) {
            $profile->todos()->create(array_merge($todoData, [
                'description' => 'Important wedding planning task',
                'sort_order' => $index + 1,
            ]));
        }
    }
}