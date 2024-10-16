<?php namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Animal;

class AnimalsTableSeeder extends Seeder
{
public function run()
{
Animal::create(['name' => 'Leeuw', 'species' => 'Panthera leo', 'habitat' => 'Savanne']);
Animal::create(['name' => 'Olifant', 'species' => 'Loxodonta africana', 'habitat' => 'Bos en Savanne']);
Animal::create(['name' => 'Zebra', 'species' => 'Equus quagga', 'habitat' => 'Afrikaanse graslanden']);
Animal::create(['name' => 'Giraffe', 'species' => 'Giraffa camelopardalis', 'habitat' => 'Savanne en Bosrand']);

}
}
