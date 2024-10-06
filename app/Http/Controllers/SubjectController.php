<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    // Afficher la liste des matières par école
    public function create(){
        try {
            $schoolId = auth()->user()->school->id; // Récupérer l'ID de l'école de l'utilisateur
            $subjects = Subject::where('school_id', $schoolId)->get(); // Filtrer par école
            return view ('dashboard.subjects.create', compact('subjects'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(404);
        }
    }

    // Enregistrer une nouvelle matière avec l'école de l'utilisateur
    public function store(Request $request) {
        try {
            Subject::create([
                'subject' => $request->subject,
                'school_id' => auth()->user()->school->id, // Associer à l'école de l'utilisateur
            ]);
            return redirect()->back();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(404);
        }
    }

    // Mettre à jour une matière avec l'école de l'utilisateur
    public function update(Request $request, Subject $subject) {
        try {
            // Vérifier que la matière appartient bien à l'école de l'utilisateur
            if ($subject->school_id !== auth()->user()->school->id) {
                abort(403, 'Unauthorized action.');
            }

            $subject->update([
                'subject' => $request->subject,
                'school_id' => auth()->user()->school->id, // Toujours s'assurer de l'école
            ]);
            return redirect()->route('dashboard.subjects.create');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(404);
        }
    }

    // Afficher le formulaire d'édition pour une matière
    public function edit(Subject $subject) {
        try {
            // Vérifier que la matière appartient bien à l'école de l'utilisateur
            if ($subject->school_id !== auth()->user()->school->id) {
                abort(403, 'Unauthorized action.');
            }

            return view('dashboard.subjects.edit', compact('subject'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(404);
        }
    }

    // Supprimer une matière
    public function destroy(Subject $subject) {
        try {
            // Vérifier que la matière appartient bien à l'école de l'utilisateur
            if ($subject->school_id !== auth()->user()->school->id) {
                abort(403, 'Unauthorized action.');
            }

            $subject->delete();
            return redirect()->back();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(404);
        }
    }
}
