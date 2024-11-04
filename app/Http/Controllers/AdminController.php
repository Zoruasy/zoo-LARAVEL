<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function showAdminDashboard()
    {
        // Check if the user is authenticated and is an admin
        if (!auth()->check() || !auth()->user()->is_admin) {
            Log::warning('Unauthorized access attempt to admin dashboard by user ID: ' . (auth()->check() ? auth()->user()->id : 'Guest'));
            return redirect('/')->with('error', 'Toegang geweigerd. Je hebt geen toestemming om deze pagina te bekijken.'); // Redirect to the home page with an error message
        }

        // Fetch all users to pass to the view
        $users = User::all();

        return view('admindashboard', compact('users')); // Pass the users to the admin dashboard view
    }
}
