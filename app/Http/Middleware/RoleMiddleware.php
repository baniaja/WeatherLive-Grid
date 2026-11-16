<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        if (!$user->hasRole($role)) {
            return response()->json([
                'message' => 'Forbidden. You do not have the required role.',
                'required_role' => $role,
                'your_role' => $user->role?->name,
            ], 403);
        }

        return $next($request);
    }
}

