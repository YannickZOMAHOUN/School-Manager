<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function create(){
        try{
            $subjects=Subject::query()->get();
            return view('dashboard.subjects.create',compact('subjects'));
        }catch (\Exception $e){
            Log::info($e->getMessage());
            abort(404);
        }
    }
    public function store(Request $request) {
        try {
                Subject::query()->create([
                'subject'=>$request->subject,
            ]);
            return redirect()->back();
        }catch (\Exception $e){
            Log::info($e->getMessage());
            abort(404);
        }
    }

    public function update(Request $request,Subject $subject){
        try {
            $subject->update([
                'subject' => $request->subject,
            ]);
            return  redirect()->route('dashboard.subjects.create');
            }catch (\Exception $e){
            Log::info($e->getMessage());
            abort(404);
        }
    }
    public function edit(Subject $subject){
        try {
            return view('dashboard.subjects.edit',compact('subject'));
        }catch (\Exception $e){
            Log::info($e->getMessage());
            abort(404);
        }
    }

    public function destroy (Subject $subject){
        try {
            $subject->delete();
        return redirect()->back();
        }catch (\Exception $e){
            Log::info($e->getMessage());
            abort(404);
        }
    }
    
}
