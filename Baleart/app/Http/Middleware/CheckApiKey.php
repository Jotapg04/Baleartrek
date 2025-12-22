<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckApiKey
{
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('x-api-key');
        if ($apiKey !== env('APP_KEY')) {
            return response()->json(['Error' => 'Clave inválida'], 401);
        }
        return $next($request);
    }
}
