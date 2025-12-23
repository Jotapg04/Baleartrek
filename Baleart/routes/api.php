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


// ---- BINDINGS ----
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


// ---- RUTAS PROTEGIDAS ----
Route::middleware('MULTI-AUTH')->group(function () {

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

    // ---- CRUD USUARIOS ----
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/{user}', [UserController::class, 'show']);
    Route::put('/user/{user}', [UserController::class, 'update']);
    Route::patch('/user/{user}', [UserController::class, 'update']);
    Route::delete('/user/{user}', [UserController::class, 'destroy']);

    // ---- CRUD TREKS ----
    Route::get('/trek', [TrekController::class, 'index']);
    Route::get('/trek/{trek}', [TrekController::class, 'show']);
    Route::post('/trek', [TrekController::class, 'store']);
    Route::put('/trek/{trek}', [TrekController::class, 'update']);
    Route::patch('/trek/{trek}', [TrekController::class, 'update']);

    // ---- FILTRADO POR ISLA ----
    Route::get('/trek/island/{isla}', [TrekController::class, 'byIsland']);
});
