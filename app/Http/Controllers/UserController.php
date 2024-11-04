<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        // Check if the user is authenticated and is an admin
        if (!auth()->check() || auth()->user()->is_admin !== 1) {
            Log::warning('Unauthorized access attempt to user management by user ID: ' . (auth()->check() ? auth()->user()->id : 'Guest'));
            return redirect('/')->with('error', 'Toegang geweigerd. Je hebt geen toestemming om deze pagina te bekijken.');
        }

        // Haal alle gebruikers op en geef ze door aan de manageuser view
        $users = User::all();
        return view('admin.manageuser', compact('users')); // Toon alle gebruikers
    }

    public function edit(User $user)
    {
        // Check if the user is authenticated and is an admin
        if (!auth()->check() || auth()->user()->is_admin !== 1) {
            Log::warning('Unauthorized access attempt to edit user ID: ' . (auth()->check() ? auth()->user()->id : 'Guest'));
            return redirect('/')->with('error', 'Toegang geweigerd. Je hebt geen toestemming om deze pagina te bekijken.');
        }

        // Retourneer de edit view voor de specifieke gebruiker
        return view('admin.manageuser', compact('user')); // Zorg ervoor dat deze view bestaat
    }

    public function update(Request $request, User $user)
    {
        // Check if the user is authenticated and is an admin
        if (!auth()->check() || auth()->user()->is_admin !== 1) {
            Log::warning('Unauthorized access attempt to update user ID: ' . (auth()->check() ? auth()->user()->id : 'Guest'));
            return redirect('/')->with('error', 'Toegang geweigerd. Je hebt geen toestemming om deze pagina te bekijken.');
        }

        // Valideer de invoer
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        // Werk de gebruiker bij
        $user->update($request->all());

        return redirect()->route('admin.users.index')->with('success', 'Gebruiker succesvol bijgewerkt.');
    }

    public function destroy(User $user)
    {
        // Check if the user is authenticated and is an admin
        if (!auth()->check() || auth()->user()->is_admin !== 1) {
            Log::warning('Unauthorized access attempt to delete user ID: ' . (auth()->check() ? auth()->user()->id : 'Guest'));
            return redirect('/')->with('error', 'Toegang geweigerd. Je hebt geen toestemming om deze pagina te bekijken.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Gebruiker succesvol verwijderd.');
    }
}
