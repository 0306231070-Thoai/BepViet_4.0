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

}