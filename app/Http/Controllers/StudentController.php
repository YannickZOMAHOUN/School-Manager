<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Student;
use App\Models\Year;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentsImport;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // Affiche la vue de création d'un étudiant
    public function create(){
        try {
            $classrooms = Classroom::all();
            $years = Year::all();
            return view('dashboard.students.create', compact('classrooms','years'));
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'accès à la page de création : " . $e->getMessage());
            abort(404);
        }
    }

    // Liste tous les étudiants
    public function index(Request $request)
    {
        $classrooms = Classroom::all();
        $years = Year::all();
        $school_id = auth()->user()->school_id;
        return view('dashboard.students.list', compact('classrooms', 'years','school_id'));
    }
    public function getStudentLists(Request $request)
{
    $students = Student::whereHas('recordings', function($query) use ($request) {
        $query->where('classroom_id', $request->classroom_id)
              ->where('year_id', $request->year_id);
    })
    ->where('school_id', $request->school_id) // Ajouté
    ->get();

    return response()->json(['students' => $students]);
}

    // Stocke un nouvel étudiant dans la base de données
    public function store(Request $request) {
        $request->validate([
            'matricule' => 'required|string|max:50|unique:students,matricule',
            'name' => 'required|string|max:100',
            'surname' => 'required|string|max:100',
            'sex' => 'required|string|max:10',
            'birthday' => 'required|date',
            'birth_place' => 'required|string|max:100',
            'classroom_id' => 'required|exists:classrooms,id',
        ]);

        try {
            Student::create([
                'matricule' => $request->matricule,
                'name' => $request->name,
                'surname' => $request->surname,
                'sex' => $request->sex,
                'birthday' => $request->birthday,
                'birth_place' => $request->birth_place,
                'classroom_id' => $request->classroom_id,
            ]);
            return redirect()->route('student.index')->with('success', 'Étudiant ajouté avec succès!');
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'ajout d'un étudiant : " . $e->getMessage());
            abort(404);
        }
    }

    // Met à jour les informations d'un étudiant
    public function update(Request $request, Student $student){
        $request->validate([
            'matricule' => 'required|string|max:50|unique:students,matricule,' . $student->id,
            'name' => 'required|string|max:100',
            'surname' => 'required|string|max:100',
            'sex' => 'required|string|max:10',
            'birthday' => 'required|date',
            'birth_place' => 'required|string|max:100',
            'classroom_id' => 'required|exists:classrooms,id',
        ]);

        try {
            $student->update([
                'matricule' => $request->matricule,
                'name' => $request->name,
                'surname' => $request->surname,
                'sex' => $request->sex,
                'birthday' => $request->birthday,
                'birth_place' => $request->birth_place,
                'classroom_id' => $request->classroom_id,
            ]);

            return redirect()->route('student.index')->with('success', 'Étudiant mis à jour avec succès!');
        } catch (\Exception $e) {
            Log::error("Erreur lors de la mise à jour de l'étudiant : " . $e->getMessage());
            abort(404);
        }
    }

    // Affiche la vue de modification d'un étudiant
    public function edit(Student $student){
        try {
            $classrooms = Classroom::all();
            return view('dashboard.students.edit', compact('student', 'classrooms'));
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'accès à la page de modification : " . $e->getMessage());
            abort(404);
        }
    }

    // Supprime un étudiant
    public function destroy(Student $student){
        try {
            $student->delete();
            return redirect()->route('student.index')->with('success', 'Étudiant supprimé avec succès!');
        } catch (\Exception $e) {
            Log::error("Erreur lors de la suppression de l'étudiant : " . $e->getMessage());
            abort(404);
        }
    }

    // Affiche la vue pour importer des étudiants
    public function importView(){
        try {
            $classrooms = Classroom::all();
            return view('dashboard.students.import', compact('classrooms'));
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'accès à la page d'importation : " . $e->getMessage());
            abort(404);
        }
    }

    // Importe des étudiants depuis un fichier Excel ou CSV
    public function import(Request $request){
        $request->validate([
            'file' => 'required|file|mimes:xls,xlsx,csv',
            'classroom_id' => 'required|exists:classrooms,id',
            'year_id' => 'required|exists:years,id',
        ]);

        try {
            $classroom_id = $request->input('classroom_id');
            $year_id = $request->input('year_id');

            Excel::import(new StudentsImport($classroom_id, $year_id), $request->file('file')->store('files'));

            return redirect()->route('student.index')->with('success', 'Importation réussie!');
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'importation des étudiants : " . $e->getMessage());
            abort(404);
        }
    }


}
