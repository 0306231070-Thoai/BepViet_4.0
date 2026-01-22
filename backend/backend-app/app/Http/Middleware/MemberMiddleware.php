<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MemberMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Nếu chưa đăng nhập hoặc role không phải 'member' thì chặn
        if (!$request->user() || $request->user()->role !== 'member') {
            return response()->json([
                'message' => 'Chỉ thành viên mới được truy cập'
            ], 403);
        }

        return $next($request);
    }
}
