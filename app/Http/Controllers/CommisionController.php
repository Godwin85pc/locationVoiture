<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commission;

class CommisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commissions = Commission::all();
        return view('commissions.index', compact('commissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('commissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicule_id' => 'required|exists:vehicules,id',
            'pourcentage' => 'required|numeric|min:0|max:100',
            'montant_particulier' => 'nullable|numeric',
            'montant_agence' => 'nullable|numeric',
        ]);

        Commission::create($validated);

        return redirect()->route('commissions.index')->with('success', 'Commission enregistrée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $commission = Commission::findOrFail($id);
        return view('commissions.show', compact('commission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $commission = Commission::findOrFail($id);
        return view('commissions.edit', compact('commission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $commission = Commission::findOrFail($id);

        $validated = $request->validate([
            'vehicule_id' => 'required|exists:vehicules,id',
            'pourcentage' => 'required|numeric|min:0|max:100',
            'montant_particulier' => 'nullable|numeric',
            'montant_agence' => 'nullable|numeric',
        ]);

        $commission->update($validated);

        return redirect()->route('commissions.index')->with('success', 'Commission modifiée avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $commission = Commission::findOrFail($id);
        $commission->delete();

        return redirect()->route('commissions.index')->with('success', 'Commission supprimée avec succès.');
    }
}
