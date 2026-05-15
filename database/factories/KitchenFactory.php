<?php

namespace Database\Factories;

use App\Models\Kitchen;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Kitchen>
 */
class KitchenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->company() . ' Kitchen',
            'lokasi' => 'Lantai ' . $this->faker->numberBetween(1, 10),
            'daftar_bahan' => implode(', ', $this->faker->words(5)),
            // 'code' tidak perlu diisi karena sudah otomatis di Model
        ];
    }
}
