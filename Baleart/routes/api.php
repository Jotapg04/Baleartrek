<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TrekController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Models\User;
use App\Models\Trek;


// ---- AUTENTICACIÓN ----
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

/*Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
});*/
Route::middleware('API-KEY')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
});

// ---- CRUD USUARIOS ----
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/{user}', [UserController::class, 'show']);
    Route::put('/user/{user}', [UserController::class, 'update']);
    Route::patch('/user/{user}', [UserController::class, 'update']);
    Route::delete('/user/{user}', [UserController::class, 'destroy']);

    //Filtrados
    Route::bind('user', function ($value) {
        return is_numeric($value)
            ? User::findOrFail($value) // Cerca per 'id'
            : User::where('email', $value)->firstOrFail(); // Cerca per 'email'
    });
});
// ---- CRUD TREKS ----
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/trek', [TrekController::class, 'index']);
    Route::get('/trek/{trek}', [TrekController::class, 'show']);
    Route::post('/trek', [TrekController::class, 'store']);
    Route::put('/trek/{trek}', [TrekController::class, 'update']);
    Route::patch('/trek/{trek}', [TrekController::class, 'update']);

    //Filtrado
    Route::get('/trek/island/{isla}', [TrekController::class, 'byIsland']);
});
