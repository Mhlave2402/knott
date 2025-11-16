<?php

namespace Database\Factories;

use App\Models\Competition;
use App\Models\CompetitionEntry;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompetitionEntryFactory extends Factory
{
    protected $model = CompetitionEntry::class;

    public function definition(): array
    {
        return [
            'competition_id' => Competition::factory(),
            'couple_id' => User::factory(['role' => 'couple']),
            'entry_title' => $this->faker->sentence(),
            'wedding_date' => $this->faker->dateTimeThisYear(),
            'venue_name' => $this->faker->company(),
            'venue_location' => $this->faker->city(),
            'guest_count' => $this->faker->numberBetween(50, 300),
            'wedding_theme' => $this->faker->word(),
            'wedding_story' => $this->faker->paragraphs(3, true),
            'vendor_list' => [],
            'photos' => [$this->faker->imageUrl()],
            'status' => $this->faker->randomElement(['draft', 'submitted', 'under_review', 'approved', 'shortlisted', 'winner', 'runner_up', 'rejected']),
        ];
    }
}
