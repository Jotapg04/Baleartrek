<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('sanctum')->check()) {
            return response()->json(['message' => 'No autenticado'], 401);
        }

        if (Auth::guard('sanctum')->user()->role_id !== 1) {
            return response()->json(['message' => 'Acceso denegado: permisos insuficientes'], 403);
        }

        return $next($request);
    }
}
