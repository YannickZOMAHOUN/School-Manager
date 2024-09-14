<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function create()
    {
        return view('dashboard.schools.create');
    }

    public function store(Request $request)
    {
        // Validation des données du formulaire
        $validated = $request->validate([
            'school' => 'required|string|max:255|unique:schools,school', // Validation pour le champ 'school'
        ]);

        // Création de l'école dans la base de données
        $school = School::create([
            'school' => $validated['school'], // Utilisation du champ 'school' défini dans la migration
        ]);

    $schoolId = $school->id;
    $schoolName = $school->school;

    // Stockage de l'ID et du nom de l'école dans la session pour utilisation ultérieure
    session()->flash('school_id', $schoolId);
    session()->flash('school_name', $schoolName);

        // Redirection vers la page d'inscription avec un message de succès
        return redirect()->route('register')->with('success', 'École créée avec succès !');
    }

}
