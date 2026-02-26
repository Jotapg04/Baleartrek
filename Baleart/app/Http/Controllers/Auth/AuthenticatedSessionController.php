<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }


public function store(LoginRequest $request)
{
    $request->authenticate();

    // Si la petición espera JSON (API), enviamos el Token
    if ($request->expectsJson()) {
        $user = $request->user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }

    // Si es una petición normal de navegador (Backoffice)
    $request->session()->regenerate();
    return redirect()->intended(route('dashboard'));
}


    /**
     * Destroy an authenticated session.
     */
   public function destroy(Request $request)
{
    // Revocar el token actual del usuario
    $request->user()->currentAccessToken()->delete();

    return response()->json([
        'message' => 'Sesión cerrada correctamente'
    ]);
}
}
