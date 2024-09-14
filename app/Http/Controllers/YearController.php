<?php

namespace App\Http\Controllers;

use App\Models\Year;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class YearController extends Controller
{
    public function create(){
        try{
            $years=year::query()->get();
            return view('dashboard.years.create',compact('years'));
        }catch (\Exception $e){
            Log::info($e->getMessage());
            abort(404);
        }
    }
    public function store(Request $request) {
        try {
                year::query()->create([
                'year'=>$request->year,
                'school_id'=>auth()->user()->school->id,
            ]);
            return redirect()->back();
        }catch (\Exception $e){
            Log::info($e->getMessage());
            abort(404);
        }
    }

    public function update(Request $request,year $year){
        try {
            $year->update([
                'year' => $request->year,
                'school_id'=>auth()->user()->school->id,
            ]);
            return  redirect()->route('dashboard.years.create');
            }catch (\Exception $e){
            Log::info($e->getMessage());
            abort(404);
        }
    }
    public function edit(year $year){
        try {
            return view('dashboard.years.edit',compact('year'));
        }catch (\Exception $e){
            Log::info($e->getMessage());
            abort(404);
        }
    }

    public function destroy (year $year){
        try {
            $year->delete();
        return redirect()->back();
        }catch (\Exception $e){
            Log::info($e->getMessage());
            abort(404);
        }
    }
}
