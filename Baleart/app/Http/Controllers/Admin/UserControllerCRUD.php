<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class UserControllerCrud extends Controller
{
    /**
     * LISTADO DE USUARIOS
     */
    public function index()
    {
        $users = User::with('role')
            ->orderBy('id', 'asc')
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * VER UN USUARIO
     */
    public function show(User $user)
    {
        $user->load('role');

        return view('admin.users.show', compact('user'));
    }

    /**
     * FORM CREAR
     */
    public function create()
    {
        $roles = Role::all();

        return view('admin.users.create', compact('roles'));
    }

    /**
     * GUARDAR USUARIO
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'dni' => 'required|string|max:20|unique:users,dni',
            'email' => 'required|email|max:100|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        User::create($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuario creado correctamente');
    }

    /**
     * FORM EDITAR
     */
    public function edit(User $user)
    {
        $roles = Role::all();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * ACTUALIZAR USUARIO
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'active' => 'required|boolean',
        ]);

        $user->update($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuario actualizado correctamente');
    }

    /**
     * DAR DE BAJA USUARIO
     */
    public function destroy(User $user)
    {
        $user->update([
            'active' => false
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuario dado de baja correctamente');
    }
}