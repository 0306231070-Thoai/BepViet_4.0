<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\BlogCommentController;
use App\Http\Controllers\Api\FollowController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);

// Public Blog routes
Route::get('/blogs', [BlogController::class, 'feed']);          // Blog feed
Route::get('/blogs/{id}', [BlogController::class, 'show']);     // Blog detail

// Comment public (xem)
Route::get('/blogs/{id}/comments', [BlogCommentController::class, 'index']);


Route::middleware('auth:sanctum')->group(function () {

    
    Route::post('/logout', [AuthController::class, 'logout']);

    
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show']);
        Route::post('/update', [ProfileController::class, 'update']);
        Route::post('/avatar', [ProfileController::class, 'updateAvatar']);
        Route::post('/change-password', [ProfileController::class, 'changePassword']);
    });

   
    Route::post('/blogs', [BlogController::class, 'store']);
    Route::put('/blogs/{id}', [BlogController::class, 'update']);
    Route::delete('/blogs/{id}', [BlogController::class, 'destroy']);

    
    Route::post('/blogs/{id}/comments', [BlogCommentController::class, 'store']);
    Route::delete('/blog-comments/{id}', [BlogCommentController::class, 'destroy']);


    
    Route::post('/follow/{id}', [FollowController::class, 'toggle']);
    Route::get('/following', [FollowController::class, 'following']);
});
