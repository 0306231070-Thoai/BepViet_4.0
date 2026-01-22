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
use App\Http\Controllers\UserTraffic;
use App\Http\Controllers\Admin\RecipeController as AdminRecipeController;

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
    
    //USERS
    Route::get('/users', [AdminUserController::class, 'index']);
    Route::put('users/{id}', [AdminUserController::class, 'update']);
    Route::patch('users/{id}/toggle-status', [AdminUserController::class, 'toggleStatus']);
    Route::apiResource('/categories', AdminCategoryController::class);

    // Recipes
    // Public API xem công thức
   
        Route::get('/recipes/pending', [AdminRecipeController::class, 'pending']);
        Route::get('/recipes/published', [AdminRecipeController::class, 'published']);
        Route::get('/recipes/hidden', [AdminRecipeController::class, 'hidden']);

        Route::get('/recipes/{id} ', [AdminRecipeController::class, 'show']);
        Route::put('/recipes/{id}/approve', [AdminRecipeController::class, 'approve']);
        Route::put('/recipes/{id}/reject', [AdminRecipeController::class, 'reject']);
        Route::put('/recipes/{id}/hide', [AdminRecipeController::class, 'hide']);
   