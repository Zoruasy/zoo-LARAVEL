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

        // Controleer of de gebruiker is ingelogd
        if (Auth::check()) {
            // Voeg een filter toe voor actieve dieren of de dieren die de ingelogde gebruiker heeft gemaakt
            $animals->where(function ($query) {
                $query->where('is_active', true)
                    ->orWhere('user_id', Auth::id());
            });
        } else {
            // Voor niet-ingelogde gebruikers, alleen actieve dieren tonen
            $animals->where('is_active', true);
        }

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
            'image' => 'image|nullable|max:1999', // Add image validation
        ]);

        // Handle the image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imagePath = $file->store('images', 'public'); // Store in the public/images directory
        }

        // Maak een nieuw dier aan en koppel het aan de ingelogde gebruiker
        Animal::create([
            'name' => $request->input('name'),
            'species' => $request->input('species'),
            'habitat' => $request->input('habitat'),
            'user_id' => Auth::id(),
            'is_active' => true, // Standaard actief instellen
            'image_path' => $imagePath, // Save the image path
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

        return view('animals.edit', compact('animal')); // Zorg ervoor dat je 'animal' doorgeeft
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
            'image' => 'image|nullable|max:1999', // Add image validation
        ]);

        // Handle the image upload
        $imagePath = $animal->image_path; // Keep the existing image path by default
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imagePath = $file->store('images', 'public'); // Store the new image
        }

        // Werk het dier bij
        $animal->update($request->only('name', 'species', 'habitat') + ['image_path' => $imagePath]); // Update with new image path

        // Redirect naar de catalogus met een succesmelding
        return redirect()->route('zoo.catalog')->with('success', 'Dier succesvol bijgewerkt.');
    }

    // Verwijder het dier
    public function destroy($id)
    {
        // Haal het dier op dat verwijderd moet worden
        $animal = Animal::findOrFail($id);

        // Controleer of de ingelogde gebruiker de eigenaar is
        if (Auth::id() !== $animal->user_id) {
            return redirect()->route('zoo.catalog')->with('error', 'Je hebt geen toegang om dit dier te verwijderen.');
        }

        // Controleer het aantal dieren dat de gebruiker heeft toegevoegd met een losse query
        $animalCount = Animal::where('user_id', Auth::id())->count();

        // Zorg ervoor dat de gebruiker minstens 3 dieren heeft toegevoegd
        if ($animalCount <= 3) {
            return redirect()->route('zoo.catalog')->withErrors(['error' => 'Je moet minstens 3 dieren hebben toegevoegd voordat je een dier kunt verwijderen.']);
        }

        // Verwijder het dier
        $animal->delete();

        return redirect()->route('zoo.catalog')->with('success', 'Dier succesvol verwijderd.');
    }

    // Toggle de actieve/inactieve status van een dier
    public function toggleStatus($id)
    {
        $animal = Animal::findOrFail($id);

        // Controleer of de ingelogde gebruiker de eigenaar is
        if (Auth::id() !== $animal->user_id) {
            return redirect()->route('zoo.catalog')->with('error', 'Je hebt geen toegang om de status van dit dier te wijzigen.');
        }

        // Toggle de is_active status
        $animal->is_active = !$animal->is_active;
        $animal->save();

        return redirect()->route('zoo.catalog')->with('success', 'Status van het dier succesvol bijgewerkt.');
    }
}
