<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
public function showAdminDashboard()
{
// Check if the user is authenticated and is an admin
if (!auth()->check() || !auth()->user()->is_admin) {
return redirect('/'); // Redirect to the home page if not an admin
}

return view('admindashboard'); // Show the admin dashboard
}
}
