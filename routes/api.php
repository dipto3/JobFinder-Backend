<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\CategoryController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('candidate/register', [AuthController::class, 'register']);
Route::post('/candidate/login', [AuthController::class, 'login']);
Route::get('/categories', [CategoryController::class, 'categories']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('candidate/profile', [CandidateController::class, 'profile']);
    Route::apiResource('candidate', CandidateController::class);
});
