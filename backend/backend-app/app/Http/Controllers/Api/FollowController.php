<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    
    public function toggle($id)
    {
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Chưa đăng nhập'
            ], 401);
        }

        $targetUser = User::find($id);
        if (!$targetUser) {
            return response()->json([
                'message' => 'User không tồn tại'
            ], 404);
        }

        // Không cho tự follow
        if ($targetUser->id === Auth::id()) {
            return response()->json([
                'message' => 'Không thể theo dõi chính mình'
            ], 400);
        }

        $authUser = Auth::user();

        $isFollowing = $authUser
            ->following()
            ->where('followed_id', $targetUser->id)
            ->exists();

        if ($isFollowing) {
            $authUser->following()->detach($targetUser->id);
        } else {
            $authUser->following()->attach($targetUser->id);
        }

        return response()->json([
            'isFollowing' => !$isFollowing
        ]);
    }

    
    public function following()
    {
        if (!Auth::check()) {
            return response()->json([]);
        }

        $users = Auth::user()
            ->following()
            ->select('users.id', 'users.username', 'users.avatar')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'username' => $user->username,
                    'avatar' => $user->avatar
                        ? asset('storage/' . $user->avatar)
                        : null,
                ];
            });

        return response()->json($users); 
    }
}
