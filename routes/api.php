<?php
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DivisionsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OfficesController;
use App\Http\Controllers\SectionsController;
use App\Models\Sections;

Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/user', [AuthController::class, 'user'])->name('user');
    });
});

Route::get('/users', [UserController::class, 'getAllUsers']);

Route::get('/divisions', [OfficesController::class, 'fetchDivisions']);
Route::get('/offices/{id}', [OfficesController::class, 'fetchOfficesByDivision']);

Route::put('/user/update/{id}',[UserController::class, 'updateUser']);
