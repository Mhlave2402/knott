<?php

namespace Database\Factories;

use App\Models\Competition;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompetitionFactory extends Factory
{
    protected $model = Competition::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'terms_and_conditions' => $this->faker->paragraphs(3, true),
            'start_date' => $this->faker->dateTimeThisMonth(),
            'end_date' => $this->faker->dateTimeThisMonth('+2 months'),
            'voting_end_date' => $this->faker->dateTimeThisMonth('+3 months'),
            'winner_announcement_date' => $this->faker->dateTimeThisMonth('+4 months'),
            'is_active' => $this->faker->boolean(),
            'is_featured' => $this->faker->boolean(),
        ];
    }
}
