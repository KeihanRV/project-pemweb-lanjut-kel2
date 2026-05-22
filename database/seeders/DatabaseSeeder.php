<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Bcrypt;


class DatabaseSeeder extends Seeder
{
    // use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::firstOrCreate(
            ['email' => config('app.system_user_email')],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'is_admin' => true,
            ]
        );

        $this->call(IngredientSeeder::class);
        $this->call(KitchenSeeder::class);
        
    }
}
