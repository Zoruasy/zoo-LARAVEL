<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnimalController extends Controller
{
    public function catalog()
    {
        // Haal alle dieren op
        $animals = Animal::all();

        // Stuur de data door naar de view
        return view('catalog', compact('animals'));
    }

    public function show($id)
    {
        // Haal het dier op op basis van het ID
        $animal = Animal::findOrFail($id); // Gebruik findOrFail om een 404 te geven als het dier niet bestaat

        // Stuur het model door naar de view
        return view('show', compact('animal'));
    }

    public function edit($id)
    {
        // Haal het dier op
        $animal = Animal::findOrFail($id);

        // Controleer of de ingelogde gebruiker de eigenaar is
        if ($animal->user_id !== Auth::id()) {
            return redirect()->route('animals.catalog')->with('error', 'Je hebt geen toestemming om dit item te bewerken.');
        }

        // Stuur het model door naar de bewerk view
        return view('edit', compact('animal'));
    }

    public function update(Request $request, $id)
    {
        // Haal het dier op
        $animal = Animal::findOrFail($id);

        // Controleer of de ingelogde gebruiker de eigenaar is
        if ($animal->user_id !== Auth::id()) {
            return redirect()->route('animals.catalog')->with('error', 'Je hebt geen toestemming om dit item bij te werken.');
        }

        // Valideer de invoer
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            // Voeg hier andere velden toe die je wilt valideren
        ]);

        // Update het dier
        $animal->update($validatedData);

        return redirect()->route('animals.show', $animal->id)->with('success', 'Item succesvol bijgewerkt.');
    }
}
