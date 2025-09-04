<?php

namespace Database\Factories;

use App\Models\Family;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Resident>
 */
class ResidentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nik' => fake()->unique()->numerify('################'),
            'name' => fake()->name(),
            'birth_date' => fake()->date('Y-m-d', '-18 years'),
            'birth_place' => fake()->city(),
            'gender' => fake()->randomElement(['male', 'female']),
            'religion' => fake()->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
            'education' => fake()->randomElement(['SD', 'SMP', 'SMA', 'D3', 'S1', 'S2', 'S3']),
            'occupation' => fake()->jobTitle(),
            'marital_status' => fake()->randomElement(['single', 'married', 'divorced', 'widowed']),
            'family_id' => Family::factory(),
            'family_relation' => fake()->randomElement(['head', 'spouse', 'child', 'parent', 'sibling', 'other']),
            'phone' => fake()->phoneNumber(),
            'status' => fake()->randomElement(['active', 'inactive', 'moved', 'deceased']),
        ];
    }

    /**
     * Indicate that the resident is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the resident is a family head.
     */
    public function familyHead(): static
    {
        return $this->state(fn (array $attributes) => [
            'family_relation' => 'head',
            'marital_status' => fake()->randomElement(['married', 'divorced', 'widowed']),
        ]);
    }
}