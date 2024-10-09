<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Staff ;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function create(User $user)
    {
        return view('dashboard.users.create', compact('user'));
    }

    public function changeprofil(Request $request) {
        $user = User::findOrFail(auth()->user()->id);

        $validatorCorporate = Validator::make($request->all(), [
            'currentPassword' => 'required',
            'newPassword' => 'required|min:8|confirmed', // Ajout d'une confirmation de mot de passe et longueur minimale
        ]);

        if ($validatorCorporate->fails()) {
            return back()->withErrors($validatorCorporate)->withInput();
        }

        if (!Hash::check($request->currentPassword, $user->password)) {
            return back()->with('error', "Le mot de passe actuel est incorrect.");
        }

        if (Hash::check($request->newPassword, $user->password)) {
            return back()->with('error', "Le nouveau mot de passe ne peut pas être identique à l'ancien.");
        }

        // Changer le mot de passe
        $user->password = Hash::make($request->newPassword);
        $user->save();

        return redirect()->route('user.create')->with('success', "Mot de passe changé avec succès.");
    }

public function editprofil(Request $request){
    try {
        $schoolId = auth()->user()->school->id;
        $user = User::query()->find(auth()->user()->id);
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id . ',id,school_id,' . $schoolId, // Vérifier l'unicité en excluant l'email actuel
            'number' => 'required|digits:8',
        ]);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        $staff = Staff::where('user_id', $user->id)->first(); // Rechercher le personnel par user_id
        if ($staff) {
            $staff->update([ // Mettre à jour l'instance trouvée
                'name' => $request->name,
                'surname' => $request->surname,
                'number' => $request->number,
            ]);
        }
        return  redirect()->route('user.create');
    }catch (\Exception $e){
        Log::info($e->getMessage());
        abort(404);
    }
}
}
