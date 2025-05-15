<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check() || !in_array(auth()->user()->poste->role, $roles)) {
            abort(403, 'Accès refusé. Rôle requis : ' . implode(', ', $roles));
        }

        return $next($request);
    }
}
