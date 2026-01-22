<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\CookbookController;
// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::get('/home', [HomeController::class, 'index']);
// Protected routes (Yêu cầu đăng nhập)
Route::middleware('auth:sanctum')->group(function () {   
    // Quản lý Profile
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show']);
        Route::put('/update', [ProfileController::class, 'update']);
        Route::post('/avatar', [ProfileController::class, 'uploadAvatar']);
        Route::put('/change-password', [ProfileController::class, 'changePassword']);
    });
    // Quản lý Bộ sưu tập (Cookbooks)
    Route::apiResource('cookbooks', CookbookController::class);
    // Thêm/Xóa món ăn khỏi bộ sưu tập
    Route::post('cookbooks/{id}/add-recipe', [CookbookController::class, 'addRecipe']);
    Route::delete('cookbooks/{id}/recipes/{recipe_id}', [CookbookController::class, 'removeRecipe']);
    
});