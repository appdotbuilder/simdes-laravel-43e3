<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'role' => fake()->randomElement(['admin', 'resident', 'village_head']),
            'phone' => fake()->phoneNumber(),
            'status' => fake()->randomElement(['active', 'inactive', 'pending_verification']),
            'verified_at' => fake()->optional()->dateTime(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the user is an admin.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
            'status' => 'active',
            'verified_at' => now(),
        ]);
    }

    /**
     * Indicate that the user is a resident.
     */
    public function resident(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'resident',
            'status' => 'active',
            'verified_at' => now(),
        ]);
    }

    /**
     * Indicate that the user is a village head.
     */
    public function villageHead(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'village_head',
            'status' => 'active',
            'verified_at' => now(),
        ]);
    }
}
