<?php

namespace Database\Factories;

use App\Models\LetterType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LetterRequest>
 */
class LetterRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'request_number' => 'REQ-' . fake()->unique()->numerify('########'),
            'user_id' => User::factory(),
            'letter_type_id' => LetterType::factory(),
            'purpose' => fake()->sentence(),
            'attachments' => [
                'ktp.jpg',
                'kk.jpg',
                'foto.jpg'
            ],
            'additional_data' => [
                'keperluan_detail' => fake()->sentence(),
                'alamat_tujuan' => fake()->address()
            ],
            'status' => fake()->randomElement(['pending', 'reviewing', 'approved', 'rejected', 'completed']),
            'admin_notes' => fake()->optional()->sentence(),
            'submitted_at' => fake()->dateTimeBetween('-30 days', 'now'),
        ];
    }

    /**
     * Indicate that the letter request is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'processed_at' => null,
            'completed_at' => null,
            'processed_by' => null,
        ]);
    }

    /**
     * Indicate that the letter request is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'processed_at' => fake()->dateTimeBetween('-10 days', '-5 days'),
            'completed_at' => fake()->dateTimeBetween('-5 days', 'now'),
            'final_letter_path' => 'letters/completed-letter.pdf',
        ]);
    }
}