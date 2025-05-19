<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\JobCategoryController;
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
Route::get('/job-categories', [JobCategoryController::class, 'jobCategories']);

Route::post('company/register', [AuthController::class, 'companyRegister']);
Route::post('/company/login', [AuthController::class, 'companyLogin']);
Route::post('/admin/login', [AuthController::class, 'adminLogin']);
Route::get('verify-company/{user}', [AuthController::class, 'verify'])->name('company.verify');
Route::get('verification-success', [AuthController::class, 'verificationSuccess'])->name('verification.success');
Route::get('verification-already-done', [AuthController::class, 'verificationAlreadyDone'])->name('verification.already.done');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('candidate/profile', [CandidateController::class, 'profile']);
    Route::apiResource('candidate', CandidateController::class);
    Route::apiResource('category', CategoryController::class);
});
