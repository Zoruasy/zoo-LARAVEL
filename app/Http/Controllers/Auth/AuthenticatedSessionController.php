<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Authenticate the user
        if (!Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            // Voeg een foutmelding toe voor ongeldige inloggegevens
            return back()->withErrors([
                'email' => 'Deze inloggegevens zijn onjuist.',
            ])->onlyInput('email'); // Zorg ervoor dat het email veld behouden blijft
        }

        // Regenerate the session
        $request->session()->regenerate();

        // Redirect naar de catalogus na inloggen
        return redirect()->intended(route('zoo.catalog'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Log the user out
        Auth::guard('web')->logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the CSRF token
        $request->session()->regenerateToken();

        // Redirect naar de homepagina na uitloggen
        return redirect('/');
    }
}
