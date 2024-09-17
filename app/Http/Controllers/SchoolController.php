<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function create()
    {
        return view('dashboard.schools.create');
    }

    public function store(Request $request)
    {
        // Validation du nom de l'école
        $request->validate([
            'school' => 'required|string|max:255',
        ]);

        // Vérifier si l'école existe déjà dans la base de données
        $school = School::where('school', $request->input('school'))->first();

        // Si l'école existe déjà
        if ($school) {
            // Vérifier s'il y a des utilisateurs associés à cette école
            $usersExist = User::where('school_id', $school->id)->exists();

            if (!$usersExist) {
                // Si aucun utilisateur n'est créé, rediriger vers la page d'inscription
                session(['school_id' => $school->id, 'school_name' => $school->school]);
                return redirect()->route('register')->with('info', 'Cette école existe déjà, veuillez créer au moins un utilisateur.');
            } else {
                // Si des utilisateurs existent déjà, retourner une erreur
                return redirect()->back()->withErrors(['school' => 'Cette école existe déjà avec des utilisateurs associés.']);
            }
        }

        // Si l'école n'existe pas, la créer
        $newSchool = School::create([
            'school' => $request->input('school'),
        ]);

        // Stocker l'ID et le nom de la nouvelle école dans la session
        session(['school_id' => $newSchool->id, 'school_name' => $newSchool->school]);

        // Redirection vers la page d'inscription des utilisateurs
        return redirect()->route('register')->with('success', 'École créée avec succès. Veuillez créer au moins un utilisateur pour cette école.');
    }
}
