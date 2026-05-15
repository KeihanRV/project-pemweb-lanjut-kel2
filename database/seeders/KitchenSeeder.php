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
                $ingredientIds = Ingredient::factory()
                    ->count(rand(8, 20))
                    ->create()
                    ->pluck('id')
                    ->toArray();

                $kitchen->ingredients()->attach($ingredientIds);
            });
    }
}
