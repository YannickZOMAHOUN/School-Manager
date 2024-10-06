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
        $roles = Role::where('school_id', auth()->user()->school->id)->get();
        return view('dashboard.staff.create', compact('roles'));
    }

    public function index()
    {
        $staff = Staff::where('school_id', auth()->user()->school->id)->get();
        return view('dashboard.staff.list', compact('staff'));
    }

    public function store(Request $request)
    {
        $schoolId = auth()->user()->school->id;

        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,NULL,id,school_id,' . $schoolId, // Unicité combinée sur email et school_id
            'user_password' => 'required|string|min:8|confirmed',
            'number' => 'required|digits:8',
            'sex' => 'required|in:M,F',
            'role_id' => 'required|exists:roles,id',
        ]);

        try {
            if (!auth()->user()->school) {
                return redirect()->back()->with('error', 'Vous n\'êtes pas associé à une école.');
            }

            DB::transaction(function () use ($request, $schoolId) {
                // Création de l'utilisateur
                $user = User::create([
                    'school_id' => $schoolId,
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
                    'school_id' => $schoolId,
                    'role_id' => $request->role_id,
                    'user_id' => $user->id,
                ]);
            });

            return redirect()->route('staff.index')->with('success', 'Utilisateur ajouté avec succès.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la création de l\'utilisateur : ' . $e->getMessage());
        }
    }

    public function edit(Staff $staff) {
        try {
            if ($staff->school_id !== auth()->user()->school->id) {
                abort(403, 'Unauthorized action.');
            }
            $roles = Role::where('school_id', auth()->user()->school->id)->get();
            return view('dashboard.staff.edit', compact('staff','roles'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(404);
        }
    }

    public function update(Request $request, Staff $staff)
    {
        $schoolId = auth()->user()->school->id;

        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $staff->user->id . ',id,school_id,' . $schoolId, // Vérifier l'unicité en excluant l'email actuel
            'number' => 'required|digits:8',
            'sex' => 'required|in:M,F',
            'role_id' => 'required|exists:roles,id',
        ]);

        if ($staff->school_id !== auth()->user()->school->id) {
            return redirect()->back()->with('error', 'Action non autorisée.');
        }

        try {
            // Mettre à jour l'utilisateur lié
            $staff->user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // Mettre à jour les informations du personnel
            $staff->update([
                'name' => $request->name,
                'surname' => $request->surname,
                'number' => $request->number,
                'sex' => $request->sex,
            ]);

            return redirect()->route('staff.index')->with('success', 'Les informations du personnel ont été mises à jour.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la mise à jour.');
        }
    }

public function destroy(Staff $staff)
{
    try {
        // Vérifier que le staff appartient bien à l'école de l'utilisateur connecté
        if ($staff->school_id !== auth()->user()->school->id) {
            abort(403, 'Unauthorized action.');
        }
        $staff->user()->delete();
        $staff->delete();
        return redirect()->back()->with('success', 'Personnel et utilisateur supprimés avec succès.');
    } catch (\Exception $e) {
        Log::error($e->getMessage());
        abort(404, 'Erreur lors de la suppression.');
    }
}
}
