<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:' . User::class,

                'email:rfc,dns' // Controleert of het e-mailadres geldig is
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'postcode' => ['required', 'regex:/^\d{4}[ ]?[A-Z]{2}$/'], // Voorbeeld voor Nederlandse postcodes
        ], [
            'name.required' => 'Het veld naam is verplicht.',
            'email.required' => 'Het veld e-mailadres is verplicht.',
            'email.email' => 'Voer een geldig e-mailadres in.',
            'email.unique' => 'Dit e-mailadres is al geregistreerd.',
            'email.dns' => 'Het domein van het e-mailadres bestaat niet.', // Aangepaste foutmelding voor dns
            'password.required' => 'Het wachtwoord is verplicht.',
            'password.confirmed' => 'De wachtwoorden komen niet overeen.',
            'postcode.required' => 'Het veld postcode is verplicht.',
            'postcode.regex' => 'Voer een geldige postcode in (bijv. 1234 AB).',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
