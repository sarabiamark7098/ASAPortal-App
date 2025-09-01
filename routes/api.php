<?php

use App\Http\Controllers\DriverController;
use App\Http\Controllers\SignatoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OfficesController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\VehicleAssignmentController;
use App\Http\Controllers\VehicleRequestController;

Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/user', [AuthController::class, 'user'])->name('user');
    });

    Route::prefix('vehicle-requests')->name('vehicle-requests.')->group(function () {
        Route::post('/', [VehicleRequestController::class, 'store'])->name('store');
        Route::get('/', [VehicleRequestController::class, 'index'])->name('index');
        Route::post('/{id}/process', [VehicleRequestController::class, 'process'])->name('process');
        Route::put('/{id}', [VehicleRequestController::class, 'update'])->name('update');
    });

    Route::prefix('vehicle-assignments')->name('vehicle-assignments.')->group(function () {
        Route::get('/', [VehicleAssignmentController::class, 'index'])->name('index');
    });

    Route::prefix('signatories')->name('signatories.')->group(function () {
        Route::get('/', [SignatoryController::class, 'index'])->name('index');
    });

});

Route::prefix('pdf')->name('pdf.')->group(function () {
    Route::get('/vehicle-request/{id}', [PdfController::class, 'vehicleRequest'])->name('vehicle-request');
    Route::get('/travel-order/{id}', [PdfController::class, 'travelOrder'])->name('travel-order');
    Route::get('/vehicle-cnas/{id}', [PdfController::class, 'vehicleCnas'])->name('vehicle-cnas');
});

Route::get('/users', [UserController::class, 'getAllUsers']);

Route::get('/divisions', [OfficesController::class, 'fetchDivisions']);
Route::get('/offices/{id}', [OfficesController::class, 'fetchOfficesByDivision']);

Route::put('/user/update/{id}', [UserController::class, 'updateUser']);
