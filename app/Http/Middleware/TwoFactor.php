<?php

namespace App\Http\Middleware;

use Closure;

class TwoFactor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        if(auth()->check() && $user->two_factor_pass)
        {
            // authentication is currently at step 2

            if($user->two_factor_expires_at->lt(now()))
            {
                // the time for resolving step 2 has expired

                $user->reset_two_factor_data();
                auth()->logout();

                return redirect()->route('login')->withMessage('The two factor code has expired. Please login again.');
            }

            if(!$request->is('otp*'))
            {
                // step 2 of the authentication must be resolved

                return redirect()->route('otp.index');
            }
        }

        return $next($request);
    }
}
