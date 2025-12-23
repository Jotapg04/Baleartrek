<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    public function index() {
        $users = User::with(['role'])->get();
        return UserResource::collection($users);
    }

    public function show(User $user) {
        return new UserResource($user);
    }

    public function update(UserRequest $request, User $user) {
        $user->update($request->validated());
        return new UserResource($user);
    }

    public function destroy(User $user) {
        $user->delete();
        return new UserResource($user);
    }
}
