<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Use controller admin 
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminSettingController;

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

    Route::get('/dashboard', [AdminDashboardController::class, 'index']);

    Route::apiResource('/users', AdminUserController::class);
    Route::apiResource('/categories', AdminCategoryController::class);

    Route::get('/posts', [AdminPostController::class, 'index']);
    Route::put('/posts/{id}/approve', [AdminPostController::class, 'approve']);

    Route::get('/reports', [AdminReportController::class, 'index']);
    Route::put('/reports/{id}/resolve', [AdminReportController::class, 'resolve']);

    Route::get('/settings', [AdminSettingController::class, 'index']);
    Route::put('/settings', [AdminSettingController::class, 'update']);
