<?php

namespace Database\Factories;

use App\Models\Negotiator;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NegotiatorFactory extends Factory
{
    protected $model = Negotiator::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create(['role' => 'negotiator'])->id,
            'full_name' => $this->faker->name(),
            'title' => $this->faker->optional()->randomElement(['Chief', 'Elder', 'Makoma', 'Ntate']),
            'bio' => $this->faker->paragraphs(3, true),
            'languages_spoken' => $this->faker->randomElements([
                'English', 'Zulu', 'Xhosa', 'Afrikaans', 'Sotho', 'Tswana', 'Pedi', 'Venda'
            ], 3),
            'cultural_expertise' => $this->faker->randomElements([
                'Zulu', 'Xhosa', 'Sotho', 'Tswana', 'Pedi', 'Venda', 'Ndebele', 'Swati'
            ], 2),
            'regions_served' => $this->faker->randomElements([
                'Gauteng', 'Western Cape', 'KwaZulu-Natal', 'Eastern Cape', 'Free State',
                'Limpopo', 'Mpumalanga', 'North West', 'Northern Cape'
            ], 3),
            'years_experience' => $this->faker->numberBetween(5, 40),
            'consultation_fee' => $this->faker->numberBetween(500, 2000),
            'hourly_rate' => $this->faker->numberBetween(300, 1000),
            'full_service_rate' => $this->faker->numberBetween(5000, 20000),
            'availability_hours' => [
                'monday' => '09:00-17:00',
                'tuesday' => '09:00-17:00',
                'wednesday' => '09:00-17:00',
                'thursday' => '09:00-17:00',
                'friday' => '09:00-15:00',
                'saturday' => '08:00-12:00',
            ],
            'availability_days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'],
            'primary_location' => $this->faker->randomElement([
                'Johannesburg', 'Cape Town', 'Durban', 'Pretoria', 'Bloemfontein'
            ]),
            'travel_available' => $this->faker->boolean(70),
            'max_travel_distance' => $this->faker->numberBetween(50, 500),
            'travel_fee' => $this->faker->numberBetween(5, 20),
            'rating' => $this->faker->randomFloat(2, 4.0, 5.0),
            'total_negotiations' => $this->faker->numberBetween(10, 200),
            'successful_negotiations' => function (array $attributes) {
                return $this->faker->numberBetween(
                    intval($attributes['total_negotiations'] * 0.7),
                    $attributes['total_negotiations']
                );
            },
            'is_verified' => $this->faker->boolean(80),
            'is_featured' => $this->faker->boolean(20),
            'verified_at' => $this->faker->optional(0.8)->dateTimeThisYear(),
            'cultural_notes' => $this->faker->optional()->paragraph(),
            'approach_philosophy' => $this->faker->paragraph(),
            'accepts_video_calls' => $this->faker->boolean(90),
            'accepts_phone_calls' => $this->faker->boolean(95),
            'weekend_availability' => $this->faker->boolean(60),
            'status' => 'active',
        ];
    }

    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_verified' => true,
            'verified_at' => $this->faker->dateTimeThisYear(),
            'status' => 'active',
        ]);
    }

    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
            'is_verified' => true,
            'rating' => $this->faker->randomFloat(2, 4.5, 5.0),
        ]);
    }
}