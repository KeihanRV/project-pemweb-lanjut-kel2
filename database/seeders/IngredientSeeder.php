<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ingredient;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some standalone ingredients (not yet assigned to a kitchen)
        Ingredient::factory()->count(10)->create()->each(function ($ingredient) {
            // no storage mapping here; kitchens will map ingredients into storages
        });
        
    }
}
