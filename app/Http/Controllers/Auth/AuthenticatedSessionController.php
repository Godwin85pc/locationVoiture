<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'mot_de_passe' => ['required', 'string'],
        ]);

        // Debug : affiche les données reçues du formulaire
        // dd($request->all());

        // Vérifie si l'utilisateur existe
        $user = \App\Models\Utilisateur::where('email', $request->email)->first();
        if (!$user) {
            dd('Email non trouvé');
        }

        // Vérifie si le mot de passe correspond
        if (!Hash::check($request->mot_de_passe, $user->mot_de_passe)) {
            dd('Mot de passe incorrect');
        }

        // Vérifie le provider utilisé par le guard
        $providerModel = get_class(Auth::getProvider()->retrieveByCredentials(['email' => $request->email]));
        if ($providerModel !== \App\Models\Utilisateur::class) {
            dd('Provider utilisé : ' . $providerModel);
        }

        // Authentification Laravel
        if (Auth::attempt(['email' => $request->email, 'password' => $request->mot_de_passe], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
           'email' => 'Identifiants non corrects.',
           'mot_de_passe' => 'Mot de passe non correct.',
       ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
