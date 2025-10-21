<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Models\Utilisateur;

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
            'password' => ['required', 'string'],
        ]);
        // Récupérer l'utilisateur pour déterminer le rôle
        $user = Utilisateur::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'Identifiants incorrects ou compte inexistant.',
            ])->onlyInput('email');
        }

        // Si admin, on utilise le guard 'admin' uniquement (pas le guard web)
        if ($user->role === 'admin') {
            Auth::guard('admin')->login($user, $request->boolean('remember'));
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        // Sinon, utilisateur "classique" via le guard web
        if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'Identifiants incorrects ou compte inexistant.',
        ])->onlyInput('email');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Log out only the web guard (user)
        Auth::guard('web')->logout();

        // If an admin session exists, keep the session so admin stays logged in.
        // Otherwise, perform the full invalidation for security.
        if (Auth::guard('admin')->check()) {
            // Preserve admin auth state; just rotate CSRF token
            $request->session()->regenerateToken();
        } else {
            // No admin session: fully invalidate
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect('/');
    }

    /**
     * Display the admin login view.
     */
    public function createAdmin(): View
    {
        return view('auth.login', ['isAdmin' => true]);
    }

    /**
     * Handle an admin authentication request.
     */
    public function storeAdmin(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Auth admin via admin guard uniquement
        if (Auth::guard('admin')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Identifiants admin incorrects ou compte inexistant.',
        ])->onlyInput('email');
    }
}