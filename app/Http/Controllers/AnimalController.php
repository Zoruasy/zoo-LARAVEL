<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    public function catalog()
    {
        // Haal alle dieren op
        $animals = Animal::all();

        // Stuur de data door naar de view
        return view('catalog', compact('animals'));
    }

    public function show($id) // $id toegevoegd
    {
        // Haal het dier op op basis van het ID
        $animal = Animal::find($id);


        // Stuur het model door naar de view
        return view('show', compact('animal'));
    }
}
