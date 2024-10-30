<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Voeg andere seeders toe
        $this->call(AnimalsTableSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(FavoriteAnimalsSeeder::class); // Voeg deze regel toe

        // Maak een testgebruiker aan
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}

