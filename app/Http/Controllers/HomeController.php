<?php

namespace App\Http\Controllers;


use App\Models\Classroom;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $schoolId = auth()->user()->school->id;
        $classrooms = Classroom::where('school_id', $schoolId)->count();
        $students = Student::where('school_id', $schoolId)->count();
        $staff = Staff::where('school_id', $schoolId)->count();
        $subjects = Subject::where('school_id', $schoolId)->count();
        return view('accueil', compact('classrooms','students','staff','subjects'));
    }
}
