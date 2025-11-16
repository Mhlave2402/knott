<?php

namespace Database\Factories;

use App\Models\QuoteRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuoteRequestFactory extends Factory
{
    protected $model = QuoteRequest::class;

    public function definition(): array
    {
        $eventDate = $this->faker->dateTimeBetween('+1 month', '+1 year');
        $totalBudget = $this->faker->numberBetween(50000, 500000);
        
        return [
            'couple_id' => User::factory()->create(['role' => 'couple'])->id,
            'event_type' => 'wedding',
            'event_date' => $eventDate,
            'venue_location' => $this->faker->randomElement([
                'Johannesburg, Gauteng',
                'Cape Town, Western Cape',
                'Durban, KwaZulu-Natal',
                'Pretoria, Gauteng',
                'Stellenbosch, Western Cape'
            ]),
            'guest_count' => $this->faker->numberBetween(50, 300),
            'total_budget' => $totalBudget,
            'category_budgets' => [
                'photography' => $totalBudget * 0.15,
                'videography' => $totalBudget * 0.10,
                'catering' => $totalBudget * 0.30,
                'venue' => $totalBudget * 0.25,
                'flowers' => $totalBudget * 0.10,
                'music' => $totalBudget * 0.05,
                'transport' => $totalBudget * 0.03,
                'other' => $totalBudget * 0.02,
            ],
            'style_preference' => $this->faker->randomElement([
                'classic', 'modern', 'rustic', 'traditional', 'bohemian', 'vintage'
            ]),
            'color_scheme' => $this->faker->randomElements([
                'white', 'ivory', 'gold', 'rose-gold', 'burgundy', 'navy', 'blush', 'sage'
            ], 3),
            'special_requirements' => $this->faker->optional()->paragraph(),
            'urgency' => $this->faker->randomElement(['flexible', 'moderate', 'urgent']),
            'status' => $this->faker->randomElement(['draft', 'submitted', 'quotes_received']),
            'expires_at' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
        ];
    }

    public function submitted(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'submitted',
            'submitted_at' => now()->subDays(rand(1, 7)),
        ]);
    }

    public function urgent(): static
    {
        return $this->state(fn (array $attributes) => [
            'urgency' => 'urgent',
            'event_date' => $this->faker->dateTimeBetween('+2 weeks', '+2 months'),
        ]);
    }
}