<?php

namespace App\Http\Controllers;
use App\Models\Recording;
use App\Models\Ratio;
use App\Models\Classroom;
use App\Models\Year;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NoteController extends Controller
{
    public function getStudents(Request $request) {
        $students = Recording::where('year_id', $request->year_id)
                             ->where('classroom_id', $request->classroom_id)
                             ->with('student') // Assuming 'student' is the relation on 'Recording'
                             ->get()->pluck('student');
        return response()->json($students);
    }

    public function getRatio(Request $request) {
        $ratio = Ratio::where('subject_id', $request->subject_id)
                      ->where('classroom_id', $request->classroom_id)
                      ->first();
        return response()->json(['ratio' => $ratio ? $ratio->ratio : null]);
    }

    public function create(){
        try {
                    $subjects = Subject::all();
                    $classrooms = Classroom::all();
                    $years = Year::all();
                    $students = Student::all();
                    return view('dashboard.notes.create',compact(['subjects','classrooms','students','years']));
        }catch (\Exception $e){
            Log::info($e->getMessage());
            abort(404);
        }
    }

}
