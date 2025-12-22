<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'dni'      => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'phone'    => 'required|string|max:255',
            'password' => 'required|string|min:8'
        ],[
                    'name.required'      => 'El nom és obligatori.',
                    'lastname.required'  => 'El cognom és obligatori.',
                    'email.required'     => 'L\'email és obligatori.',
                    'email.email'        => 'L\'email no té un format correcte.',
                    'email.unique'       => 'Aquest email ja està registrat.',
                    'password.required'  => 'La contrasenya és obligatòria.',
                    'password.min'       => 'La contrasenya ha de tenir almenys 8 caràcters.',
                ]

    );

        $user = User::create([
            'name'     => $data['name'],
            'lastname' => $data['lastname'],
            'dni' => $data['dni'],
            'email'    => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'role_id' => Role::where('name', 'visitant')->first()->id
            
        ]);

        return response()->json([
            'message' => 'User registered',
            'user'    => [
                'id'    => $user->id,
                'email' => $user->email
            ]
        ], 201);
    }
}
