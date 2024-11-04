<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect('/')->with('error', 'Toegang geweigerd. Je hebt geen toestemming om deze pagina te bekijken.');
        }

        $users = User::all();
        return view('admin.manageuser', compact('users'));
    }

    public function showAdminDashboard()
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect('/')->with('error', 'Toegang geweigerd. Je hebt geen toestemming om deze pagina te bekijken.');
        }

        return view('admindashboard');
    }

    public function edit(User $user)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect('/')->with('error', 'Toegang geweigerd. Je hebt geen toestemming om deze pagina te bekijken.');
        }

        return view('admin.manageuser', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect('/')->with('error', 'Toegang geweigerd. Je hebt geen toestemming om deze pagina te bekijken.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($request->all());
        return redirect()->route('admin.users.index')->with('success', 'Gebruiker succesvol bijgewerkt.');
    }

    public function destroy(User $user)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect('/')->with('error', 'Toegang geweigerd. Je hebt geen toestemming om deze pagina te bekijken.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Gebruiker succesvol verwijderd.');
    }
}
