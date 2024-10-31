<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class AdminController extends Controller
{

public function showAdminDashboard()
{
    // Check if the user is authenticated and is an admin
    if (!auth()->check() || !auth()->user()->isAdmin()) {
        return redirect('/'); // Redirect to the home page if not an admin
    }

    // Fetch all users to pass to the view
    $users = User::all();

    return view('admindashboard', compact('users')); // Ensure this matches the name of your Blade file
}

}
