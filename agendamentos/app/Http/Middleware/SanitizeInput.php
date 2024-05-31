<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SanitizeInput
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $inputs = $request->all();
        foreach ($inputs as $key => $value) {
            if (is_string($value)) {
                $inputs[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            }
        }
        $request->merge($inputs);
        return $next($request);
    }

}
