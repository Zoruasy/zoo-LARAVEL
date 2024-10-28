<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnimalController extends Controller
{
    // Laat alle dieren zien
    public function catalog()
    {
        // Haal alle dieren op
        $animals = Animal::all();

        // Stuur de data door naar de view
        return view('catalog', compact('animals'));
    }

    // Laat één dier zien
    public function show($id)
    {
        // Haal het dier op op basis van het ID
        $animal = Animal::findOrFail($id);

        // Stuur het model door naar de view
        return view('show', compact('animal'));
    }

    // Toon het formulier om een nieuw dier toe te voegen
    public function create()
    {
        return view('animals.create'); // Dit kan een aparte view zijn voor het formulier
    }

    // Sla het nieuwe dier op in de database
    public function store(Request $request)
    {
        // Valideer de invoer
        $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255', // 'soort' vervangen door 'species'
            'habitat' => 'required|string',
        ]);

        // Maak een nieuw dier aan en koppel het aan de ingelogde gebruiker
        Animal::create([
            'name' => $request->input('name'),
            'species' => $request->input('species'), // gebruik species
            'habitat' => $request->input('habitat'),
            'user_id' => Auth::id(),
        ]);


    }

    // Bewerk het dier
    public function edit($id)
    {
        $animal = Animal::findOrFail($id);

        // Controleer of de ingelogde gebruiker de eigenaar is
        if (Auth::id() !== $animal->user_id) {
            return redirect()->route('catalog')->with('error', 'Je hebt geen toegang om dit dier te bewerken.');
        }

        return view('animals.edit', compact('animal'));
    }

    // Werk het dier bij
    public function update(Request $request, $id)
    {
        $animal = Animal::findOrFail($id);

        // Controleer of de ingelogde gebruiker de eigenaar is
        if (Auth::id() !== $animal->user_id) {
            return redirect()->route('catalog')->with('error', 'Je hebt geen toegang om dit dier te bewerken.');
        }

        // Valideer de invoer
        $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255', // Gebruik species hier
            'habitat' => 'required|string',
        ]);

        // Werk het dier bij
        $animal->update($request->only('name', 'species', 'habitat')); // Voeg species en habitat toe

        return redirect()->route('catalog')->with('success', 'Dier succesvol bijgewerkt.');
    }

    // Verwijder het dier
    public function destroy($id)
    {
        $animal = Animal::findOrFail($id);

        // Controleer of de ingelogde gebruiker de eigenaar is
        if (Auth::id() !== $animal->user_id) {
            return redirect()->route('catalog')->with('error', 'Je hebt geen toegang om dit dier te verwijderen.');
        }

        // Verwijder het dier
        $animal->delete();

        return redirect()->route('catalog')->with('success', 'Dier succesvol verwijderd.');
    }
}
