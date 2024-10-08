<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Role;
use App\Models\User;
use App\Models\Country;
use App\Models\Department;
use App\Models\City;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class SchoolController extends Controller
{
    public function create()
    {
        $countries = Country::all();
        $departments=Department::all();
        $cities=City::all();
        return view('dashboard.schools.create',compact('countries','departments','cities'));
    }


    public function store(Request $request)
{
    // Validation des données d'entrée
    $request->validate([
        'school' => 'required|string|max:255',
        'role_name' => 'required|string|max:255',
        'country_id' => 'required|exists:countries,id',
        'department_id' => 'required|exists:departments,id',
        'city_id' => 'required|exists:cities,id',
    ]);

    // Démarrer une transaction
    DB::beginTransaction();

    try {
        // Vérifier si l'école existe déjà
        $school = School::where('school', $request->input('school'))->first();

        if ($school) {
            // Vérifier s'il y a des utilisateurs associés à cette école
            $usersExist = User::where('school_id', $school->id)->exists();

            if (!$usersExist) {
                // Rediriger vers la page d'inscription si aucun utilisateur n'est créé
                session(['school_id' => $school->id, 'school_name' => $school->school]);
                return redirect()->route('register')->with('info', 'Cette école existe déjà. Veuillez créer au moins un utilisateur.');
            } else {
                // Retourner une erreur si des utilisateurs existent déjà
                return redirect()->back()->withErrors(['school' => 'Cette école existe déjà avec des utilisateurs associés.']);
            }
        }

        // Créer la nouvelle école
        $newSchool = School::create([
            'school' => $request->input('school'),
            'country_id' => $request->input('country_id'),
            'department_id' => $request->input('department_id'),
            'city_id' => $request->input('city_id'),
        ]);

        // Création des rôles
        $roles = explode(';', $request->input('role_name')); // Diviser les rôles par point-virgule

        foreach ($roles as $roleName) {
            $trimmedRoleName = trim($roleName);

            // Vérification de l'unicité du rôle
            if (Role::where('role_name', $trimmedRoleName)->where('school_id', $newSchool->id)->exists()) {
                return redirect()->back()->withErrors(['role_name' => "Le rôle '$trimmedRoleName' existe déjà pour cette école."]);
            }

            Role::create([
                'role_name' => $trimmedRoleName,
                'school_id' => $newSchool->id,
            ]);
        }

        // Valider les changements
        DB::commit();

        // Stocker l'ID et le nom de la nouvelle école dans la session
        session(['school_id' => $newSchool->id, 'school_name' => $newSchool->school]);

        // Redirection vers la page d'inscription des utilisateurs
        return redirect()->route('register')->with('success', 'École créée avec succès. Veuillez créer au moins un utilisateur pour cette école.');
    } catch (\Exception $e) {
        // Annuler les modifications en cas d'erreur
        DB::rollback();
        return redirect()->back()->withErrors(['error' => 'Une erreur s\'est produite lors de la création de l\'école.']);
    }
}
public function getDepartments($countryId)
    {
        $departments = Department::where('country_id', $countryId)->get();
        return response()->json($departments);
    }

    public function getCities($departmentId)
    {
        $cities = City::where('department_id', $departmentId)->get();
        return response()->json($cities);
    }


}
