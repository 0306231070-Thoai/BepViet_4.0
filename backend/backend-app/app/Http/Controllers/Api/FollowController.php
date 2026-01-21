<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Fllow;


class FollowController extends Controller
{
    // Follow / Unfollow
    public function toggle($userId)
    {
        $user = auth()->user();

        if ($user->id == $userId) {
            return response()->json(['message' => 'Cannot follow yourself'], 400);
        }

        $user->following()->toggle($userId);

        return response()->json([
            'isFollowing' => $user->following()->where('users.id', $userId)->exists()
        ]);
    }

    // Danh sách following
    public function following()
    {
        return response()->json(
            auth()->user()->following()->select('id', 'username', 'avatar')->get()
        );
    }
}
