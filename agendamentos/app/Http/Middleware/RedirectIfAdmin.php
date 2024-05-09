<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            \Log::info('Usuário está autenticado.');
            if (Auth::user()->is_admin) {
                \Log::info('Usuário é administrador.');
                return redirect('/super');
            }
        } else {
            \Log::info('Usuário não está autenticado.');
        }

        return $next($request);
    }

}

