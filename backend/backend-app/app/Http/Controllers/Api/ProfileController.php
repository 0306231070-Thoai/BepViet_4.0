<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * 1. Lấy thông tin cá nhân
     */
    public function show(Request $request)
    {
    $user = $request->user();
    
    // Tách lấy phần trước dấu @ từ email
    $emailPrefix = explode('@', $user->email)[0];

    return response()->json([
        'status' => 'success',
        'data' => [
            'username' => $user->username ?: $emailPrefix, 
            'email'    => $user->email,
            'bio'      => $user->bio,
            'avatar'   => $user->avatar,
        ]
    ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * 2. Cập nhật thông tin (Họ tên, tiểu sử)
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'bio'      => 'nullable|string|max:1000',
        ], [
            'username.unique' => 'Tên người dùng này đã tồn tại.',
            'username.required' => 'Họ và tên không được để trống.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(), // Lấy lỗi đầu tiên trả về message cho React alert
                'errors' => $validator->errors()
            ], 422, [], JSON_UNESCAPED_UNICODE);
        }

        try {
            $user->update([
                'username' => $request->username,
                'bio'      => $request->bio,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thông tin thành công!',
                'data' => $user
            ], 200, [], JSON_UNESCAPED_UNICODE);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 3. Đổi ảnh đại diện
     */
    public function uploadAvatar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error', 
                'message' => 'File ảnh không hợp lệ (định dạng jpg, png và < 2MB)'
            ], 422, [], JSON_UNESCAPED_UNICODE);
        }

        if ($request->hasFile('avatar')) {
            $user = $request->user();
            
            // Xóa ảnh cũ
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Lưu ảnh mới
            $path = $request->file('avatar')->store('avatars', 'public');
            
            $user->avatar = $path;
            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật ảnh đại diện thành công!',
                'data' => ['avatar' => $path],
                'url' => asset('storage/' . $path)
            ], 200, [], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * 4. Đổi mật khẩu (Sửa lỗi "Lỗi ngầm")
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ], [
            'old_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
            'new_password.confirmed' => 'Xác nhận mật khẩu mới không khớp.'
        ]);

        if ($validator->fails()) {
            // Thay vì chỉ trả về errors, ta trả về cả message để React alert được luôn
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 422, [], JSON_UNESCAPED_UNICODE);
        }

        $user = $request->user();

        // Kiểm tra mật khẩu cũ
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mật khẩu hiện tại không chính xác'
            ], 400, [], JSON_UNESCAPED_UNICODE);
        }

        // Cập nhật mật khẩu
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'status' => 'success', 
            'message' => 'Đổi mật khẩu thành công!'
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }
}