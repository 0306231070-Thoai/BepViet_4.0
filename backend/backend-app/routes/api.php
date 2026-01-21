<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\BlogFeedController;
use App\Http\Controllers\Api\BlogCommentController;
// Public routes (Đăng ký, Đăng nhập, Quên mật khẩu)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
// BLOG FEED & CHI TIẾT BÀI VIẾT
Route::get('/blog-feed', [BlogController::class, 'feed']);
Route::get('/blogs/{id}', [BlogController::class, 'show']);

// Blog comments (xem comment KHÔNG cần login)
Route::get('/blogs/{id}/comments', [BlogCommentController::class, 'index']);

// Protected routes (Yêu cầu đăng nhập qua Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    
    // --- ĐĂNG XUẤT ---
    // Nút màu đỏ cuối danh sách menu
    Route::post('/logout', [AuthController::class, 'logout']);

    // --- NHÓM HỒ SƠ CÁ NHÂN ---
    Route::prefix('profile')->group(function () {
        // Lấy thông tin & Cập nhật thông tin cơ bản
        Route::get('/', [ProfileController::class, 'show']);
        Route::post('/update', [ProfileController::class, 'update']);
        
        // Cập nhật bảo mật & Hình ảnh
        Route::post('/avatar', [ProfileController::class, 'updateAvatar']);
        Route::post('/change-password', [ProfileController::class, 'changePassword']);
    });

    // --- NHÓM THÔNG BÁO ---
    Route::prefix('notifications')->group(function () {
        Route::get('/', [ProfileController::class, 'getNotifications']);
        Route::post('/{id}/read', [ProfileController::class, 'markAsRead']);
        Route::post('/read-all', [ProfileController::class, 'markAllAsRead']);
    });

    // --- KHO MÓN NGON & TƯƠNG TÁC ---
    // Dành cho các mục như "Kho món ngon", "Đang theo dõi" trên Sidebar
    Route::get('/my-recipes', [ProfileController::class, 'getMyRecipes']);
    Route::get('/following', [ProfileController::class, 'getFollowing']);


    

    // BLOG   
    Route::post('/blogs', [BlogController::class, 'store']);
    // BLOG COMMENTS

    // Blog comments (xem comment KHÔNG cần login)
    Route::get('/blogs/{id}/comments', [BlogCommentController::class, 'index']);
});



