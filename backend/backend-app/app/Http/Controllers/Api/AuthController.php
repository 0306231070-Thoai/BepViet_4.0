<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
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
    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'username' => 'required', // React đang gửi username qua trường này
            'password' => 'required',
        ]);

        // Tìm người dùng theo username (khớp với React của bạn)
        $user = User::where('username', $request->username)->first();

       // Kiểm tra user và mật khẩu
if (!$user || !Hash::check($request->password, $user->password)) {
    return response()->json(['message' => 'Thông tin đăng nhập không chính xác.'], 401);
}

// SỬA TẠI ĐÂY: Nếu status là false (0), tức là bị khóa
if (!$user->status) { 
    return response()->json(['message' => 'Tài khoản của bạn đang bị khóa.'], 403);
}

// Nếu vượt qua được các bước trên thì mới tạo Token
$token = $user->createToken('auth_token')->plainTextToken;
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'role' => $user->role,
                'avatar' => $user->avatar,
                'bio' => $user->bio
            ]
        ], 200);
    }

    public function logout(Request $request)
    {
        // Thu hồi token hiện tại
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Đã đăng xuất thành công']);
    }
}