<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        $userRole = $request->user()->role->value;

        if (! in_array($userRole, $roles)) {
            abort(403, 'Access Forbidden');
        }

        return $next($request);
    }
}
