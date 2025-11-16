<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\QuoteRequest;
use App\Models\Negotiator;
use App\Models\Competition;
use App\Models\CompetitionEntry;
use App\Models\User;

class Phase3Seeder extends Seeder
{
    public function run(): void
    {
        // Create couples with quote requests
        $couples = User::factory(10)->create(['role' => 'couple']);
        
        foreach ($couples as $couple) {
            QuoteRequest::factory(rand(1, 3))->create([
                'couple_id' => $couple->id
            ]);
        }

        // Create negotiators
        Negotiator::factory(15)->verified()->create();
        Negotiator::factory(3)->featured()->create();

        // Create a current competition
        $competition = Competition::updateOrCreate(
            ['title' => 'Gleam Point Wedding of the Year 2024'],
            [
                'description' => 'Showcase your beautiful wedding and win amazing prizes!',
                'terms_and_conditions' => 'Full terms and conditions...',
                'start_date' => now()->subDays(30),
                'end_date' => now()->addDays(30),
                'voting_end_date' => now()->addDays(60),
                'winner_announcement_date' => now()->addDays(70),
                'rules' => [
                    'Wedding must have taken place within the last 12 months',
                    'Minimum 4 vendors must be featured',
                    'All photos must be high quality',
                    'Story must be original and engaging'
                ],
                'eligibility_criteria' => [
                    'South African residents only',
                    'Wedding date within last 12 months',
                    'Professional photography required'
                ],
                'prizes' => [
                    'first' => 'R50,000 cash + Honeymoon package',
                    'second' => 'R25,000 cash + Spa weekend',
                    'third' => 'R10,000 cash + Dinner vouchers'
                ],
                'judging_criteria' => [
                    'Photography quality (30%)',
                    'Story telling (25%)',
                    'Vendor coordination (20%)',
                    'Creativity & style (15%)',
                    'Overall presentation (10%)'
                ],
                'public_voting_enabled' => true,
                'public_voting_weight' => 30,
                'admin_judging_weight' => 70,
                'is_active' => true,
                'is_featured' => true,
            ]
        );

        // Create competition entries
        CompetitionEntry::factory(12)->create([
            'competition_id' => $competition->id,
            'status' => 'approved'
        ]);

        $this->command->info('Phase 3 development data seeded successfully!');
    }
}
