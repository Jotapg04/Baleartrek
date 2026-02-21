<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserControllerCRUD;
use App\Http\Controllers\Admin\CommentControllerCRUD;
use App\Http\Controllers\Admin\InterestingPlaceControllerCRUD;
use App\Http\Controllers\Admin\MunicipalityControllerCRUD;
use App\Http\Controllers\Admin\TrekControllerCRUD;
use App\Http\Controllers\Admin\MeetingControllerCRUD;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::resource('users', UserControllerCRUD::class);
    Route::resource('comments', CommentControllerCRUD::class);
    Route::resource('interesting-places', InterestingPlaceControllerCRUD::class);
    Route::resource('municipalities', MunicipalityControllerCRUD::class);
    Route::resource('treks', TrekControllerCRUD::class);
    Route::resource('meetings', MeetingControllerCRUD::class);
});

require __DIR__.'/auth.php';
