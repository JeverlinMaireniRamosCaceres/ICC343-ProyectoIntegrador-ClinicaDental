<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RolMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $usuario = $request->user();

        if (!$usuario || !in_array($usuario->rol->nombre, $roles)) {
            abort(403);
        }

        return $next($request);
    }
}
