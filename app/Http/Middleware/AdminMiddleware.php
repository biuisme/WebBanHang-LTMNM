<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Xử lý yêu cầu truy cập.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Kiểm tra xem người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Bạn cần đăng nhập để tiếp tục!');
        }

        // 2. Kiểm tra xem cột 'role' của người dùng có phải là 'admin' không
        if (Auth::user()->role !== 'admin') {
            // Nếu là 'user' thường thì đá văng ra Trang chủ
            return redirect('/')->with('error', 'Bạn không có quyền truy cập khu vực Quản trị!');
        }

        // 3. Nếu vượt qua cả 2 bài kiểm tra trên -> Cho phép đi tiếp vào trang Admin
        return $next($request);
    }
}
