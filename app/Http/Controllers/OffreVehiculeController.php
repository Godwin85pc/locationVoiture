<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OffreVehicule;

class OffreVehiculeController extends Controller
{
    public function fetch()
    {
        return response()->json(OffreVehicule::all());
    }
}