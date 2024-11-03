<?php namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Haal alle gebruikers op en geef ze door aan de manageuser view
        $users = User::all();
        return view('admin.manageuser', compact('users')); // Toon alle gebruikers
    }

    public function edit(User $user)
    {
        // Retourneer de edit view voor de specifieke gebruiker
        return view('admin.edituser', compact('user')); // Zorg ervoor dat deze view bestaat
    }

    public function update(Request $request, User $user)
    {
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
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Gebruiker succesvol verwijderd.');
    }
}
