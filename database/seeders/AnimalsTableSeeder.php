<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Animal; // Zorg ervoor dat je het juiste model importeert

class AnimalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Maak een array van dieren met hun details
        $animals = [
            [
                'name' => 'Leeuw',
                'species' => 'Panthera leo',
                'habitat' => 'Savanne',
                'image' => 'leeuw.jpg' // Zorg ervoor dat deze afbeelding beschikbaar is
            ],
            [
                'name' => 'Olifant',
                'species' => 'Loxodonta africana',
                'habitat' => 'Bos en Savanne',
                'image' => 'olifant.jpg'
            ],
            [
                'name' => 'Zebra',
                'species' => 'Equus quagga',
                'habitat' => 'Afrikaanse graslanden',
                'image' => 'zebra.jpg'
            ],
            [
                'name' => 'Giraffe',
                'species' => 'Giraffa camelopardalis',
                'habitat' => 'Savanne en Bosrand',
                'image' => 'giraffe.jpg'
            ],
            [
                'name' => 'IJsbeer',
                'species' => 'Ursus maritimus',
                'habitat' => 'Arctische regio',
                'image' => 'ijsbeer.jpg'
            ],
            // Voeg meer dieren toe indien nodig
        ];

        // Loop door de array en voeg elk dier toe aan de database
        foreach ($animals as $animal) {
            Animal::create($animal);
        }
    }
}
