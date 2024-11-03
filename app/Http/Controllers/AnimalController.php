<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AnimalController extends Controller
{
    // Show all animals with search and filter functionality
    public function catalog(Request $request)
    {
        // Get filter values from the request
        $search = $request->input('search');
        $speciesFilter = $request->input('species');
        $habitatFilter = $request->input('habitat');

        // Build the query for animals with optional search and filter criteria
        $animals = Animal::query();

        // Check if the user is logged in
        if (Auth::check()) {
            $animals->where(function ($query) {
                $query->where('is_active', true)
                    ->orWhere('user_id', Auth::id());
            });
        } else {
            $animals->where('is_active', true);
        }

        // Search by name
        if ($search) {
            $animals->where('name', 'LIKE', "%{$search}%");
        }

        // Filter by species
        if ($speciesFilter) {
            $animals->where('species', $speciesFilter);
        }

        // Filter by habitat
        if ($habitatFilter) {
            $animals->where('habitat', $habitatFilter);
        }

        // Execute the query and retrieve the results
        $animals = $animals->get();

        // Get unique values for filters
        $speciesOptions = Animal::select('species')->distinct()->get();
        $habitatOptions = Animal::select('habitat')->distinct()->get();

        return view('catalog', compact('animals', 'speciesOptions', 'habitatOptions'));
    }

    // Show one animal
    public function show($id)
    {
        $animal = Animal::findOrFail($id);
        return view('show', compact('animal'));
    }

    // Show the form to add a new animal
    public function create()
    {
        // Check if the user is an admin
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('zoo.catalog')->withErrors(['error' => 'You do not have permission to add a new animal.']);
        }

        return view('animals.create');
    }

    // Save the new animal to the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'habitat' => 'required|string',
            'image' => 'image|nullable|max:1999', // Validation for images
        ]);

        $animalData = [
            'name' => $request->input('name'),
            'species' => $request->input('species'),
            'habitat' => $request->input('habitat'),
            'user_id' => Auth::id(),
            'is_active' => true,
        ];

        // Save image
        if ($request->hasFile('image')) {
            $animalData['image'] = $request->file('image')->store('images', 'public');
        }

        $animal = Animal::create($animalData);

        Log::info('New animal added by user ID: ' . Auth::id(), ['animal_id' => $animal->id]);

        return redirect()->route('zoo.catalog')->with('success', 'Animal successfully added.');
    }

    // Edit the animal
    public function edit($id)
    {
        $animal = Animal::findOrFail($id);

        // Check if the user is the owner or an admin
        if ($animal->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return redirect()->route('zoo.catalog')->withErrors(['error' => 'You do not have permission to edit this animal.']);
        }

        return view('editanimal', compact('animal'));
    }

    // Update the animal
    public function update(Request $request, $id)
    {
        $animal = Animal::findOrFail($id);

        // Check if the user is the owner or an admin
        if ($animal->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return redirect()->route('zoo.catalog')->withErrors(['error' => 'You do not have permission to update this animal.']);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'habitat' => 'required|string',
            'image' => 'image|nullable|max:1999', // Validation for images
        ]);

        $animalData = $request->only('name', 'species', 'habitat');

        // Save image
        if ($request->hasFile('image')) {
            if ($animal->image) {
                Storage::disk('public')->delete($animal->image);
            }
            $animalData['image'] = $request->file('image')->store('images', 'public');
        }

        $animal->update($animalData);

        Log::info('Animal updated by user ID: ' . Auth::id(), ['animal_id' => $animal->id]);

        return redirect()->route('zoo.catalog')->with('success', 'Animal successfully updated.');
    }

    // Delete the animal
    public function destroy($id)
    {
        $animal = Animal::findOrFail($id);

        // Check if the user is the owner or an admin
        if ($animal->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return redirect()->route('zoo.catalog')->withErrors(['error' => 'You do not have permission to delete this animal.']);
        }

        // Check if the user has added at least 3 animals
        $animalCount = Animal::where('user_id', Auth::id())->count();
        if ($animalCount <= 3) {
            return redirect()->route('zoo.catalog')->withErrors(['error' => 'You must have added at least 3 animals before you can delete one.']);
        }

        if ($animal->image) {
            Storage::disk('public')->delete($animal->image);
        }

        $animal->delete();
        Log::info('Animal deleted by user ID: ' . Auth::id(), ['animal_id' => $animal->id]);

        return redirect()->route('zoo.catalog')->with('success', 'Animal successfully deleted.');
    }

    // Toggle the active/inactive status of an animal
    public function toggleStatus($id)
    {
        $animal = Animal::findOrFail($id);

        // Check if the user is the owner or an admin
        if ($animal->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return redirect()->route('zoo.catalog')->withErrors(['error' => 'You do not have permission to change the status of this animal.']);
        }

        $animal->is_active = !$animal->is_active;
        $animal->save();

        Log::info('Status of animal changed by user ID: ' . Auth::id(), ['animal_id' => $animal->id]);

        return redirect()->route('zoo.catalog')->with('success', 'Animal status successfully updated.');
    }
}
