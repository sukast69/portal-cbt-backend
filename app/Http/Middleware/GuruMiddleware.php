<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GuruMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->isGuru()) {
            return response()->json(['message' => 'Unauthorized. Guru only.'], 403);
        }

        return $next($request);
    }
}
