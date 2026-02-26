<?php

use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\IslandController;
use App\Http\Controllers\Api\TrekController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Models\Trek;
use App\Models\User;
use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN
|--------------------------------------------------------------------------
*/

Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);


/*
|--------------------------------------------------------------------------
| BINDINGS
|--------------------------------------------------------------------------
*/

Route::bind('user', function ($value) {
    return is_numeric($value)
        ? User::findOrFail($value)
        : User::where('email', $value)->firstOrFail();
});

Route::bind('trek', function ($value) {
    return is_numeric($value)
        ? Trek::findOrFail($value)
        : Trek::where('reg_number', $value)->firstOrFail();
});


/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (VISITANTE)
|--------------------------------------------------------------------------
*/

Route::get('/trek/featured', [TrekController::class, 'featured']); 
Route::get('/trek', [TrekController::class, 'index']); 
Route::get('/islands', [IslandController::class, 'index']);
Route::get('/trek/{trek}', [TrekController::class, 'show']); 
Route::get('/trek/island/{isla}', [TrekController::class, 'byIsland']);
Route::get('/comments', [CommentController::class, 'index']);
Route::get('/users', [UserController::class, 'index']);

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (USUARIO AUTENTICADO)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {
    
    // 1. Obtener datos del usuario con sus rutas (IMPORTANTE para el perfil)
    Route::get('/user', function (Request $request) {
        return $request->user()->load('meetings.trek');
    });

    // 2. Actualizar y desactivar
    Route::put('/user/update', [UserController::class, 'update']);
    Route::post('/user/deactivate', [UserController::class, 'deactivate']);

    // 3. Gestión de reuniones (Apuntarse y Desapuntarse)
    Route::post('/meetings/{id}/join', function ($id) {
        try {
            $user = Auth::user();
            $meeting = Meeting::findOrFail($id);

            if ($meeting->users()->where('user_id', $user->id)->exists()) {
                return response()->json(['message' => 'Ya estás apuntado a esta excursión'], 400);
            }

            $meeting->users()->attach($user->id);
            return response()->json(['message' => '¡Te has apuntado con éxito!']);
            
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error en el servidor: ' . $e->getMessage()], 500);
        }
    });

    Route::post('/meetings/{id}/leave', function ($id) {
        try {
            $user = Auth::user();
            $meeting = Meeting::findOrFail($id);
            $meeting->users()->detach($user->id);
            return response()->json(['message' => 'Has dejado la excursión correctamente']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al desapuntarse'], 500);
        }
    });
});

/*
|--------------------------------------------------------------------------
| RUTAS ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['MULTI-AUTH', 'CHECK-ROLEADMIN'])->group(function () {

    // CRUD Usuarios
    Route::get('/user/{user}', [UserController::class, 'show']);
    Route::put('/user/{user}', [UserController::class, 'update']);
    Route::patch('/user/{user}', [UserController::class, 'update']);
    Route::delete('/user/{user}', [UserController::class, 'destroy']);

    // CRUD Treks
    Route::post('/trek', [TrekController::class, 'store']);
    Route::put('/trek/{trek}', [TrekController::class, 'update']);
    Route::patch('/trek/{trek}', [TrekController::class, 'update']);
    Route::delete('/trek/{trek}', [TrekController::class, 'destroy']);

});