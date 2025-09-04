<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LetterType>
 */
class LetterTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $letterTypes = [
            [
                'name' => 'Surat Keterangan Domisili',
                'code' => 'SKD',
                'description' => 'Surat keterangan domisili untuk keperluan administrasi',
                'requirements' => ['KTP', 'KK', 'Pas Foto 3x4']
            ],
            [
                'name' => 'Surat Keterangan Usaha',
                'code' => 'SKU',
                'description' => 'Surat keterangan usaha untuk keperluan UMKM',
                'requirements' => ['KTP', 'KK', 'Foto Tempat Usaha', 'Surat Pernyataan']
            ],
            [
                'name' => 'Surat Keterangan Tidak Mampu',
                'code' => 'SKTM',
                'description' => 'Surat keterangan tidak mampu untuk beasiswa atau bantuan',
                'requirements' => ['KTP', 'KK', 'Surat Pernyataan', 'Foto Rumah']
            ],
            [
                'name' => 'Surat Pengantar Nikah',
                'code' => 'SPN',
                'description' => 'Surat pengantar untuk keperluan pernikahan',
                'requirements' => ['KTP', 'KK', 'Akta Kelahiran', 'Pas Foto 4x6']
            ]
        ];

        return [
            'name' => fake()->sentence(3),
            'code' => fake()->unique()->regexify('[A-Z]{3}'),
            'description' => fake()->sentence(),
            'requirements' => ['KTP', 'KK', 'Pas Foto'],
            'template' => fake()->text(500),
            'fee' => fake()->randomFloat(2, 0, 50000),
            'processing_days' => fake()->numberBetween(1, 7),
            'status' => fake()->randomElement(['active', 'inactive']),
        ];
    }

    /**
     * Indicate that the letter type is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }
}