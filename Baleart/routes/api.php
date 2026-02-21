<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TrekController;
use App\Http\Controllers\Api\IslandController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Models\User;
use App\Models\Trek;

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
| 
*/

Route::get('/trek', [TrekController::class, 'index']); // Catálogo dinámico
Route::get('/islands', [IslandController::class, 'index']); // Necesaria para el menú de islas
Route::get('/trek/{trek}', [TrekController::class, 'show']); // Detalle de excursión
Route::get('/trek/island/{isla}', [TrekController::class, 'byIsland']); // Filtrado por isla
Route::get('/user', [UserController::class, 'index']);

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (USUARIO AUTENTICADO)
|--------------------------------------------------------------------------
*/

Route::middleware('MULTI-AUTH')->group(function () {

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

    
    Route::get('/me', function () {
        return auth()->user();
    });

    Route::put('/me', [UserController::class, 'update']);
    Route::delete('/me', [UserController::class, 'destroy']);

});


/*
|--------------------------------------------------------------------------
| RUTAS ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['MULTI-AUTH', 'CHECK-ROLEADMIN'])->group(function () {

    // CRUD Usuarios (Punto 34 de la rúbrica)
    
    Route::get('/user/{user}', [UserController::class, 'show']);
    Route::put('/user/{user}', [UserController::class, 'update']);
    Route::patch('/user/{user}', [UserController::class, 'update']);
    Route::delete('/user/{user}', [UserController::class, 'destroy']);

    // CRUD Treks (Punto 40 de la rúbrica)
    Route::post('/trek', [TrekController::class, 'store']);
    Route::put('/trek/{trek}', [TrekController::class, 'update']);
    Route::patch('/trek/{trek}', [TrekController::class, 'update']);
    Route::delete('/trek/{trek}', [TrekController::class, 'destroy']);

});