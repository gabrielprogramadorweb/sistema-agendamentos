<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class ValidateMaxUploadSize
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
        // Defina o tamanho máximo permitido (ex.: 5MB)
        $maxSize = 5 * 1024 * 1024; // 5 Megabytes

        // Verifica se o tamanho do conteúdo excede o máximo permitido
        if ($request->headers->get('content-length') > $maxSize) {
            throw new BadRequestException('The file is too large and cannot be uploaded.');
        }

        return $next($request);
    }
}
