<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use App\Models\PromotionRecording;
use App\Models\Year;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;


class PromotionController extends Controller
{
    public function create(){
        try{
            $schoolId = auth()->user()->school->id;
            $years = Year::where('school_id', $schoolId)
            ->where('status', true)
            ->get();
            $promotions=Promotion::all();
            return view('dashboard.promotions.create',compact('years','promotions'));
        }catch (\Exception $e){
            Log::info($e->getMessage());
            abort(404);
        }
    }
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'year' => 'required|exists:years,id',
            'promotion_ids' => 'required|array',
            'promotion_ids.*' => 'exists:promotions,id',
        ]);

        // Récupération de l'année scolaire
        $year_id = $request->input('year');

        // Récupération des promotions cochées
        $promotion_ids = $request->input('promotion_ids');

        // Enregistrement des promotions dans la table 'promotions'
        foreach ($promotion_ids as $promotion_id) {
           PromotionRecording::create([
                'year_id' => $year_id,
                'school_id' => auth()->user()->school->id,  // Utilisation de l'école de l'utilisateur connecté
                'promotion_id' => $promotion_id,
            ]);
        }

        // Redirection avec un message de succès
        return redirect()->back()->with('success', 'Promotions enregistrées avec succès.');
    }

    public function getPromotions(Request $request) {
        $promotions = PromotionRecording::where('year_id', $request->year_id)
        ->where('school_id', auth()->user()->school_id)
        ->with('promotion')
        ->get()
        ->pluck('promotion');
        return response()->json($promotions);
    }

}
