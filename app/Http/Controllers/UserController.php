<?php namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
public function index()
{
// Haal alle gebruikers op en geef ze door aan de manageuser view
$users = User::all();
return view('admin.manageuser', compact('users')); // Update naar manageuser
}

public function edit(User $user)
{
// Haal alle gebruikers op voor de table en geef de specifieke gebruiker door
$users = User::all();
return view('admin.manageuser', compact('users', 'user')); // Geef de gebruiker mee voor de bewerking
}

public function update(Request $request, User $user)
{
// Valideer de invoer
$request->validate([
'name' => 'required|string|max:255',
'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
// Andere validaties die je nodig hebt
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
