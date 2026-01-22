<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RecipeController;       // import RecipeController
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\Q_AController;
use App\Http\Controllers\AIController;

//admin 
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\UserTraffic;
use App\Http\Controllers\Admin\RecipeController as AdminRecipeController;

Route::post('/ai-suggest', [AIController::class, 'suggest']);
Route::get('/home', [HomeController::class, 'index']);
Route::get('/search', [HomeController::class, 'search']);
// Public routes
// --- Public Routes (Không cần đăng nhập) ---
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

// --- Protected Routes (Yêu cầu Token) ---
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});

// Public API lấy danh mục (không cần token)
// Public API lấy danh sách vùng miền 
Route::get('/categories', [CategoryController::class, 'index']);

// Public API xem chi tiết vùng miền + công thức thuộc vùng miền đó 
Route::get('/categories/{id}', [CategoryController::class, 'show']);


// Protected routes (Cần gửi kèm Token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', function (Request $request) {
        return $request->user();
    });
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show']);

    Route::post('/profile', [ProfileController::class, 'show']);
    Route::get('/profile/update', [ProfileController::class, 'update']);
    Route::put('/profile/update', [ProfileController::class, 'update']);
    Route::get('/profile/avatar', [ProfileController::class, 'uploadAvatar']);
    Route::post('/profile/avatar', [ProfileController::class, 'uploadAvatar']);
    Route::get('/profile/change-password', [ProfileController::class, 'changePassword']);
    Route::put('/profile/change-password', [ProfileController::class, 'changePassword']);
});
Route::get('/questions', [Q_AController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/questions/{id}/reply', [Q_AController::class, 'reply']);
    Route::get('/questions/{id}', [Q_AController::class, 'show']);
});

// Route::get('/login', function () {
//     return response()->json(['message' => 'Unauthenticated (Bạn chưa đăng nhập)'], 401);
// })->name('login'); // <-- Quan trọng: phải đặt tên route là login

// Các route cần bảo vệ
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

// ======= API Công thức (PUBLIC) ======= //
Route::get('/recipes', [RecipeController::class, 'index']);       // Danh sách công thức (public)
Route::get('/recipes/{id}', [RecipeController::class, 'show']);   // Chi tiết công thức (public)

// ======= API Công thức (PROTECTED) ======= //
Route::middleware(['auth:sanctum','member'])->group(function () {
    Route::post('/recipes', [RecipeController::class, 'store']);     // Đăng công thức (member)
    Route::get('/recipes/my', [RecipeController::class, 'myRecipes']); // Công thức của tôi (bao gồm Pending/Published/Hidden)
    Route::put('/recipes/{id}', [RecipeController::class, 'update']); // Sửa công thức (chỉ chủ sở hữu)
    Route::delete('/recipes/{id}', [RecipeController::class, 'destroy']); // Xóa công thức (chỉ chủ sở hữu)
});


//API ADMIN
Route::prefix('admin')
    ->middleware(['auth:sanctum', 'admin'])
    ->group(function () {
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
        //POST 

        Route::get('/posts', [AdminPostController::class, 'index']);
        Route::get('/posts/{id}', [AdminPostController::class, 'show']);

        Route::put('/posts/{id}/approve', [AdminPostController::class, 'approve']);
        Route::put('/posts/{id}/reject', [AdminPostController::class, 'reject']);
        //REPORT
        Route::get('/reports', [AdminReportController::class, 'index']);
        Route::put('/reports/{id}/resolve', [AdminReportController::class, 'resolve']);
        Route::put('/reports/{id}/review', [AdminReportController::class, 'review']);

        //settings
        Route::get('/settings', [AdminSettingController::class, 'index']);
        Route::put('/settings', [AdminSettingController::class, 'update']);

        Route::get('users/traffic', [UserTraffic::class, 'userTraffic']);
    });
