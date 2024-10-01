<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TwoFactorController extends Controller
{
    /**
     * Affiche le formulaire de vérification two_FA
     *
     * @return \Illuminate\View\View
     */
    public function showVerifyForm()
    {
        return view('auth.two_factor_verify');
    }

    /**
     * Vérifie le code two_FA entré par l'utilisateur
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(Request $request)
    {
        // Vérifier si l'utilisateur est toujours authentifié
        if (!Auth::check()) {
            return redirect('/login')->withErrors(['session_expired' => 'Votre session a expiré, veuillez vous reconnecter.']);
        }

        // Valider le champ two_FA avec message personnalisé
        $request->validate([
            'two_fa_code' => 'required',
        ], [
            'two_fa_code.required' => 'Le code de vérification est requis.',
        ]);

        $user = Auth::user();

        // Vérifier la validité du code two_FA et son expiration
        if ($user->two_fa_code === $request->two_fa_code && $user->two_fa_expires_at->isFuture()) {
            // Réinitialiser le code two_FA en cas de succès
            $user->resetTwoFactorCode();

            // Réinitialiser les tentatives échouées
            session()->forget('two_fa_attempts');

            // Rediriger vers la page prévue après connexion
            return redirect()->intended($this->redirectTo());
        }

        // Limiter les tentatives de code incorrect
        $maxAttempts = 3;

        if (session('two_fa_attempts', 0) >= $maxAttempts) {
            return redirect('/login')->withErrors(['max_attempts' => 'Trop de tentatives échouées, veuillez vous reconnecter.']);
        }

        // Incrémenter les tentatives échouées
        session(['two_fa_attempts' => session('two_fa_attempts', 0) + 1]);

        return back()->withErrors(['two_fa_code' => 'Le code est incorrect ou a expiré.']);
    }

    /**
     * Définir la redirection après la vérification two_FA réussie.
     *
     * @return string
     */
    protected function redirectTo()
    {
        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/dashboard';
    }
}
