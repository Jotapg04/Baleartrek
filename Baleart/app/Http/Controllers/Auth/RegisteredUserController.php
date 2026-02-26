<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
{
    // 1. Validamos TODOS los campos que envías desde React
    $request->validate([
        'name'     => ['required', 'string', 'max:255'],
        'lastname' => ['required', 'string', 'max:255'], // Cambia 'lastName' por 'lastname'
        'dni'      => ['required', 'string', 'max:12', 'unique:users'],
        'phone'    => ['required', 'string', 'max:20'],
        'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        'role_id'  => ['required', 'integer', 'in:2,3'],
    ]);

    // 2. Aquí es donde hacemos la "magia" para la base de datos
    $user = User::create([
        'name'     => $request->name,
        'lastName' => $request->lastname, // 'lastName' (Base de datos) = $request->lastname (React)
        'dni'      => $request->dni,
        'phone'    => $request->phone,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
        'role_id'  => $request->role_id,
    ]);

    event(new Registered($user));

    // Si es una petición de API (desde React), devolvemos JSON
    if ($request->wantsJson() || $request->header('Accept') === 'application/json') {
        return response()->json([
            'message' => 'Usuario registrado con éxito',
            'user' => $user
        ], 201);
    }

    // Por si acaso se usa desde la web tradicional
    Auth::login($user);
    return redirect(route('dashboard', absolute: false));
}
}
