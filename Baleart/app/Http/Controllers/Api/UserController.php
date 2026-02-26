<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function index() {
        $users = User::with(['role'])->get();
        return UserResource::collection($users);
    }

    public function show(Request $request)
{
    // Usamos 'with' para traer las reuniones y, dentro de ellas, el trek
    $user = $request->user()->load('meetings.trek');
    return response()->json($user);
}

    // Ponemos el "?" para que sea explícitamente opcional y Laravel no se rompa
    public function update(Request $request, ?User $user = null)
    {
        // Si $user es nulo (porque vienes de /user/update), cogemos el autenticado
        $currentUser = $user ?? $request->user();

        // Si por alguna razón no hay usuario (sesión expirada), devolvemos error
        if (!$currentUser) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'lastName' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,' . $currentUser->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $currentUser->update($validated);

        return response()->json([
            'message' => 'Perfil actualizado correctamente',
            'user' => $currentUser
        ]);
    }
public function profile(Request $request) 
{
    // Cargamos al usuario con sus reuniones y la ruta (trek) asociada a cada una
    return $request->user()->load('meetings.trek');
}


public function deactivate(Request $request)
{
    $user = $request->user();
    $user->active = 0;
    $user->save();

    $user->tokens()->delete();

    return response()->json(['message' => 'Cuenta desactivada correctamente']);
}

    public function destroy(User $user) {
        $user->delete();
        return new UserResource($user);
    }
}