<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class TwoFactorVerified
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->two_fa_code && $user->two_fa_expires_at->isFuture()) {
            return redirect()->route('two_fa.verify');
        }

        return $next($request);
    }
}

