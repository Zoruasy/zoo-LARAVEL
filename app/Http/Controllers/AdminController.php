<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function showAdminDashboard()
    {
        // Check if the user is authenticated and has the 'gebruiker' role
        if (!auth()->check() || auth()->user()->role !== 'gebruiker') {
            // Log the unauthorized access attempt
            Log::warning('Unauthorized access attempt to admin dashboard by user ID: ' . (auth()->check() ? auth()->user()->id : 'Guest'));
            return redirect('/')->with('error', 'Toegang geweigerd. Je hebt geen toestemming om deze pagina te bekijken.');
        }

        // Fetch all users to pass to the view
        $users = User::all();

        return view('admindashboard', compact('users'));
    }
}
