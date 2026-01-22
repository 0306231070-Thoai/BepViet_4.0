<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    // Danh sách users
 public function index(Request $request)
    {
        $query = User::query();

        $search = $request->query('search');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('username', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        return response()->json(
            $query->orderByDesc('id')->paginate(10)
        );
    }

    // Khóa / mở nhanh
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin' && $user->status == 1) {
            $adminCount = User::where('role', 'admin')
                ->where('status', 1)
                ->count();

            if ($adminCount <= 1) {
                return response()->json([
                    'message' => 'Không thể khóa admin cuối cùng'
                ], 403);
            }
        }

        $user->status = !$user->status;
        $user->save();

        return response()->json([
            'message' => 'Cập nhật trạng thái thành công',
            'status' => $user->status
        ]);
    }
}