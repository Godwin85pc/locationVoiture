<?php

namespace App\Http\Controllers\Auth;

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
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'mot_de_passe' => ['required', 'string'],
        ]);

        if (Auth::attempt(['email' => $request->email, 'mot_de_passe' => $request->mot_de_passe], $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->role === 'particulier') {
                return redirect()->route('ajout_voitures');
            } elseif ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Les identifiants sont incorrects.',
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
