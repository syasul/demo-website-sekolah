<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! $request->user()) {
            abort(403, 'Unauthorized access.');
        }

        // Support comma-separated strings as well e.g. 'admin,guru'
        $allowed = [];
        foreach ($roles as $r) {
            foreach (explode(',', $r) as $part) {
                $allowed[] = trim($part);
            }
        }

        if (! in_array($request->user()->role, $allowed, true)) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
