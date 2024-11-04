<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Method for the admin dashboard
    public function dashboard()
    {
        // Check if the logged-in user is an admin
        if (Auth::user() && Auth::user()->isAdmin()) {
            // Retrieve all users
            $users = User::all();
            return view('admindashboard', compact('users'));
        }

        // Return the access denied view without .blade.php extension
        return view('access-denied');
    }

    // Method for listing all users
    public function index()
    {
        // Check if the logged-in user is an admin
        if (Auth::user() && Auth::user()->isAdmin()) {
            // Retrieve all users
            $users = User::all();
            return view('admin.manageuser', compact('users'));
        }

        // Return the access denied view without .blade.php extension
        return view('access-denied');
    }

    // Method for editing a user
    public function editUser(User $user)
    {
        // Check if the logged-in user is an admin
        if (Auth::user() && Auth::user()->isAdmin()) {
            return view('admin.manageuser', compact('user'));
        }

        // Return the access denied view without .blade.php extension
        return view('access-denied');
    }

    // Method for updating a user
    public function updateUser(Request $request, User $user)
    {
        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'is_admin' => 'boolean',
        ]);

        // Update the user
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->is_admin = $request->input('is_admin', false);
        $user->save();

        return redirect()->route('admin.dashboard')->with('success', 'User successfully updated.');
    }

    // Method for deleting a user
    public function destroyUser(User $user)
    {
        // Check if the logged-in user is an admin
        if (Auth::user() && Auth::user()->isAdmin()) {
            $user->delete();
            return redirect()->route('admin.dashboard')->with('success', 'User successfully deleted.');
        }

        // Return the access denied view without .blade.php extension
        return view('access-denied');
    }
}
