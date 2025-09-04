<?php

namespace Database\Seeders;

use App\Models\Block;
use App\Models\Family;
use App\Models\LetterType;
use App\Models\Resident;
use App\Models\User;
use App\Models\Village;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class VillageAdministrationSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create village data
        $village = Village::create([
            'name' => 'Desa Maju Bersama',
            'code' => '3201',
            'address' => 'Jl. Raya Desa No. 1, Kec. Maju, Kab. Bersama',
            'phone' => '021-12345678',
            'email' => 'info@desamajubersama.go.id',
            'head_name' => 'H. Ahmad Sudrajat',
            'head_nip' => '196512151990031001',
        ]);

        // Create blocks
        $blocks = [
            ['name' => 'Blok A - Pemukiman', 'code' => 'BLK-001', 'description' => 'Area pemukiman utama'],
            ['name' => 'Blok B - Perdagangan', 'code' => 'BLK-002', 'description' => 'Area perdagangan dan UMKM'],
            ['name' => 'Blok C - Pertanian', 'code' => 'BLK-003', 'description' => 'Area pertanian dan peternakan'],
        ];

        foreach ($blocks as $blockData) {
            Block::create($blockData);
        }

        // Create letter types
        $letterTypes = [
            [
                'name' => 'Surat Keterangan Domisili',
                'code' => 'SKD',
                'description' => 'Surat keterangan domisili untuk keperluan administrasi',
                'requirements' => ['KTP Asli', 'Kartu Keluarga', 'Pas Foto 3x4 (2 lembar)', 'Surat Pengantar RT/RW'],
                'fee' => 5000,
                'processing_days' => 3,
            ],
            [
                'name' => 'Surat Keterangan Usaha',
                'code' => 'SKU',
                'description' => 'Surat keterangan usaha untuk keperluan UMKM dan perizinan',
                'requirements' => ['KTP Asli', 'Kartu Keluarga', 'Pas Foto 4x6 (2 lembar)', 'Foto Tempat Usaha', 'Surat Pernyataan Usaha'],
                'fee' => 10000,
                'processing_days' => 5,
            ],
            [
                'name' => 'Surat Keterangan Tidak Mampu',
                'code' => 'SKTM',
                'description' => 'Surat keterangan tidak mampu untuk beasiswa, bantuan sosial, atau keperluan lainnya',
                'requirements' => ['KTP Asli', 'Kartu Keluarga', 'Pas Foto 3x4 (2 lembar)', 'Surat Pernyataan Tidak Mampu', 'Foto Rumah'],
                'fee' => 0,
                'processing_days' => 3,
            ],
            [
                'name' => 'Surat Pengantar Nikah',
                'code' => 'SPN',
                'description' => 'Surat pengantar untuk keperluan pernikahan ke KUA',
                'requirements' => ['KTP Asli', 'Kartu Keluarga', 'Akta Kelahiran', 'Pas Foto 4x6 (4 lembar)', 'Surat Keterangan Belum Menikah'],
                'fee' => 15000,
                'processing_days' => 7,
            ],
            [
                'name' => 'Surat Keterangan Pindah',
                'code' => 'SKP',
                'description' => 'Surat keterangan pindah domisili atau tempat tinggal',
                'requirements' => ['KTP Asli', 'Kartu Keluarga', 'Surat Keterangan RT/RW', 'Surat Keterangan Tujuan Pindah'],
                'fee' => 7500,
                'processing_days' => 5,
            ],
        ];

        foreach ($letterTypes as $letterTypeData) {
            LetterType::create($letterTypeData);
        }

        // Create admin user
        $admin = User::create([
            'name' => 'Administrator Desa',
            'email' => 'admin@desamajubersama.go.id',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'phone' => '081234567890',
            'status' => 'active',
            'email_verified_at' => now(),
            'verified_at' => now(),
        ]);

        // Create village head user
        $villageHead = User::create([
            'name' => 'H. Ahmad Sudrajat',
            'email' => 'kepala@desamajubersama.go.id',
            'password' => Hash::make('password123'),
            'role' => 'village_head',
            'phone' => '081234567891',
            'status' => 'active',
            'email_verified_at' => now(),
            'verified_at' => now(),
        ]);

        // Create sample families and residents
        $families = Family::factory(10)->create([
            'block_id' => fn() => Block::inRandomOrder()->first()->id,
        ]);

        // Create residents for each family
        foreach ($families as $family) {
            // Create family head
            $head = Resident::factory()->create([
                'family_id' => $family->id,
                'family_relation' => 'head',
                'name' => $family->head_name,
                'status' => 'active',
            ]);

            // Update family head name to match resident
            $family->update(['head_name' => $head->name]);

            // Create spouse (70% chance)
            if (fake()->boolean(70)) {
                Resident::factory()->create([
                    'family_id' => $family->id,
                    'family_relation' => 'spouse',
                    'status' => 'active',
                    'marital_status' => 'married',
                ]);
            }

            // Create children (random 1-4)
            $childrenCount = fake()->numberBetween(1, 4);
            for ($i = 0; $i < $childrenCount; $i++) {
                Resident::factory()->create([
                    'family_id' => $family->id,
                    'family_relation' => 'child',
                    'status' => 'active',
                    'marital_status' => 'single',
                    'birth_date' => fake()->dateTimeBetween('-25 years', '-1 year'),
                ]);
            }
        }

        // Create resident users for some residents (20% of residents get user accounts)
        $residents = Resident::where('status', 'active')->get();
        $selectedResidents = $residents->random(min(8, $residents->count()));

        foreach ($selectedResidents as $resident) {
            User::create([
                'name' => $resident->name,
                'email' => strtolower(str_replace(' ', '.', $resident->name)) . '@example.com',
                'password' => Hash::make('password123'),
                'role' => 'resident',
                'resident_id' => $resident->id,
                'phone' => $resident->phone,
                'status' => 'active',
                'email_verified_at' => now(),
                'verified_at' => now(),
            ]);
        }

        $this->command->info('Village administration data seeded successfully!');
        $this->command->info('Admin: admin@desamajubersama.go.id / password123');
        $this->command->info('Village Head: kepala@desamajubersama.go.id / password123');
        $this->command->info('Sample residents can login with their email (name.surname@example.com) / password123');
    }
}