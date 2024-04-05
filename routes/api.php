<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
/**
 * Declaring all routes from the users resources
 */
    // Route::delete('/users/{id}', [UserController::class, 'deleteUserById']);
    // Route::patch('/users/{id}', [UserController::class, 'updateUser']);
    // Route::get('/users/{id}', [UserController::class, 'getUserById']);
    // Route::post('/users', [UserController::class, 'store']);
    // Route::get('/users', [UserController::class, 'index']);

/**
 * Using the Resource api class to make easily
 */
Route::apiResource('/users', UserController::class);

Route::get('/', function() {
    return response()->json([
        'success' => true
    ]);
});
