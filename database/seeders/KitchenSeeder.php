<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ingredient;
use App\Models\Kitchen;

/**
 * @extends Seeder
 */

class KitchenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kitchen::factory()
            ->count(5)
            ->create()
            ->each(function (Kitchen $kitchen) {
                $ingredients = Ingredient::factory()
                    ->count(rand(8, 20))
                    ->create();

                foreach ($ingredients as $ingredient) {
                    // create storage entry linking ingredient to this kitchen
                    \App\Models\Storage::create([
                        'ingredient_id' => $ingredient->id,
                        'kitchen_id' => $kitchen->id,
                    ]);

                    // keep pivot for backward compatibility
                    $kitchen->ingredients()->attach($ingredient->id);
                }
            });
    }
}
