<?php

namespace Database\Factories;

use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ingredient>
 */
class IngredientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->randomElement(['Bawang Merah', 'Ayam Fillet', 'Susu UHT', 'Tepung Terigu', 'Garam', 'Minyak Goreng', 'Daging Sapi', 'Telur']),
            'tanggal_datang' => $this->faker->dateTimeBetween('-1 month', 'now'), // Tanggal sebulan terakhir
            'kuantitas' => $this->faker->numberBetween(1, 100),
            'satuan' => $this->faker->randomElement(['kg', 'gr', 'liter', 'pcs', 'pack']),
            'kadaluarsa' => $this->faker->dateTimeBetween('now', '+1 year'), // Kadaluarsa di masa depan
            'foto' => 'ingredients/default.jpg', // Path dummy untuk foto
            'status_kesegaran' => 'Unknown',
        ];
    }
}
