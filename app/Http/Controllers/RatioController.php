<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Classroom;
use App\Models\Ratio;
use Illuminate\Support\Facades\Log;

class RatioController extends Controller
{
    public function create() {
        try {
            $schoolId = auth()->user()->school->id;

            // Récupérer les matières, classes et ratios
            $subjects = Subject::where('school_id', $schoolId)->get();
            $classrooms = Classroom::where('school_id', $schoolId)->get();
            $ratios = Ratio::where('school_id', $schoolId)->get();

            // Vérifier s'il y a des classes disponibles pour l'école
            if ($classrooms->isEmpty()) {
                return redirect()->back()->with('error', 'Aucune classe disponible pour votre école.');
            }

            // Récupérer tous les niveaux uniques
            $levels = Classroom::where('school_id', auth()->user()->school->id)  // Filtrer les classes par école
            ->pluck('classroom')  // Extraire les noms des classes
            ->map(function ($classroom) {
                return substr($classroom, 0, 5 );  // Récupérer les 3 premiers caractères pour extraire le niveau
            })
            ->unique();  // Obtenir les niveaux uniques


            return view('dashboard.ratios.create', compact('subjects', 'classrooms', 'levels', 'ratios'));
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création des ratios: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la création des ratios.');
        }
    }



    public function store(Request $request) {
        try {
            $schoolId = auth()->user()->school->id;

            // Vérifier si un niveau spécifique est sélectionné
            if ($request->filled('apply_to_level')) {
                $level = $request->apply_to_level;

                // Filtrer les classes qui appartiennent à l'école de l'utilisateur et correspondent au niveau
                $classes = Classroom::where('school_id', $schoolId)
                                    ->where('classroom', 'like', "$level%")
                                    ->get();

                // Appliquer le coefficient à toutes les classes de ce niveau
                foreach ($classes as $classroom) {
                    Ratio::create([
                        'ratio' => $request->ratio,
                        'classroom_id' => $classroom->id,
                        'subject_id' => $request->subject,
                        'school_id' => $schoolId,
                    ]);
                }
            } else {
                // Appliquer le coefficient aux classes sélectionnées manuellement
                foreach ($request->classroom as $classroom_id) {
                    // Vérifier que la classe appartient bien à l'école de l'utilisateur
                    $classroom = Classroom::where('id', $classroom_id)
                                          ->where('school_id', $schoolId)
                                          ->first();

                    if ($classroom) {
                        Ratio::create([
                            'ratio' => $request->ratio,
                            'classroom_id' => $classroom->id,
                            'subject_id' => $request->subject,
                            'school_id' => $schoolId,
                        ]);
                    }
                }
            }

            return redirect()->back()->with('success', 'Les coefficients ont été ajoutés avec succès.');
        } catch (\Exception $e) {
            Log::info('Erreur lors de l\'ajout des coefficients: ' . $e->getMessage());
            abort(404);
        }
    }

    public function edit(Ratio $ratio) {
        try {
            $schoolId = auth()->user()->school->id;
            $subjects = Subject::where('school_id', $schoolId)->get();
            $classrooms = Classroom::where('school_id', $schoolId)->get();
            return view('dashboard.ratios.edit', compact('ratio', 'subjects', 'classrooms'));
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            abort(404);
        }
    }

    public function update(Request $request, Ratio $ratio) {
        try {
            $ratio->update([
                'ratio' => $request->ratio,
                'classroom_id' => $request->classroom,
                'subject_id' => $request->subject,
                'school_id' => auth()->user()->school->id,
            ]);

            return redirect()->route('ratio.create')->with('success', 'Coefficient mis à jour avec succès.');
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            abort(404);
        }
    }

    public function destroy(Ratio $ratio) {
        try {
            $ratio->delete();
            return redirect()->back()->with('success', 'Coefficient supprimé avec succès.');
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            abort(404);
        }
    }
    public function destroyAll()
{
    // Supprime tous les coefficients associés à l'école de l'utilisateur connecté
    $schoolId = auth()->user()->school->id;
    Ratio::where('school_id', $schoolId)->delete();
    return redirect()->back()->with('success', 'Tous les coefficients ont été supprimés.');
}

}
