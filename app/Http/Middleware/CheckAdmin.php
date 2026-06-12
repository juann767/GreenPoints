<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || auth()->user()->role?->nombre !== 'admin') {
            abort(403, 'Acceso denegado. Se requieren permisos de administrador.');
        }

        return $next($request);
    }
}
