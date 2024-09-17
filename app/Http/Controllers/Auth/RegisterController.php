<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\School;
use App\Models\Role;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    use RegistersUsers;

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if (!array_key_exists('school_id', $data)) {
            abort(400, 'Le champ school_id est manquant.');
        }

        return Validator::make($data, [
            'school_id' => ['required', 'exists:schools,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->where(function ($query) use ($data) {
                    return $query->where('school_id', $data['school_id']);
                }),
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'surname' => 'required|string|max:255',
            'role_id' => 'required|exists:roles,id',
            'number' => 'required|string',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'school_id' => $data['school_id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Staff::create([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'sex' => $data['sex'],
            'number' => $data['number'],
            'school_id' => $data['school_id'],
            'role_id' => $data['role_id'],
            'user_id' => $user->id, // Utilisation de l'ID de l'utilisateur
        ]);

        return $user;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function registered(Request $request, $user)
    {
        return view('auth.login')->with('status', 'Inscription réussie, veuillez vous connecter.');
    }

    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        $schools = School::all();
        $roles = Role::all();

        // Récupérer l'école depuis la session
        $school_id = session('school_id');
        $school_name = session('school_name');

        return view('auth.register', compact('schools', 'roles', 'school_id', 'school_name'));
    }
}
