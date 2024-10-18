<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\PromotionRecording;
use App\Models\Year;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function create(){
        try{
            $schoolId = auth()->user()->school->id;
            $years = Year::where('school_id', $schoolId)
            ->where('status', true)
            ->get();
            return view('dashboard.classrooms.create',compact('years'));
        }catch (\Exception $e){
            Log::info($e->getMessage());
            abort(404);
        }
    }
    public function store(Request $request)
    {
        // Valider les données reçues
        $validated = $request->validate([
            'year' => 'required|exists:years,id',
            'classrooms' => 'required|array',
            'classrooms.*' => 'required|string', // Chaque champ doit être une chaîne de texte
        ]);

        $year_id = $validated['year'];
        $classrooms = $validated['classrooms'];

        // Boucler sur chaque promotion et sauvegarder les groupes pédagogiques
        foreach ($classrooms as $promotion_id => $group_list) {
            // Les groupes pédagogiques sont une chaîne, on les sépare par des virgules
            $groups = explode(',', $group_list);
            $promotion = PromotionRecording::firstOrCreate(
                [
                    'year_id' => $request->year,
                    'promotion_id' => $promotion_id,
                    'school_id' => auth()->user()->school->id
                ]
            );

            foreach ($groups as $group) {
                // Créer une entrée pour chaque groupe pédagogique
                Classroom::create([
                    'promotion_recording_id' => $promotion->id,
                    'classroom' => trim($group), // Enlever les espaces autour du nom du groupe
                    'year_id' => $year_id,
                    'school_id' => auth()->user()->school->id,
                ]);
            }
        }

        // Redirection avec message de succès
        return redirect()->route('classroom.create')->with('success', 'Les groupes pédagogiques ont été enregistrés avec succès.');
    }

    public function update(Request $request,Classroom $classroom){
        try {
            $classroom->update([
                'classroom' => $request->classroom,
                'school_id'=>auth()->user()->school->id,
            ]);
            return  redirect()->route('classroom.create');
            }catch (\Exception $e){
            Log::info($e->getMessage());
            abort(404);
        }
    }
    public function edit(Classroom $classroom){
        try {
            return view('dashboard.classrooms.edit',compact('classroom'));
        }catch (\Exception $e){
            Log::info($e->getMessage());
            abort(404);
        }
    }

    public function destroy (Classroom $classroom){
        try {
            $classroom->delete();
        return redirect()->back();
        }catch (\Exception $e){
            Log::info($e->getMessage());
            abort(404);
        }
    }
}
