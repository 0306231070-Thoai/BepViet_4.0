<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (Cần gửi kèm Token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', function (Request $request) {
        return $request->user();
    });
});

//API ADMIN
Route::middleware(['auth:sanctum','admin'])->prefix('admin')->group(function () {

    Route::get('/users', [AdminUserController::class, 'index']);
    Route::put('/users/{id}/lock', [AdminUserController::class, 'lock']);
    Route::put('/users/{id}/role', [AdminUserController::class, 'changeRole']);

    Route::get('/recipes/pending', [AdminRecipeController::class, 'pending']);
    Route::put('/recipes/{id}/approve', [AdminRecipeController::class, 'approve']);
    Route::put('/recipes/{id}/hide', [AdminRecipeController::class, 'hide']);

    Route::get('/blogs/pending', [AdminBlogController::class, 'pending']);
    Route::put('/blogs/{id}/approve', [AdminBlogController::class, 'approve']);
    Route::put('/blogs/{id}/reject', [AdminBlogController::class, 'reject']);

    Route::get('/reports', [AdminReportController::class, 'index']);
    Route::put('/reports/{id}/resolve', [AdminReportController::class, 'resolve']);
});