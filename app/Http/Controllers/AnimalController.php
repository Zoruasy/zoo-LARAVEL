<?php namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnimalController extends Controller
{
// Laat alle dieren zien met zoek- en filterfunctionaliteit
    public function catalog(Request $request)
    {
// Haal filterwaarden op uit de request
        $search = $request->input('search');
        $speciesFilter = $request->input('species');
        $habitatFilter = $request->input('habitat');

// Bouw de query voor dieren met eventuele zoek- en filtercriteria
        $animals = Animal::query();

// Zoek op naam
        if ($search) {
            $animals->where('name', 'LIKE', "%{$search}%");
        }

// Filter op soort
        if ($speciesFilter) {
            $animals->where('species', $speciesFilter);
        }

// Filter op habitat
        if ($habitatFilter) {
            $animals->where('habitat', $habitatFilter);
        }

// Voer de query uit en haal de resultaten op
        $animals = $animals->get();

// Haal de unieke waarden voor de filters op
        $speciesOptions = Animal::select('species')->distinct()->get();
        $habitatOptions = Animal::select('habitat')->distinct()->get();

// Stuur de data door naar de view
        return view('catalog', compact('animals', 'speciesOptions', 'habitatOptions'));
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
            'species' => 'required|string|max:255',
            'habitat' => 'required|string',
        ]);

// Maak een nieuw dier aan en koppel het aan de ingelogde gebruiker
        Animal::create([
            'name' => $request->input('name'),
            'species' => $request->input('species'),
            'habitat' => $request->input('habitat'),
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('zoo.catalog')->with('success', 'Dier succesvol toegevoegd.'); // Redirect naar catalogus
    }

// Bewerk het dier
    public function edit($id)
    {
        $animal = Animal::findOrFail($id);

// Controleer of de ingelogde gebruiker de eigenaar is
        if (Auth::id() !== $animal->user_id) {
            return redirect()->route('zoo.catalog')->with('error', 'Je hebt geen toegang om dit dier te bewerken.');
        }

        return view('editanimal', compact('animal')); // Zorg ervoor dat je 'animal' doorgeeft
    }

// Werk het dier bij
    public function update(Request $request, $id)
    {
        $animal = Animal::findOrFail($id);

// Controleer of de ingelogde gebruiker de eigenaar is
        if (Auth::id() !== $animal->user_id) {
            return redirect()->route('zoo.catalog')->with('error', 'Je hebt geen toegang om dit dier te bewerken.');
        }

// Valideer de invoer
        $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'habitat' => 'required|string',
        ]);

// Werk het dier bij
        $animal->update($request->only('name', 'species', 'habitat'));

// Redirect naar de catalogus met een succesmelding
        return redirect()->route('zoo.catalog')->with('success', 'Dier succesvol bijgewerkt.');
    }

// Verwijder het dier
    public function destroy($id)
    {
        $animal = Animal::findOrFail($id);

// Controleer of de ingelogde gebruiker de eigenaar is
        if (Auth::id() !== $animal->user_id) {
            return redirect()->route('zoo.catalog')->with('error', 'Je hebt geen toegang om dit dier te verwijderen.');
        }

// Verwijder het dier
        $animal->delete();

        return redirect()->route('zoo.catalog')->with('success', 'Dier succesvol verwijderd.');
    }

// Methode voor het admin dashboard
    public function adminDashboard()
    {
        if (!Auth::user() || !Auth::user()->isAdmin()) {
            return redirect('/')->with('error', 'Je hebt geen toegang tot het admin dashboard.');
        }

        return view('admindashboard'); // Weergeven van het admin dashboard
    }


// Toggle activation status of an animal
    public function toggleStatus($animalId)
    {
        // Find the animal by ID
        $animal = Animal::findOrFail($animalId);

        // Toggle the is_active status
        $animal->is_active = !$animal->is_active; // Assuming you have an `is_active` column in your animals table
        $animal->save();

        // Redirect back with a success message
        return redirect()->route('zoo.catalog')->with('success', 'Status bijgewerkt.');
    }
}
