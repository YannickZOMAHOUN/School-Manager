<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Classroom;
use App\Models\Ratio;
use Illuminate\Support\Facades\Log;

class RatioController extends Controller
{
    public function create(){
        try {
                    $subjects = Subject::all();
                    $classrooms = Classroom::all();
                    $ratios=Ratio::query()->get();
                    return view('dashboard.ratios.create',compact(['subjects','classrooms','ratios']));
        }catch (\Exception $e){
            Log::info($e->getMessage());
            abort(404);
        }
    }
    public function store(Request $request) {
        try {
                Ratio::query()->create([
                'ratio'=>$request->ratio,
                'classroom_id'=>$request->classroom,
                'subject_id'=>$request->subject,
                'school_id'=>auth()->user()->school->id,
            ]);
            return redirect()->back();
        }catch (\Exception $e){
            Log::info($e->getMessage());
            abort(404);
        }
    }

    public function update(Request $request,Ratio $ratio){
        try {
            $ratio->update([
                'ratio'=>$request->ratio,
                'classroom_id'=>$request->classroom,
                'subject_id'=>$request->subject,
                'school_id'=>auth()->user()->school->id,
            ]);
            return  redirect()->route('ratio.create');
            }catch (\Exception $e){
            Log::info($e->getMessage());
            abort(404);
        }
    }
    public function edit(Ratio $ratio){
        try {
            $subjects = Subject::all();
            $classrooms = Classroom::all();
            return view('dashboard.ratios.edit',compact('ratio','subjects','classrooms'));
        }catch (\Exception $e){
            Log::info($e->getMessage());
            abort(404);
        }
    }

    public function destroy (Ratio $ratio){
        try {
            $ratio->delete();
        return redirect()->back();
        }catch (\Exception $e){
            Log::info($e->getMessage());
            abort(404);
        }
    }
}
