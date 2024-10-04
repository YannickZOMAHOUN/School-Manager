<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    public function create()
    {
        $roles = Role::all();
        return view('dashboard.staff.create', compact('roles'));
    }

    public function index()
    {
        $staff = Staff::where('school_id', auth()->user()->school->id)->get();
        return view('dashboard.staff.list', compact('staff'));
    }

    public function store(Request $request)
    {
        try {
            // Validation des données
            $request->validate([
                'name' => 'required|string|max:255',
                'surname' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'user_password' => 'required|string|min:8|confirmed', // Vérifie que le mot de passe est confirmé
                'number' => 'required|digits:8',
                'sex' => 'required|in:M,F',
                'role_id' => 'required|exists:roles,id',
            ]);

            // Vérification que l'utilisateur connecté est associé à une école
            if (!auth()->user()->school) {
                return redirect()->back()->with('error', 'Vous n\'êtes pas associé à une école.');
            }

            // Exécution dans une transaction pour garantir l'intégrité des données
            DB::transaction(function () use ($request) {
                // Création de l'utilisateur
                $user = User::create([
                    'school_id' => auth()->user()->school->id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->user_password),
                ]);

                // Création du personnel
                Staff::create([
                    'name' => $request->name,
                    'surname' => $request->surname,
                    'sex' => $request->sex,
                    'number' => $request->number,
                    'school_id' => auth()->user()->school->id,
                    'role_id' => $request->role_id,
                    'user_id' => $user->id,
                ]);
            });

            // Redirection avec message de succès
            return redirect()->route('staff.index')->with('success', 'Utilisateur ajouté avec succès.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la création de l\'utilisateur : ' . $e->getMessage());
        }
    }
}
