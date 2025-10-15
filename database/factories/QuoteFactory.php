<?php

namespace Database\Factories;

use App\Enums\QuoteStatus;
use App\Enums\ServiceType;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuoteFactory extends Factory
{
    public function definition(): array
    {
        $serviceType = fake()->randomElement(ServiceType::cases());
        $duration = fake()->randomFloat(1, 1, 8);

        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'service_type' => $serviceType,
            'booking_datetime' => fake()->dateTimeBetween('now', '+30 days'),
            'duration' => $duration,
            'additional_notes' => fake()->optional()->sentence(),
            'status' => QuoteStatus::PENDING,
            'estimated_price' => $serviceType->getHourlyRate() * $duration,
            'final_price' => null,
            'rejection_reason' => null,
        ];
    }

    public function approved(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => QuoteStatus::APPROVED,
                'final_price' => $attributes['estimated_price'] * fake()->randomFloat(2, 0.9, 1.2),
            ];
        });
    }

    public function rejected(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => QuoteStatus::REJECTED,
                'rejection_reason' => fake()->sentence(),
            ];
        });
    }

    public function scheduled(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => QuoteStatus::SCHEDULED,
                'final_price' => $attributes['estimated_price'],
            ];
        });
    }

    public function invoiced(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => QuoteStatus::INVOICED,
                'final_price' => $attributes['estimated_price'],
            ];
        });
    }
}
