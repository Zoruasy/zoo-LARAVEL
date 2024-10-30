<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder; // Zorg ervoor dat deze regel correct is
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Voeg hier je gebruikers toe
        User::create([
            'name' => 'Test User',
            'email' => 'test1@example.com',
            'password' => Hash::make('password'), // Zorg ervoor dat je een wachtwoord toevoegt
            // Voeg eventueel extra velden toe als dat nodig is
        ]);
    }
}
