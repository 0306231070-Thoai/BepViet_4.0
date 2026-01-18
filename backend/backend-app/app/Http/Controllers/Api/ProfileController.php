<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
class ProfileController extends Controller
{
    /**
     * Lấy thông tin hồ sơ của người dùng đang đăng nhập
     */
    public function show()
    {
        $user = Auth::user();
        
        // Trả về dữ liệu kèm theo số lượng thống kê (nếu cần hiển thị ở sidebar)
        return response()->json([
            'status' => 'success',
            'data' => $user->loadCount(['recipes', 'followers', 'following'])
        ]);
    }

    /**
     * Cập nhật thông tin cá nhân (Chỉnh sửa)
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate dữ liệu đầu vào khớp với form thiết kế
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'nickname' => 'nullable|string|max:255',
            'phone'    => 'nullable|string|max:15',
            'bio'      => 'nullable|string|max:1000',
            'address'  => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Cập nhật các trường thông tin
        $user->update([
            'username' => $request->username,
            'nickname' => $request->nickname,
            'phone'    => $request->phone,
            'bio'      => $request->bio,
            'address'  => $request->address,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Cập nhật thông tin thành công!',
            'data'    => $user
        ]);
    }

    /**
     * Xử lý tải lên ảnh đại diện riêng biệt
     */
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('avatar')) {
            // Xóa ảnh cũ nếu tồn tại trong storage
            if ($user->avatar && Storage::exists(str_replace('/storage/', 'public/', $user->avatar))) {
                Storage::delete(str_replace('/storage/', 'public/', $user->avatar));
            }

            // Lưu ảnh mới
            $path = $request->file('avatar')->store('public/avatars');
            $user->avatar = Storage::url($path);
            $user->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Đổi ảnh đại diện thành công!',
            'avatar_url' => $user->avatar
        ]);
    }
    public function changePassword(Request $request)
{
    $user = Auth::user();

    // Validate dữ liệu từ form
    $validator = Validator::make($request->all(), [
        'current_password' => 'required',
        'new_password' => 'required|min:8|confirmed', // 'confirmed' yêu cầu trường new_password_confirmation
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'errors' => $validator->errors()
        ], 422);
    }

    // Kiểm tra mật khẩu cũ có khớp không
    if (!Hash::check($request->current_password, $user->password)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Mật khẩu hiện tại không chính xác'
        ], 422);
    }

    // Cập nhật mật khẩu mới
    $user->update([
        'password' => Hash::make($request->new_password)
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'Đổi mật khẩu thành công!'
    ]);
}
/**
 * Lấy danh sách thông báo của người dùng
 */
public function getNotifications()
{
    $user = Auth::user();
    
    return response()->json([
        'status' => 'success',
        'unread_count' => $user->unreadNotifications->count(),
        'notifications' => $user->notifications()->paginate(10)
    ]);
}

/**
 * Đánh dấu tất cả là đã đọc
 */
public function markAsRead()
{
    Auth::user()->unreadNotifications->markAsRead();
    return response()->json(['message' => 'Đã đọc tất cả thông báo']);
}
}