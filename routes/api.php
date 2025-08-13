<?php
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OfficesController;
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
    });

    Route::prefix('vehicle-assignments')->name('vehicle-assignments.')->group(function () {
        Route::get('/', [VehicleAssignmentController::class, 'index'])->name('index');
    });

    Route::prefix('signatories')->name('signatories.')->group(function () {
        Route::get('/', [VehicleAssignmentController::class, 'index'])->name('index');
    });

});

Route::prefix('pdf')->name('pdf.')->group(function () {
    Route::get('/vehicle-request/{id}', [VehicleRequestController::class, 'pdf'])->name('pdf');
});

Route::get('/users', [UserController::class, 'getAllUsers']);

Route::get('/divisions', [OfficesController::class, 'fetchDivisions']);
Route::get('/offices/{id}', [OfficesController::class, 'fetchOfficesByDivision']);

Route::put('/user/update/{id}',[UserController::class, 'updateUser']);
