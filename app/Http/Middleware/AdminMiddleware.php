<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier si l'utilisateur est connecté via le guard 'admin'
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login')->with('error', 'Veuillez vous connecter en tant qu\'administrateur.');
        }

        // Vérifier si l'utilisateur a le rôle admin
        if (Auth::guard('admin')->user()->role !== 'admin') {
            abort(403, 'Accès refusé. Vous devez être administrateur pour accéder à cette page.');
        }

        return $next($request);
    }
}
