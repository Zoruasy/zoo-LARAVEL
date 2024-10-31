<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Animal;

class AnimalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $animals = [
            [
                'name' => 'Lion',
                'species' => 'Panthera leo',
                'habitat' => 'Savannah',
                'image' => 'lion.jpg'
            ],
            [
                'name' => 'Elephant',
                'species' => 'Loxodonta africana',
                'habitat' => 'Forest and Savannah',
                'image' => 'elephant.jpg'
            ],
            [
                'name' => 'Zebra',
                'species' => 'Equus quagga',
                'habitat' => 'African Grasslands',
                'image' => 'zebra.jpg'
            ],
            [
                'name' => 'Giraffe',
                'species' => 'Giraffa camelopardalis',
                'habitat' => 'Savannah and Woodland',
                'image' => 'giraffe.jpg'
            ],
            [
                'name' => 'Polar Bear',
                'species' => 'Ursus maritimus',
                'habitat' => 'Arctic Regions',
                'image' => 'polar_bear.jpg'
            ],
            [
                'name' => 'Kangaroo',
                'species' => 'Macropus rufus',
                'habitat' => 'Australian Outback',
                'image' => 'kangaroo.jpg'
            ],
            [
                'name' => 'Panda',
                'species' => 'Ailuropoda melanoleuca',
                'habitat' => 'Mountain Forests in China',
                'image' => 'panda.jpg'
            ],
            [
                'name' => 'Wolf',
                'species' => 'Canis lupus',
                'habitat' => 'Forests, Tundra, and Mountains',
                'image' => 'wolf.jpg'
            ],
            [
                'name' => 'Eagle',
                'species' => 'Aquila chrysaetos',
                'habitat' => 'Mountains and Open Landscapes',
                'image' => 'eagle.jpg'
            ],
            [
                'name' => 'Penguin',
                'species' => 'Aptenodytes forsteri',
                'habitat' => 'Antarctic Region',
                'image' => 'penguin.jpg'
            ],
            [
                'name' => 'Dolphin',
                'species' => 'Delphinus delphis',
                'habitat' => 'Ocean and Coastal Waters',
                'image' => 'dolphin.jpg'
            ],
            [
                'name' => 'Cheetah',
                'species' => 'Acinonyx jubatus',
                'habitat' => 'Savannah and Grasslands',
                'image' => 'cheetah.jpg'
            ],
            [
                'name' => 'Grizzly Bear',
                'species' => 'Ursus arctos horribilis',
                'habitat' => 'Forests and Mountain Regions',
                'image' => 'grizzly_bear.jpg'
            ],
            [
                'name' => 'Tiger',
                'species' => 'Panthera tigris',
                'habitat' => 'Rainforest, Savannah, and Mangrove Swamps',
                'image' => 'tiger.jpg'
            ],
            [
                'name' => 'Komodo Dragon',
                'species' => 'Varanus komodoensis',
                'habitat' => 'Islands of Indonesia',
                'image' => 'komodo_dragon.jpg'
            ],
            // Add more animals as needed
        ];

        foreach ($animals as $animal) {
            Animal::create($animal);
        }
    }
}
