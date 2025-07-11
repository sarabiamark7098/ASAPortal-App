<?php
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DivisionsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OfficesController;
use App\Http\Controllers\SectionsController;
use App\Models\Sections;

// Login route - no auth middleware here
Route::post('/login', [AuthController::class, 'login']);


// Protected routes - require Sanctum auth
Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('user')->group(function () {
        Route::get('/', function (Request $request) {
            $user = $request->user();
            $user->load('roles', 'permissions');
            return response()->json([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user->getRoleNames(),
                'permissions' => $user->getPermissionNames()
            ]);
        });
    });
    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    });

});
Route::get('/users', [UserController::class, 'getAllUsers']);

Route::get('/divisions', [OfficesController::class, 'fetchDivisions']);
Route::get('/offices/{id}', [OfficesController::class, 'fetchOfficesByDivision']);
Route::post('/register', [AuthController::class, 'register']);

Route::put('/user/update/{id}',[UserController::class, 'updateUser']);
