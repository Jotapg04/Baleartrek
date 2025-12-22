<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json([
                    'message' => 'Credencials d\'accés invàlides'
                ], 401);
        }

        $user = $request->user();

        return response()->json([
            'token' => $user->createToken('auth-token')->plainTextToken,
            'user'  => [
                'id'    => $user->id,
                'email' => $user->email
            ]
        ]);
    }

    public function destroy(Request $request)
    {
        if($request-> user()){
        $request->user()->currentAccessToken()->delete();
        }
        return response()->json([
            'message' => 'Logged out'
        ]);
    }
}

