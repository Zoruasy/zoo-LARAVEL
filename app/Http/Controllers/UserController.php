<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Display a list of users
    public function index()
    {
        $this->authorizeAdmin();

        // Get all users
        $users = User::all();
        return view('admin.manageuser', compact('users')); // Updated to the new view name
    }

    // Show the edit form for a user
    public function edit(User $user)
    {
        $this->authorizeAdmin();

        return view('profile.edit', compact('user')); // Updated to the correct path
    }

    // Update user details
    public function update(Request $request, User $user)
    {
        $this->authorizeAdmin();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'is_admin' => 'required|boolean',
        ]);

        $user->update($request->only(['name', 'email', 'is_admin'])); // Use only to update specific fields

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    // Delete a user
    public function destroy(User $user)
    {
        $this->authorizeAdmin();

        $user->delete(); // Delete the user
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    // Custom method to authorize admin
    private function authorizeAdmin()
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            return redirect('/')->with('error', 'You are not authorized to access this page.');
        }
    }
}
