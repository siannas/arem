<?php

namespace App\Http\Middleware;

use Closure;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        $myrole = $request->user()->getRole->role;
        foreach ($roles as $role) {
            if ( $myrole == $role) {
                return $next($request);
            }
        }

        return redirect('/')->with('msg', 'Anda tidak berhak mengakses halaman tersebut!');
    }
}
