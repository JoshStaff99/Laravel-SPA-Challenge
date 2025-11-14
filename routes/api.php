<?php

use App\Http\Controllers\Api\MovieController as MovieApiController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the RouteServiceProvider within a group
| which is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public routes
Route::post('/login', [AuthController::class, 'login']); // Login to get token
Route::get('/movies', [MovieApiController::class, 'index']); // List all movies
Route::get('/movies/{movie}', [MovieApiController::class, 'show']); // Show single movie

// Protected routes (require auth:sanctum)
Route::middleware('auth:sanctum')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // CRUD operations for movies
    Route::post('/movies', [MovieApiController::class, 'store']);      // Create
    Route::put('/movies/{movie}', [MovieApiController::class, 'update']);   // Update
    Route::patch('/movies/{movie}', [MovieApiController::class, 'update']); // Partial update
    Route::delete('/movies/{movie}', [MovieApiController::class, 'destroy']); // Delete
});

