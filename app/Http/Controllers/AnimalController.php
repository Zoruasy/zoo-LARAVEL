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

    public function show($id) // $id toegevoegd
    {
        // Haal het dier op op basis van het ID
        $animal = Animal::find($id);

        // Stuur het model door naar de view
        return view('show', compact('animal'));
    }

    public function edit($id)
    {
        $animal = Animal::findOrFail($id);

        // Controleer of de ingelogde gebruiker de eigenaar is
        if (Auth::id() !== $animal->user_id) {
            return redirect()->route('catalog')->with('error', 'Je hebt geen toegang om dit dier te bewerken.');
        }

        return view('animals.edit', compact('animal'));
    }

    public function update(Request $request, $id)
    {
        $animal = Animal::findOrFail($id);

        // Controleer of de ingelogde gebruiker de eigenaar is
        if (Auth::id() !== $animal->user_id) {
            return redirect()->route('catalog')->with('error', 'Je hebt geen toegang om dit dier te bewerken.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Werk het dier bij
        $animal->update($request->only('name', 'description'));

        return redirect()->route('catalog')->with('success', 'Dier succesvol bijgewerkt.');
    }


}
