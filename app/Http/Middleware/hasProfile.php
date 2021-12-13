<?php

namespace App\Http\Middleware;

use Closure;

class hasProfile
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
        if ( $request->user()->profil ) {
            return $next($request);
        }

        return back()->with('error', 'Anda belum mengisi Profil! Silahkan mengisi terlebih dahulu <a href="'.route('profil.show').'">disini</a> ');
    }
}
