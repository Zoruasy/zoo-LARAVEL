<?php namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
            $animals->where(function ($query) {
                $query->where('is_active', true)
                    ->orWhere('user_id', Auth::id());
            });
        } else {
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

        return view('catalog', compact('animals', 'speciesOptions', 'habitatOptions'));
    }

    // Laat één dier zien
    public function show($id)
    {
        $animal = Animal::findOrFail($id);
        return view('show', compact('animal'));
    }

    // Toon het formulier om een nieuw dier toe te voegen
    public function create()
    {
        return view('animals.create');
    }

    // Sla het nieuwe dier op in de database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'habitat' => 'required|string',
            'image' => 'image|nullable|max:1999', // Validatie voor afbeeldingen
        ]);

        $animal = Animal::create([
            'name' => $request->input('name'),
            'species' => $request->input('species'),
            'habitat' => $request->input('habitat'),
            'user_id' => Auth::id(),
            'is_active' => true,
        ]);

        Log::info('Nieuw dier toegevoegd door gebruiker ID: ' . Auth::id(), ['animal_id' => $animal->id]);

        return redirect()->route('zoo.catalog')->with('success', 'Dier succesvol toegevoegd.');
    }

    // Bewerk het dier
    public function edit($id)
    {
        $animal = Animal::findOrFail($id);

        // Controleer of de ingelogde gebruiker de eigenaar is
        if (Auth::id() !== $animal->user_id) {
            return redirect()->route('zoo.catalog')->with('error', 'Je hebt geen toegang om dit dier te bewerken.');
        }

        return view('animals.edit', compact('animal'));
    }

    // Werk het dier bij
    public function update(Request $request, $id)
    {
        $animal = Animal::findOrFail($id);

        if (Auth::id() !== $animal->user_id) {
            return redirect()->route('zoo.catalog')->with('error', 'Je hebt geen toegang om dit dier te bewerken.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'habitat' => 'required|string',
            'image' => 'image|nullable|max:1999', // Validatie voor afbeeldingen
        ]);

        $imagePath = $animal->image_path; // Huidige afbeelding behouden
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imagePath = $file->store('images', 'public'); // Nieuwe afbeelding opslaan
        }

        $animal->update($request->only('name', 'species', 'habitat') + ['image_path' => $imagePath]);

        Log::info('Dier bijgewerkt door gebruiker ID: ' . Auth::id(), ['animal_id' => $animal->id]);

        return redirect()->route('zoo.catalog')->with('success', 'Dier succesvol bijgewerkt.');
    }

    // Verwijder het dier
    public function destroy($id)
    {
        $animal = Animal::findOrFail($id);

        if (Auth::id() !== $animal->user_id) {
            return redirect()->route('zoo.catalog')->with('error', 'Je hebt geen toegang om dit dier te verwijderen.');
        }

        // Zorg ervoor dat de gebruiker minstens 3 dieren heeft toegevoegd
        $animalCount = Animal::where('user_id', Auth::id())->count();
        if ($animalCount <= 3) {
            return redirect()->route('zoo.catalog')->withErrors(['error' => 'Je moet minstens 3 dieren hebben toegevoegd voordat je een dier kunt verwijderen.']);
        }

        $animal->delete();
        Log::info('Dier verwijderd door gebruiker ID: ' . Auth::id(), ['animal_id' => $animal->id]);

        return redirect()->route('zoo.catalog')->with('success', 'Dier succesvol verwijderd.');
    }

    // Toggle de actieve/inactieve status van een dier
    public function toggleStatus($id)
    {
        $animal = Animal::findOrFail($id);

        if (Auth::id() !== $animal->user_id) {
            return redirect()->route('zoo.catalog')->with('error', 'Je hebt geen toegang om de status van dit dier te wijzigen.');
        }

        $animal->is_active = !$animal->is_active;
        $animal->save();

        Log::info('Status van dier gewijzigd door gebruiker ID: ' . Auth::id(), ['animal_id' => $animal->id]);

        return redirect()->route('zoo.catalog')->with('success', 'Status van het dier succesvol bijgewerkt.');
    }
}
