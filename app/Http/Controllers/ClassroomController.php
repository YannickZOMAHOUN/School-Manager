<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Student;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function create(){
        try{
            $classrooms=Classroom::query()->get();
            return view('dashboard.classrooms.create',compact('classrooms'));
        }catch (\Exception $e){
            Log::info($e->getMessage());
            abort(404);
        }
    }
    public function store(Request $request) {
        try {
                Classroom::query()->create([
                'classroom'=>$request->classroom,
                'school'=>auth()->user()->school->id,
            ]);
            return redirect()->back();
        }catch (\Exception $e){
            Log::info($e->getMessage());
            abort(404);
        }
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
