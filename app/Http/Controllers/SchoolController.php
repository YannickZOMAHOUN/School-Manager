<?php

namespace App\Http\Controllers;
use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function create(){
        return ('dashboard.schools.create');
    }
    public function store(Request $request)
{
    // Validation
    $validated = $request->validate([

    ]);

    // Création de l'école
    $school = School::create([
        'school' => $validated['school'],
       
    ]);

    return response()->json([
        'message' => 'École créée avec succès!',
        'school' => $school,
    ]);
}

}
