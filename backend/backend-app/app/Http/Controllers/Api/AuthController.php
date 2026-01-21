<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

public function login(Request $request)
{
    try {
        // 1. Validate dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // 2. Tìm người dùng
        $user = User::where('username', $request->username)->first();

        // 3. Kiểm tra sự tồn tại và mật khẩu
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tên đăng nhập hoặc mật khẩu không chính xác.'
            ], 401);
        }

        // 4. Kiểm tra trạng thái tài khoản (Status = 0 là bị khóa)
        if ($user->status == 0) { 
            return response()->json([
                'status' => 'error',
                'message' => 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản trị viên.'
            ], 403);
        }

        // 5. Tạo Token bảo mật (Sanctum)
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'role' => $user->role, // Phân quyền cho đối tượng người dùng [cite: 14, 22]
                'avatar' => $user->avatar, // Hiển thị trên Profile cá nhân [cite: 43]
                'bio' => $user->bio
            ]
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Có lỗi hệ thống xảy ra: ' . $e->getMessage()
        ], 500);
    }
}
   public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        'username' => 'required|string|max:100|unique:users',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $user = User::create([
        'username' => $request->username,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'member', // Mặc định là thành viên
        'status' => 1,      // Hoạt động (Khớp với TINYINT trong DB)
        // bio và avatar không truyền vào đây sẽ tự động mang giá trị NULL
    ]);

    // Lệnh này yêu cầu bảng personal_access_tokens phải có trong DB
    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'status' => 'success',
        'access_token' => $token,
        'user' => $user
    ], 201);
}
   

    /**
 * Xử lý đăng xuất người dùng
 */
public function logout(Request $request)
{
    // Xóa token hiện tại đang dùng để gọi API này
    $request->user()->currentAccessToken()->delete();

    return response()->json([
        'status' => 'success',
        'message' => 'Đã đăng xuất thành công!'
    ]);
}
}