<?php

namespace App\Http\Middleware;

use Closure;

class MemberMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->role !== 'member') {
            return response()->json([
                'message' => 'Akses hanya untuk member'
            ], 403);
        }

        return $next($request);
    }
}
