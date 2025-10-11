<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use \App\Models\Vehicule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UtilisateurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupère tous les utilisateurs depuis la base de données
        $utilisateurs = Utilisateur::all();

        // Retourne la vue 'utilisateurs.index' avec la liste des utilisateurs
        return view('utilisateurs.index', compact('utilisateurs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('utilisateurs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'required|email|unique:utilisateurs,email',
            'mot_de_passe' => 'required|string|min:6',
            'telephone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,client,particulier',
        ]);

        $validated['mot_de_passe'] = bcrypt($validated['mot_de_passe']);

        Utilisateur::create($validated);

        return redirect()->route('utilisateurs.index')->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
  
    public function show($id)
{
    $vehicule = Vehicule::findOrFail($id);
    return view('partials.vehicule_details', compact('vehicule'));
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $utilisateur = Utilisateur::findOrFail($id);
        return view('utilisateurs.edit', compact('utilisateur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $utilisateur = Utilisateur::findOrFail($id);

        $validated = $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'required|email|unique:utilisateurs,email,' . $id,
            'mot_de_passe' => 'nullable|string|min:6',
            'telephone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,client,particulier',
        ]);

        if (!empty($validated['mot_de_passe'])) {
            $validated['mot_de_passe'] = bcrypt($validated['mot_de_passe']);
        } else {
            unset($validated['mot_de_passe']);
        }

        $utilisateur->update($validated);

        return redirect()->route('utilisateurs.index')->with('success', 'Utilisateur modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $utilisateur = Utilisateur::findOrFail($id);
        $utilisateur->delete();

        return redirect()->route('utilisateurs.index')->with('success', 'Utilisateur supprimé avec succès.');
    }

    /**
     * Display the admin dashboard.
     */
    public function adminDashboard()
    {
        $utilisateurs = Utilisateur::all();
        $clients = Utilisateur::where('role', 'client')->get();
        $particuliers = Utilisateur::where('role', 'particulier')->get();
        $admins = Utilisateur::where('role', 'admin')->get();
        $vehicules = Vehicule::where('proprietaire_id', optional(Auth::user())->id)->get();

        return view('admin.dashboard', compact('utilisateurs', 'clients', 'particuliers', 'admins', 'vehicules'));
    }
}
