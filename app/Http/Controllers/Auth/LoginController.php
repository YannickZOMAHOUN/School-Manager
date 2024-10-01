<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorCodeMail;
use Carbon\Carbon;
use Illuminate\Http\Request;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        // Générer un code 2FA
        $user->two_fa_code = rand(100000, 999999); // Code à 6 chiffres
        $user->two_fa_expires_at = Carbon::now()->addMinutes(10); // Expire dans 10 minutes
        $user->save();

        // Envoyer le code par email
        Mail::to($user->email)->send(new TwoFactorCodeMail($user));

        // Rediriger vers la page de vérification du code 2FA
        return redirect()->route('two_fa.verify');
    }

}
